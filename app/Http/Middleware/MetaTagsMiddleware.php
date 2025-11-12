<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use App\Models\Store;
use App\Models\Blog;
use App\Models\Category;
use App\Models\BlogCategory;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class MetaTagsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $currentRoute = $request->route()->getName();
        $currentURL = url()->current();

        if ($currentRoute == 'home') {
            $metadata = Setting::where('page', 'home')->first();
            $this->setMetaData('home', $metadata, 'website', config('setting.site_logo'));
        } else if ($currentRoute == 'blogs') {
            $metadata = Setting::where('page', 'blog')->first();
            $this->setMetaData('blogs', $metadata, 'website', config('setting.site_logo'));
        } else if ($currentRoute == 'stores') {
            $metadata = Setting::where('page', 'store')->first();
            $this->setMetaData('stores', $metadata, 'website', config('setting.site_logo'));
        }else if ($currentRoute == 'aboutus') {
            $metadata = Setting::where('page', 'about')->first();
            $this->setMetaData('aboutus', $metadata, 'website', config('setting.site_logo'));
        } else if ($currentRoute == 'categories') {
            $metadata = Setting::where('page', 'category')->first();
            $this->setMetaData('categories', $metadata, 'website', config('setting.site_logo'));
        } else if ($currentRoute == 'impressum') {
            $metadata = Setting::where('page', 'impressum')->first();
            $this->setMetaData('imprint', $metadata, 'website', config('setting.site_logo'));
        } else if ($currentRoute == 'privacyandpolicy') {
            $metadata = Setting::where('page', 'privacy')->first();
            $this->setMetaData('privacy_and_policy', $metadata, 'website', config('setting.site_logo'));
        } else if ($currentRoute == 'termsandconditions') {
            $metadata = Setting::where('page', 'terms')->first();
            $this->setMetaData('/terms_and_conditions', $metadata, 'website', config('setting.site_logo'));
        } else if ($currentRoute == 'store_details') {
            try {
                $storeId = explode('/store/', $currentURL)[1];
                $store = Store::where(['slug' => $storeId])->first();
                if ($store) {
                  
                    $this->setMetaData($store->slug, $store, 'website', asset('images/StoreImages/' . ($store->image ?? '')), $store->image_alt);
                }
            } catch (\Exception $e) {
                return redirect()->route('stores');
            }
        } else if ($currentRoute == 'blog_details') {
            try {

                $blogId = explode('/blog/', $currentURL)[1];
                $blog = Blog::where(['slug' => $blogId])->first();
                if ($blog) {
                 
                     $this->setMetaData(
                            $blog->slug,
                            $blog,
                            'article',
                            asset('images/blogsImages/' . ($blog->image ?? '')),
                            $blog->image_alt
                        );
                }
            } catch (\Exception $e) {
                return redirect()->route('blogs');
            }
        } else if ($currentRoute == 'blog_category') {
            try {
                $categoryId = explode('/blog/category/', $currentURL)[1];
                $category = BlogCategory::where(['slug' => $categoryId])->first();
                if ($category) {
                
                    $this->setMetaData($category->slug, $category, 'website', asset('images/BlogCategoriesImages/' . ($category->image ?? '')) , $category->image_alt);
                    
                }
                
            } catch (\Exception $e) {
                abort(404);
            }

            } else if ($currentRoute == 'categories') {
            try {
                $metadata = Setting::where('page', 'categories')->first();
                $this->setMetaData('categories', $metadata, 'website', config('setting.site_logo'));
            } catch (\Exception $e) {
                abort(404);
            }
            
        } else if ($currentRoute == 'category_details') {
            try {
                $currentURL = explode('/category/', $currentURL);
                $category = Category::where('slug', $currentURL[1])->first();
                if ($category) {
                 
                    $this->setMetaData($category->slug, $category, 'website', asset('images/CategoriesImages/' . ($category->image ?? '')), $category->image_alt);
                }
            } catch (\Exception $e) {
                abort(404);
            }
        } else {
            $metadata = Setting::where('page', 'home')->first();
            $this->setMetaData('home', $metadata, 'website', config('setting.site_logo'));
        }
        return $next($request);
    }


    // /**
    //  * Set general meta data for the page.
    //  */
   public function setMetaData($page, $metadata, $metaType, $metaImage, $metaImageAlt = null)
    {

        Config::set([
            'metatags.meta_title' => empty($metadata->meta_title) ?  config('setting.site_name') : $metadata->meta_title,
            'metatags.meta_description' => $metadata->meta_description ?? "",
            'metatags.meta_keywords' => $metadata->meta_keywords ?? "",
            'metatags.meta_image' => $metaImage ?? config('setting.site_logo'),
            'metatags.meta_type' => $metaType,
            'metatags.meta_alt' => $metadata->meta_alt ?? $metaImageAlt ?? config('setting.site_name'),
        ]);
    }


}
