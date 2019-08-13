<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ProductRequest;
use App\Mail\User;
use App\Product;
use App\ProductFaq;
use App\ProductSpecification;
use App\ProductDownload;
use App\ProductImage;
use App\Suscriber;
use Illuminate\Support\Facades\URL;
use Storage;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Product\ProductRepository;
use App\Helpers\Image\ImageService;
use App\Helpers\Image\LocalImageFile;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $product;
    /**
     * @var CategoryRepository
     */
    private $category;

    public function __construct(ProductRepository $product, CategoryRepository $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productsCount = $this->product->getAll()->count();
        $categories = $this->category->getCategories();

        return view('backend.products.index', compact('productsCount', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->category->getCategories();

        return view('backend.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function store(ProductRequest $request)
    {
        try {

            $this->product->create($request->all());

        } catch (Exception $e) {

            throw new Exception('Error in saving product: ' . $e->getMessage());
        }
        $data2 = [

            'msg' => 'New Product Has Been Added On ' . getConfiguration('company_name'),
            'link' => URL::to('/'),
            'button-name' => 'GO',
            'product-name' => $request['name'],
            'description' => $request['description'],

        ];


        return redirect()->back()->with('success', 'Product successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->product->getById($id);
        $categories = $this->category->getCategories();
        $selectedCategories = $product->categories()->get()->pluck('id')->toArray();

        return view('backend.products.edit', compact('product', 'categories', 'selectedCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function update(Request $request, $id)
    {
        try {

            $this->product->update($id, $request->all());

        } catch (Exception $e) {

            throw new Exception('Error in saving product: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Product successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function destroy($id)
    {
        try {

            $this->product->delete($id);

        } catch (Exception $e) {

            throw new Exception('Error in deleting product: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Product successfully deleted!');
    }

    public function getProductsJson(Request $request)
    {


        $queryProduct = $request->input('product');
        $queryCategory = $request->input('category');


        if (isset($queryProduct) && !isset($queryCategory)) {

            $products = Product::where('name', 'like', "%" . $queryProduct . "%")
                ->where('status', '=', 1)->get();
        } elseif (isset($queryCategory)) {

            $products = Product::whereHas('categories', function ($query) use ($queryProduct, $queryCategory) {
                $query->where('categories.slug', $queryCategory);
                $query->where('products.name', 'like', '%' . $queryProduct . '%');
                $query->where('products.status', '=', 1);
            })->get();
        } else {
            $products = $this->product->getAll();
        }

        foreach ($products as $productKey => $productValue) {
            $products[$productKey]['price'] = $productValue->getPrice();
            $products[$productKey]['path'] = optional($productValue->getImageAttribute())->smallUrl;

        }

        return datatables($products)->toJson();
    }

    public function uploadImage(Request $request)
    {
        $image = $request->file('image');
        $tmpPath = str_split(strtolower(str_random(3)));
        $checkDirectory = '/uploads/product/images/' . implode('/', $tmpPath);

        $dbPath = $checkDirectory . '/' . $image->getClientOriginalName();

        $imageService = new ImageService();
        $image = $imageService->upload($image, $checkDirectory);

        $tmp = $this->_getTmpString();

        return view('backend.products.upload-image')
            ->with('image', $image)
            ->with('tmp', $tmp);
    }

    public function deleteImage(Request $request)
    {
        $collection = ProductImage::where('path', $request->input('path'))->get(['id']);

        ProductImage::destroy($collection->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Image successfully deleted.',
        ]);
    }

    public function deleteFaq(Request $request)
    {
        $faq = ProductFaq::findOrFail($request->input('faq'));

        $faq->delete();

        return response()->json([
            'success' => true,
            'message' => 'Faq successfully deleted!!'
        ]);
    }

    public function deleteSpecification(Request $request)
    {
        $specification = ProductSpecification::findOrFail($request->input('specification'));

        $specification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Specification successfully deleted!!'
        ]);
    }

    public function deleteDownload(Request $request)
    {
        $download = ProductDownload::findOrFail($request->input('download'));

        $download->delete();

        return response()->json([
            'success' => true,
            'message' => 'Download successfully deleted!!'
        ]);
    }

    public function downloadFileUpload(Request $request)
    {
        $file = $this->uploadFile($request->file('file'));
        $fileName = route('welcome') . '/storage/downloads/' . $file;

        return response()->json([
            'success' => true,
            'fileName' => $fileName,
            'message' => 'File successfully uploaded!!'
        ]);
    }

    protected function uploadFile($file)
    {
        // Store file
        $path = Storage::put('public/downloads', $file, 'public');
        // Get stored file name
        $fileName = explode('public/downloads/', $path);

        // File name
        return $fileName[1];
    }

    public function _getTmpString($length = 6)
    {
        $pool = 'abcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    public function searchProduct(Request $request)
    {
        $term = trim($request->input('q'));
        if (empty($term)) {
            return response()->json([], 200);
        }

        $products = DB::table('products')->where('name', 'like', '%' . $term . '%')->orderBy('name')->take(15)->get();

        $formattedProducts = [];

        foreach ($products as $productKey => $productValue) {
            $formattedProducts[] = ['id' => $productValue->id, 'text' => $productValue->name];
        }

        return response()->json($formattedProducts, 200);

    }
}