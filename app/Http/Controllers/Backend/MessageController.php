<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Message\MessageRepository;
class MessageController extends Controller
{

    public function __construct( MessageRepository $request ) {
        $this->request = $request;
    }

    public function index() {

        $request = $this->request->getAll();
        return view('backend.Message.index', compact( 'request' ) );
    }

    public function getReviewsJson( Request $request ) {
        $reviews = $this->request->getAll();
        return datatables( $reviews )->toJson();
    }


    public function destroy( $id ) {
        $this->request->delete( $id );

        return redirect()->back()->with( 'success', 'Message successfully deleted!!' );

    }
}
