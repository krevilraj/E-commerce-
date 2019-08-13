<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

class BackgroundController extends Controller
{
    public function save(Request $request){


        $this->validate($request, [

            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        if ($request->file('image')->isValid()) {

            $file = $request->file('image');

            Storage::disk('public')->putFileAs('background', $file, 'background.jpeg');

            return redirect()->back()->with('success', 'Background Image Saved!');


        }


        }

}
