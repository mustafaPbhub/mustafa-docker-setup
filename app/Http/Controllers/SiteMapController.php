<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Slider;
use App\Models\Product;
use App\Models\HomeAdsBanner;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
class SiteMapController extends Controller
{
    public $siteMapDirectory = 'sitemaps';
    public function run_all(){
        $this->sitemap();
        $this->pages();
        $this->blogs();
        $this->blogs_category();
        $this->blogs_images();
        $this->blogs_category_images();
        $this->category_images();
        $this->stores_category();
        $this->stores();
        $this->stores_images();
    }
    public function sitemap(){
        $data  = [
            array('url' => url(asset($this->siteMapDirectory.'/pages.xml')) ,'priority' =>0.8 , 'changeFreq' => 'monthly', 'lastmod' => Carbon::now()->toIso8601String()),
            array('url' => url(asset($this->siteMapDirectory.'/blogs.xml')) ,'priority' =>1.0 , 'changeFreq' => 'daily', 'lastmod' => ($blog = Blog::latest('updated_at')->first()) ? ($blog->updated_at->gt($blog->created_at) ? $blog->updated_at->toIso8601String() : $blog->created_at->toIso8601String()) : Carbon::now()->toIso8601String()),
            array('url' => url(asset($this->siteMapDirectory . '/blog-category.xml')),'priority' => 0.6,'changeFreq' => 'monthly','lastmod' => ($blogcategory = BlogCategory::latest('updated_at')->first()) ? ($blogcategory->updated_at->gt($blogcategory->created_at) ? $blogcategory->updated_at->toIso8601String() : $blogcategory->created_at->toIso8601String()) : Carbon::now()->toIso8601String()),
            array('url' => url(asset($this->siteMapDirectory.'/blogs-images.xml')) ,'priority' =>0.4 , 'changeFreq' => 'monthly', 'lastmod' => ($blog = Blog::latest('updated_at')->first()) ? ($blog->updated_at->gt($blog->created_at) ? $blog->updated_at->toIso8601String() : $blog->created_at->toIso8601String()) : Carbon::now()->toIso8601String()),
            array('url' => url(asset($this->siteMapDirectory.'/blog-category-images.xml')) ,'priority' =>0.4 , 'changeFreq' => 'monthly', 'lastmod' => ($blogcategory = BlogCategory::latest('updated_at')->first()) ? ($blogcategory->updated_at->gt($blogcategory->created_at) ? $blogcategory->updated_at->toIso8601String() : $blogcategory->created_at->toIso8601String()) : Carbon::now()->toIso8601String()),
            array('url' => url(asset($this->siteMapDirectory.'/stores-category.xml')) ,'priority' =>0.6 , 'changeFreq' => 'monthly', 'lastmod' => ($category = Category::latest('updated_at')->first()) ? ($category->updated_at->gt($category->created_at) ? $category->updated_at->toIso8601String() : $category->created_at->toIso8601String()) : Carbon::now()->toIso8601String()),
            array('url' => url(asset($this->siteMapDirectory.'/stores-images.xml')) ,'priority' =>0.4 , 'changeFreq' => 'monthly', 'lastmod' => ($store = Store::latest('updated_at')->first()) ? ($store->updated_at->gt($store->created_at) ? $store->updated_at->toIso8601String() : $store->created_at->toIso8601String()) : Carbon::now()->toIso8601String()),
            array('url' => url(asset($this->siteMapDirectory.'/stores.xml')) ,'priority' =>1.0 , 'changeFreq' => 'weekly', 'lastmod' => ($store = Store::latest('updated_at')->first()) ? ($store->updated_at->gt($store->created_at) ? $store->updated_at->toIso8601String() : $store->created_at->toIso8601String()) : Carbon::now()->toIso8601String()),
            array('url' => url(asset($this->siteMapDirectory.'/category-images.xml')) ,'priority' =>0.4 , 'changeFreq' => 'monthly', 'lastmod' => ($category = Category::latest('updated_at')->first()) ? ($category->updated_at->gt($category->created_at) ? $category->updated_at->toIso8601String() : $category->created_at->toIso8601String()) : Carbon::now()->toIso8601String()),
        ];
        generate_sitemap($data , $this->siteMapDirectory , 'sitemap.xml');
    }
    public function pages() {
        $latestDate = collect([
            optional(Blog::latest('updated_at')->first())->updated_at,
            optional(Blog::latest('created_at')->first())->created_at,
            optional(Slider::latest('updated_at')->first())->updated_at,
            optional(Slider::latest('created_at')->first())->created_at,
            optional(Product::latest('updated_at')->first())->updated_at,
            optional(Product::latest('created_at')->first())->created_at,
            optional(HomeAdsBanner::latest('updated_at')->first())->updated_at,
            optional(HomeAdsBanner::latest('created_at')->first())->created_at,
        ])->filter()->max();

        $lastmod = $latestDate ? $latestDate->toIso8601String() : Carbon::now()->toIso8601String();
        $data = [
            array('url'=>route('home') ,'priority' => 1.0, 'changeFreq' => 'daily', 'lastmod' => $lastmod),
            array('url' => route('blogs'),'priority' => 1.0,'changeFreq' => 'daily','lastmod' => ($blog = Blog::latest('updated_at')->first()) ? ($blog->updated_at->gt($blog->created_at) ? $blog->updated_at->toIso8601String() : $blog->created_at->toIso8601String()) : Carbon::now()->toIso8601String()),
            array('url' => route('stores'),'priority' => 0.7,'changeFreq' => 'weekly','lastmod' => ($store = Store::latest('updated_at')->first()) ? ($store->updated_at->gt($store->created_at) ? $store->updated_at->toIso8601String() : $store->created_at->toIso8601String()) : Carbon::now()->toIso8601String()),
            array('url' => route('categories'),'priority' => 0.7,'changeFreq' => 'weekly','lastmod' => ($category = Category::latest('updated_at')->first()) ? ($category->updated_at->gt($category->created_at) ? $category->updated_at->toIso8601String() : $category->created_at->toIso8601String()) : Carbon::now()->toIso8601String()),
            array('url'=>route('impressum') ,'priority' =>0.3, 'changeFreq' => 'yearly', 'lastmod' => Carbon::now()->toIso8601String()),
            array('url'=>route('aboutus') ,'priority' =>0.5, 'changeFreq' => 'yearly', 'lastmod' => Carbon::now()->toIso8601String()),
            array('url'=>route('termsandconditions') ,'priority' =>0.3, 'changeFreq' => 'yearly', 'lastmod' => Carbon::now()->toIso8601String()),
            array('url'=>route('privacyandpolicy') ,'priority' =>0.3, 'changeFreq' => 'yearly', 'lastmod' => Carbon::now()->toIso8601String()),
        ];

        generate_sitemap($data , $this->siteMapDirectory , 'pages.xml');
    }

    public function blogs() {
        $blogsData = Blog::where('published_status', 1)->withoutTrashed()->select(['slug','created_at','updated_at'])->get();
        $data  = [];
        foreach ($blogsData as $key => $blog) {
            $data[$key] =[
                'url' =>route('blog_details', strtolower($blog->slug)),
                'lastmod' => $blog->updated_at->toIso8601String() ?? $blog->created_at->toIso8601String(),
                'priority' => '1.0',
                'changeFreq' => 'monthly'
            ];
        }
        generate_sitemap($data ,  $this->siteMapDirectory ,'blogs.xml') ;
    }
    public function blogs_category(){
        $blogsData = BlogCategory::withoutTrashed()->latest()->select(['slug','created_at','updated_at'])->get();
        $data  = [] ;
        foreach($blogsData as $key => $value){
            $data[$key] = [
                'url' => route('blog_category', $value->slug),
                'lastmod' => $value->updated_at->toIso8601String() ?? $value->created_at->toIso8601String(),
                'priority' => '0.7',
                'changeFreq' => 'weekly'
            ];
        }
        generate_sitemap($data , $this->siteMapDirectory ,'blog-category.xml');
    }
    public function blogs_images(){
        $blogsData = Blog::where('published_status', 1)->withoutTrashed()->select(['image','created_at','updated_at'])->get();
        $data      = array();
        foreach($blogsData as $key => $value){
            $data[$key] = [
                'url' =>url(asset('images/blogsImages/'.$value->image)),
                'lastmod' => $value->updated_at->toIso8601String() ?? $value->created_at->toIso8601String(),
                'priority' => '0.4',
                'changeFreq' => 'monthly',
            ];

        }
        generate_sitemap($data,$this->siteMapDirectory,'blogs-images.xml');
    }
    //  Stores
    public function blogs_category_images(){
        $blogsData = BlogCategory::withoutTrashed()->select(['image','created_at','updated_at'])->get();
        $data     = array();
        foreach($blogsData as $key => $value){
             $data[$key] = [
                'url' => url(asset('images/BlogCategoriesImages/'.$value->image)),
                'lastmod' => $value->updated_at->toIso8601String() ?? $value->created_at->toIso8601String(),
                'priority' => '0.4',
                'changeFreq' => 'monthly'
            ];

        }
        generate_sitemap($data,$this->siteMapDirectory,'blog-category-images.xml');
    }
    public function category_images(){
        $blogsData = Category::latest()->select(['image','updated_at','created_at'])->get();
        $data      = array();
        foreach($blogsData as $key => $value){
             $data[$key] = [
                'url' =>url(asset('images/CategoriesImages/'.$value->image)),
                'lastmod' => $value->updated_at->toIso8601String() ?? $value->created_at->toIso8601String(),
                'priority' => '0.4',
                'changeFreq' => 'monthly'
            ];

        }
        generate_sitemap($data,$this->siteMapDirectory,'category-images.xml');
    }

    public function stores(){
        $storeData  = Store::withoutTrashed()->select(['slug', 'updated_at', 'created_at'])->latest()->get();
        $data       = array();
        foreach($storeData as $key => $value){
             $data[$key] = [
                'url' => route('store_details', $value->slug),
                'lastmod' => $value->updated_at->toIso8601String() ?? $value->created_at->toIso8601String(),
                'priority' => '1.0',
                'changeFreq' => 'weekly'
             ];
        }
        generate_sitemap($data,$this->siteMapDirectory,'stores.xml');
    }
    public function stores_category(){
        $blogsData = Category::select(['name','slug','created_at','updated_at'])->latest()->get();
        $data     = [];
        foreach($blogsData as $key => $value){
            $data[$key] = [
                'url' => route('category_details', str_replace(" " , '-' , strtolower($value->slug))),
                'lastmod' => $value->updated_at->toIso8601String() ?? $value->created_at->toIso8601String(),
                'priority' => '0.7',
                'changeFreq' => 'weekly'
            ];
        }
        generate_sitemap($data,$this->siteMapDirectory, 'stores-category.xml');
    }
    public function stores_images(){
        $blogsData  = Store::latest()->get();
        $data       = [] ;
        foreach($blogsData as $key => $value){
            $storeImage  = url(asset('images/StoreImages/'.$value->image));
            $data[$key] = [
                'url' =>$storeImage,
                'lastmod' => $value->updated_at->toIso8601String() ?? $value->created_at->toIso8601String(),
                'priority' => '0.5',
                'changeFreq' => 'monthly'
            ];
        }
        generate_sitemap($data,$this->siteMapDirectory, 'stores-images.xml');

    }


}
