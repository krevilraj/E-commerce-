<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class NavController extends Controller
{
    public function brand(){


        $products = Product::orderBy('created_at','DESC');






return View('pages.templates.shop',compact('products'));
    }


    public function flash_deals(){


        $products = Product::orderBy('created_at','DESC');



        return View('pages.templates.shop',compact('products'));
    }
    public function best_selling(){


        $products = Product::orderBy('created_at','DESC');



        return View('pages.templates.shop',compact('products'));
    }
    public function tech_discovery(){


        $products = Product::orderBy('created_at','DESC');



        return View('pages.templates.shop',compact('products'));
    }
    public function trending_style(){


        $products = Product::orderBy('created_at','DESC');



        return View('pages.templates.shop',compact('products'));
    }

}
