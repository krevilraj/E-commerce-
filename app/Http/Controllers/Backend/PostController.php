<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\PostRequest;
use App\Mail\User;
use App\Media;
use App\Repositories\Post\PostRepository;
use App\Suscriber;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    private $post;

    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postsCount = $this->post->getAll()->count();

        return view('backend.posts.index', compact('postsCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function store(PostRequest $request)
    {
        try {

            $this->post->create($request->all());

        } catch (Exception $e) {

            throw new Exception('Error in saving page: ' . $e->getMessage());
        }
        $data2 = [

            'msg' => 'New Post Has Been Added  On ' . getConfiguration('company_name'),
            'link' => URL::to('/') . '/blog',
            'button-name' => 'GO',
            'post-title' => $request['title'],
            'post-content' => $request['content']

        ];
        $suscribers = Suscriber::where('status', '1')->get();

        foreach ($suscribers as $user) {

            \Mail::to($user->email)->send(new User($data2));
        }

        return redirect()->back()->with('success', 'Post successfully created!');
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
        $post = $this->post->getById($id);

        return view('backend.posts.edit', compact('post'));
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

            $this->post->update($id, $request->all());

        } catch (Exception $e) {

            throw new Exception('Error in updating post: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Post successfully updated!');
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

            $this->post->delete($id);

        } catch (Exception $e) {

            throw new Exception('Error in updating post: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Post successfully deleted!');
    }

    public function getPostsJson(Request $request)
    {
        $posts = $this->post->getAll();

        foreach ($posts as $post) {
            $post->author = $post->user->full_name;
            $image = null !== $post->getImage() ? $post->getImage()->smallUrl : $post->getDefaultImage()->smallUrl;
            $post->featured_image = $image;
        }

        return datatables($posts)->toJson();
    }
}
