<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\SlideshowRequest;
use App\Repositories\Slideshow\SlideshowRepository;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlideshowController extends Controller
{
	/**
	 * @var SlideshowRepository
	 */
	private $slideshow;

	public function __construct(SlideshowRepository $slideshow) {
		$this->slideshow = $slideshow;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $slideshowsCount = $this->slideshow->getAll()->count();

	    return view( 'backend.slideshows.index', compact( 'slideshowsCount' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    return view( 'backend.slideshows.create' );
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param SlideshowRequest|Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
    public function store(SlideshowRequest $request)
    {
	    try {

		    $this->slideshow->create( $request->all() );

	    } catch ( Exception $e ) {

		    throw new Exception( 'Error in saving slideshow: ' . $e->getMessage() );
	    }

	    return redirect()->back()->with( 'success', 'Slideshow successfully created!' );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $slideshow = $this->slideshow->getById( $id );

	    return view( 'backend.slideshows.edit', compact( 'slideshow' ) );
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param SlideshowRequest|Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 * @throws Exception
	 */
    public function update(Request $request, $id)
    {
	    try {

		    $this->slideshow->update( $id, $request->all() );

	    } catch ( Exception $e ) {

		    throw new Exception( 'Error in updating slideshow: ' . $e->getMessage() );
	    }

	    return redirect()->back()->with( 'success', 'Slideshow successfully updated!!' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    $this->slideshow->delete( $id );

	    return redirect()->back()->with( 'success', 'Slideshow successfully deleted!!' );
    }

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getSlideshowsJson( Request $request ) {
		$slideshows = $this->slideshow->getAll();

		foreach ( $slideshows as $slideshow ) {
			$slideshow->author         = $slideshow->user->full_name;
			$image                = null !== $slideshow->getImage() ? $slideshow->getImage()->smallUrl : $slideshow->getDefaultImage()->smallUrl;
			$slideshow->featured_image = $image;
		}

		return datatables( $slideshows )->toJson();
	}
}
