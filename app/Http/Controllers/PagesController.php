<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Blog, BlogCategory, Category, Coupon, HomeAdsBanner, ImpressumSetting, Product, Slider, Store, Redirection, Setting, SocialLink, ImageDimensionSetting, BlogComment, UsefulLink};
use Illuminate\Support\Facades\Config;

class PagesController extends Controller
{
    public function home()
    {

        $data['slider'] = Slider::where('active', 1)->orderBy('sort_order', 'asc')->latest()->get();
        $data['product'] = Product::with(['stores', 'images'])->where('active', 1)->get();
        $data['blogcategories'] = BlogCategory::where('home_featured', 1)->limit(8)->get();
        $data['blog_featured'] = Blog::where('published_status', 1)->where('home_featured', 1)->orderBy('id', 'desc')->first();
        $data['blogs_featured'] = Blog::where('published_status', 1)->where('home_featured', 1)->orderBy('id', 'desc')->whereNot('slug', $data['blog_featured']->slug)->limit(3)->get();
        $data['latest_blogs'] = Blog::where('published_status', 1)->whereHas('categories', function ($query) {
            $query->orderBy('created_at', 'desc')->where('published_status', 1)->limit(1);
        })->latest()->limit(6)->get();
        $data['productSize'] = ImageDimensionSetting::where('module', 'products')->orderBy('id', 'desc')->first();
        $data['products'] = Product::latest()->where('active', 1)->with('stores')->limit(12)->get();
        $data['blogs_newest'] = Blog::inRandomOrder()->where('published_status', 1)->latest()->first();
        return view('User.home', $data);
    }
    public function blogs()
    {
        try {
            $data['blogs']           = Blog::where('published_status', 1)->latest()->paginate(20);
            // !!newer
            return view('User.blog', $data);
        } catch (\Exception $e) {
            dd($e);
            abort(404);
        }
    }
    public function draft_preview($slug)
    {
        try {
            $data['blog'] = Blog::where('slug', $slug)->where('published_status', 0)->first();
            if (empty($data['blog'])) {
                return redirect(route('blogs'))->with('error', "No Blog found For the URL");
            }
            $data['blogcategories'] = BlogCategory::latest()->limit(8)->get();
            $data['trending_blogs'] = Blog::inRandomOrder()->where('published_status', 1)->latest()->orderBy('views', 'desc')->limit(5)->get();
            $data['latest_blogs'] = Blog::inRandomOrder()->where('published_status', 1)->latest()->limit(4)->get();
            $data['recent_blogs'] = Blog::where('published_status', 1)->latest()->orderBy('id', 'desc')->limit(5)->get();

            return view('User.blog_details', $data);
        } catch (\Exception $e) {
            return redirect(route('blogs'))->with('error', "No Blog Found with the URL");
        }
    }
    public function blog_details($name = null)
    {
        try {
            $routeCheck = Redirection::check_url('blog_details');
            if ($routeCheck) {
                return redirect($routeCheck['route'], $routeCheck['statusCode']);
            }
            $data['blog'] = Blog::where('slug', $name)->where('published_status', 1)->first();
            $data['comments']       = BlogComment::where('status', 1)->where('blog_id', $data['blog']->id)->with(['replies' => function ($query) {
                $query->where('status', 1)->orderBy('id', 'desc');
            }])->get();
            $data['coupons'] = Coupon::where('store_id', $data['blog']->store_id)->whereHas('stores', function ($query) {})->with([
                'stores' => function ($query) {
                    $query->whereNull('deleted_at');
                }
            ])->limit(4)->get();

            if (empty($data['blog'])) {
                abort(404);
            }
            $data['blogcategories'] = BlogCategory::latest()->limit(8)->get();
            $data['trending_blogs'] = Blog::inRandomOrder()->where('published_status', 1)->latest()->orderBy('views', 'desc')->limit(5)->get();
            $data['recent_blogs'] = Blog::where('published_status', 1)->latest()->orderBy('id', 'desc')->limit(5)->get();
            $data['latest_blogs'] = Blog::inRandomOrder()->where('published_status', 1)->latest()->limit(4)->get();



            // ** new
            $data['similar_blog'] = Blog::where('category_id', $data['blog']->categories->id)->where('published_status', 1)->whereNot('slug', $name)->first();
            $data['same_category_blogs'] = Blog::where('category_id', $data['blog']->category_id)
                ->where('published_status', 1)
                ->where('id', '!=', $data['blog']->id) // Exclude the current blog
                ->latest()
                ->limit(6)->get();
            $data['random_blogs'] = Blog::inRandomOrder()->where('published_status', 1)->whereNot('slug', $name)->limit(8)->get();
            $data['related_blogs'] = Blog::where('category_id', $data['blog']->categories->id)->whereNot('slug', $name)->where('published_status', 1)->offset(1)->limit(4)->get();
            // ** new

            return view('User.blog_details', $data);
        } catch (\Exception $e) {
            abort(404);
        }
    }
    public function stores()
    {
        try {
            $data['stores'] = Store::where('name', 'LIKE', strtolower('A') . '%')->get();
            $data['letters'] = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0-9');
            $data['lettersCount'] = count($data['letters']);
            return view('User.store', $data);
        } catch (\Exception $e) {
            abort(404);
        }
    }
    public function get_stores(Request $request)
    {
        try {
            $firstLetter = strtolower($request->letter);
            $data = Store::where('name', 'LIKE', $firstLetter . '%')->get();
            if ($firstLetter == '0-9') {
                $data = Store::where('name', 'REGEXP', '^[0-9]')
                    ->get();
            }
            if ($data->count() > 0) {
                return response()->json(['stores' => $data]);
            } else {
                return response()->json(['stores' => 'empty']);
            }
        } catch (\Exception $e) {
            abort(404);
        }
    }
    public function store_details($name = null)
    {
        try {
            $routeCheck = Redirection::check_url('store_details');
            if ($routeCheck) {
                return redirect($routeCheck['route'], $routeCheck['statusCode']);
            }
            $deactiveStore = Store::where('slug', $name)->where('deactive_store', 1)->first();
            if ($deactiveStore) {
                return $this->blog_category($name, $deactiveStore->id, 'store');
            }
            $data['store'] = Store::where('slug', $name)->with([
                'coupons' => function ($query) {
                    $query->orderBy('sort_order', 'asc')->get();
                },
                'store_faqs'
            ])->first();
            $data['dynamicData']         = Setting::where('page', 'store')->first();
            $data['same_category_blogs'] = Blog::where('store_id', $data['store']->id)
                ->where('published_status', 1)
                ->latest()
                ->limit(6)->get();
            $data['popularStores'] = Store::where('editor_choice', 1)->whereNull('deleted_at')->whereNot('name', $name)->orderBy('id', 'desc')->limit(6)->get();
            $data['popularCategories'] = Category::where('home_featured', 1)->whereNot('name', $name)->orderBy('id', 'desc')->limit(6)->get();
            $data['social'] = SocialLink::all();
            $data['imageSize'] = ImageDimensionSetting::where('module', 'stores')->orderBy('id', 'desc')->first();
            $data['banner'] = HomeAdsBanner::whereHas('pages', function ($query) {
                $query->where('name', 'coupon-sidebar')->where('status', 1);
            })->with('pages')->first();

            if (!empty($data['store'])) {
                // $data['similar_stores'] = Store::where('category', $data['store']->category)->whereNot('id', $data['store']->id)->limit(10)->get();
                // $data['similar_categories'] = Category::inRandomOrder()->limit(10)->get();
                // $data['stores'] = Store::inRandomOrder()->limit(5)->get();
                $data['cate_stores'] = Coupon::inRandomOrder()->whereHas('stores', function ($query) use ($data) {
                    $query->where('category', $data['store']->category)->whereNot('id', $data['store']->id);
                })->limit(5)->get();
                return view('User.store_details', $data);
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            abort(404);
        }
    }
    public function blog_categories()
    {

        $data['categories'] = BlogCategory::orderBy('id', 'asc')->paginate(12);
        $data['trending'] = BlogCategory::inRandomOrder()->where('home_featured', 1)->latest()->limit(5)->get();
        return view('User.blog_categories', $data);
    }

    public function categories()
    {
        try {
            $categories = Category::orderBy('name', 'asc')->get();

            $groupedCategories = [];

            foreach ($categories as $category) {
                $letter = strtoupper(substr($category->name, 0, 1));
                if (!isset($groupedCategories[$letter])) {
                    $groupedCategories[$letter] = collect();
                }
                $groupedCategories[$letter]->push($category);
            }

            $letters = array_keys($groupedCategories);

            return view('User.category', [
                'groupedCategories' => $groupedCategories,
                'letters' => $letters,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function category_details($name = null)
    {
        try {
            $routeCheck = Redirection::check_url('category_details');
            // if ($routeCheck) {
            //     return redirect($routeCheck['route'], $routeCheck['statusCode']);
            // }
            // $data['category'] = Category::where('name', str_replace('-', ' ', strtoupper($name)))->first();
            $data['category'] = Category::where('slug', $name)->first();
            if (empty($name) || $routeCheck || empty($data['category'])) {
                return redirect($routeCheck['route'], $routeCheck['statusCode']);
            }
            $data['dynamicData']    = Setting::where('page', 'categories')->first();
            $data['banner']                 = HomeAdsBanner::whereHas('pages', function ($query) {
                $query->where('name', 'blog-sidebar')->where('status', 1);
            })->with('pages')->first();

            $data['stores'] = $data['category']->stores()->paginate(20);

            if (!empty($data['category'])) {
                return view('User.category_details', $data);
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function blog_category($name = null, $id = null, $type = null)
    {
        $routeCheck = Redirection::check_url('blog_details');
        if ($routeCheck) {
            return redirect($routeCheck['route'], $routeCheck['statusCode']);
        }

        $data['type']                       = $type;
        $data['valid']                      = isset($type) && $type == 'store' ? Store::class : BlogCategory::class;
        $data['category']                   = $data['valid']::where('slug', $name)->first();
        if (!empty($data['category'])) {

            $blogs                          = Blog::where('store_id', $id)->with('categories');

            if ($type != 'store') {
                $data['featured_blog']      = Blog::where('category_id', $data['category']->id)->where('home_featured', 1)->where('published_status', 1)->orderBy('id', 'desc')->first();
                $data['featured_blogs']     = Blog::where('category_id', $data['category']->id)->where('home_featured', 1)->where('published_status', 1)->orderBy('id', 'desc')->offset(1)->limit(3)->get();
                $blogs                      = BlogCategory::where('slug', $name)->first()->blogs();
            }

            $data['blogsdata'] = $blogs->where('published_status', 1)->latest()->paginate(6);

            $data['allblogcategories'] = BlogCategory::orderBy('id', 'asc')->latest()->limit(6)->get();

            $data['blogcategory'] = $data['category'];
            $data['banner'] = HomeAdsBanner::whereHas('pages', function ($query) {
                $query->where('name', 'blog-sidebar')->where('status', 1);
            })->first();
            return view('User.blog_category', $data);
        } else {
            abort(404);
        }
    }

    public function impressum()
    {
        $data['contact'] = ImpressumSetting::latest()->first();
        return view('User.impressum', $data);
    }
    public function coupon_details($id = null)
    {
        try {
            $data = Coupon::where('id', $id)->with('stores')->first();
            $update = Coupon::where('id', $id)->update(['no_clicks' => ($data->no_clicks + 1)]);
            return response()->json($data);
        } catch (\Exception $e) {
            abort(404);
        }
    }
    public function aboutus()
    {
        try {
            $data['content'] = UsefulLink::where(['page' => 'aboutus', 'status' => 1])->pluck('content')->first();
            if (!empty($data['content'])) {
                return view('User.about_us', $data);
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            abort(404);
        }
    }
    public function termsandconditions()
    {
        try {
            $data['content'] = UsefulLink::where(['page' => 'termsandconditions', 'status' => 1])->pluck('content')->first();
            if (!empty($data['content'])) {
                return view('User.terms_and_conditions', $data);
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            abort(404);
        }
    }
    public function privacy_and_policy()
    {
        try {
            $data['content'] = UsefulLink::where(['page' => 'privacyandpolicy', 'status' => 1])->pluck('content')->first();
            if (!empty($data['content'])) {
                return view('User.privacy_and_policy', $data);
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
