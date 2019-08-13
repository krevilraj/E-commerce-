<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\About\AboutRepository;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AboutController extends Controller
{
    private $about;

    public function __construct( AboutRepository $about ) {
        $this->about = $about;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $aboutCount = $this->about->getAll()->count();

        return view( 'backend.founder.index', compact( 'aboutCount' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view( 'backend.founder.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TestimonialRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function store( Request $request ) {
        try {

            $this->about->create( $request->all() );

        } catch ( Exception $e ) {

            throw new Exception( 'Error in saving page: ' . $e->getMessage() );
        }

        return redirect()->back()->with( 'success', 'Message successfully created!' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $testimonial = $this->about->getById( $id );

        return view( 'backend.about.edit', compact( 'about' ) );
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
    public function update( Request $request, $id ) {
        try {

            $this->about->update( $id, $request->all() );

        } catch ( Exception $e ) {

            throw new Exception( 'Error in updating Message: ' . $e->getMessage() );
        }

        return redirect()->back()->with( 'success', 'Message successfully updated!' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function destroy( $id ) {
        try {

            $this->about->delete( $id );

        } catch ( Exception $e ) {

            throw new Exception( 'Error in updating Message: ' . $e->getMessage() );
        }

        return redirect()->back()->with( 'success', 'Message successfully deleted!' );
    }

    public function getReviewsJson( Request $request ) {
        $about = $this->about->getAll();
        return datatables( $about )->toJson();
    }
}
