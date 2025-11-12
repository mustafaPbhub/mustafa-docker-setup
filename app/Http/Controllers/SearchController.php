<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Coupon;
use App\Models\Store;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $search   =  $request->search;
        $blogs    =  Blog::where("title" , 'LIKE' ,'%' . $search.'%')->where('published_status', 1)->limit(5)->latest()->get();
        $coupons  =  Coupon::where("offer_name" , 'LIKE' ,'%' . $search.'%')->withoutTrashed()->with('stores', function($query){$query->withoutTrashed();})->latest()->limit(5)->get();
        $store    =  Store::where("name" , 'LIKE' ,'%' . $search.'%')->latest()->limit(5)->get();

        return response()->json([
            'blogs' => $blogs,
            'Coupons' => $coupons,
            'Store' => $store
        ]);
    }
}
