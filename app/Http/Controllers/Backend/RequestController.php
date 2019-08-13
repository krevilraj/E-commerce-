<?php

namespace App\Http\Controllers\Backend;

use App\Suscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Request\RequestRepository;
class RequestController extends Controller
{
    private $request;

    public function __construct( RequestRepository $request ) {
        $this->request = $request;
    }

    public function index() {

        $request = $this->request->getAll();
        return view('backend.request.index', compact( 'request' ) );
    }

    public function getReviewsJson( Request $request ) {
        $reviews = $this->request->getAll();
        return datatables( $reviews )->toJson();
    }
    public function getSuscriberJson( Request $request ) {
        $reviews = Suscriber::all();
        return datatables( $reviews )->toJson();
    }
  public function getSuscriber( Request $request ) {
        $reviews = Suscriber::all();
        return view('backend.suscriber.index', compact( 'reviews' ) );
    }


    public function destroy( $id ) {
        $this->request->delete( $id );

        return redirect()->back()->with( 'success', 'Request successfully deleted!!' );

    }
 public function suscriberdestroy( $id ) {

       $sus=Suscriber::where('id',$id)->first();
$sus->delete();
        return redirect()->back()->with( 'success', 'Suscriber successfully deleted!!' );

    }
}
