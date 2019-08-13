<?php

namespace App\Http\Controllers\Backend;

use App\Product;
use App\ProductEnquiry;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;

class ProductEnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enq = ProductEnquiry::all();
        return view('backend.product-enquiries.index', compact('enq'));
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
        $enquiry = ProductEnquiry::findOrFail($id);

        return view('backend.product-enquiries.edit', compact('enquiry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $enquiry = ProductEnquiry::findOrFail($id);
        $pid = $enquiry->product_id;
        $product_name = Product::findOrFail($pid);
        $user = User::findOrFail($enquiry->user_id);
        $enquiry->discount = $request->input('discount');
        $enquiry->save();


        $data = [
            'product' => $product_name->name,
            'name' => $user->first_name,
            'link' => URL::to('/').'/my-account/enquiries',


        ];
        Mail::send('emails.enquiry-updated', $data, function ($message) {
            $message->to('basantadahal230@gmail.com', getConfiguration('company_name'))->subject
            ('Order Received');
            $message->from(getConfiguration('order_email'), getConfiguration('company_name'));
        });

        return redirect()->back()->with('success', 'Enquiry successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = ProductEnquiry::where('id', $id)->firstorFail();
        $delete->delete();

        return redirect()->back()->with('success', 'Enquiry successfully Deleted!');

    }

    public function getEnquiriesJson()
    {
        $enquiries = ProductEnquiry::orderBy('id', 'DESC')->get();

        foreach ($enquiries as $enquiry) {
            $discount = $enquiry->discount;

            if ($discount) {
                $price = $enquiry->product->getPrice() * $enquiry->quantity;
                $priceTotal = $price - ($price * ($discount / 100));
                $priceTotal = 'RS ' . $priceTotal;

            } else {
                $priceTotal = '-';
            }

            $enquiry['client'] = $enquiry->user->full_name;

            $enquiry['product_id'] = $enquiry->product->id;
            $enquiry['discount_percentage'] = $enquiry->discount;

            $enquiry['product_name'] = $enquiry->product->name;
            $enquiry['price'] = $priceTotal;
            $enquiry['original'] = $enquiry->product->getPrice();
        }

        return datatables($enquiries)->toJson();
    }
}
