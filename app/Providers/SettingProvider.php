<?php

namespace App\Providers;

use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingProvider extends ServiceProvider
{
    public function boot(): void
    {
        $settingsdata = $this->settings();
        $module = $this->modulesName();
        $dimensions = [];
        if(Schema::hasTable('image_dimension_settings')){
            @$dimensions = \DB::table('image_dimension_settings')->where("module",trim($module))->get();
        }
        if(!empty($settingsdata)){
            config([
                'setting.site_name' => $settingsdata->site_name,
                'setting.url' => $settingsdata->site_url,
                'setting.site_logo'=>$settingsdata->site_logo,
                'setting.site_footer' => $settingsdata->footer_logo,
                'setting.about' => $settingsdata->about,
                'setting.site_favicon'=>$settingsdata->favicon,
                'setting.height' => isset($dimensions[0]) ? $dimensions[0]->height : null,
                'setting.width' => isset($dimensions[0]) ? $dimensions[0]->width : null,
                'setting.exclusive_card' => isset($dimensions[0])  ? $dimensions[0]->exclusive_coupon_card : 0 ,
                'setting.is_color_available' => isset($dimensions[0])  ? $dimensions[0]->is_color_available : 0 ,
            ]);

            env('APP_URL' , $settingsdata->site_url);
        }
    }
    public function settings(){
        if(Schema::hasTable('website_settings')){
            $settings = WebsiteSetting::orderBy('id','desc')->first();
            if(!empty($settings)){
                return $settings;
            }
            else{
                return null;
            }
        }
        else{
            return null;
        }
    }
    public function modulesName(){
        $route = Request::path();
        $module = "";

        // Handle routes with parameters
        if (preg_match('/^panel\/(.+)\/create(?:\/\d+)?$/', $route, $matches) ||
        preg_match('/^panel\/(.+)\/(?:create\/\d+|(\d+)|setting(?:\/.*)?)$/', $route, $matches) ||
        preg_match('/^panel\/(.+)\/?(?:\/.+)?$/', $route, $matches)) {

            switch ($matches[1]) {
                case 'blog':
                    $module = "blogs";
                    break;
                case 'blogcategory':
                    $module = "blogs-categories";
                    break;
                case 'sliders':
                    $module = 'sliders';
                    break;
                case 'slidersads':
                    $module = 'sliders-banners';
                    break;
                case 'media':
                    $module = 'media';
                    break;
                case 'coupons':
                    $module = 'coupons';
                    break;
                case 'store':
                    $module = "stores";
                    break;
                case 'category':
                    $module = "store-categories";
                    break;
                case 'users':
                    $module = "users";
                    break;
                case 'product':
                    $module = "products";
                    break;
                case 'profile':
                    if (preg_match('/^panel\/profile\/setting(?:\/.*)?$/', $route)) {
                        $module = "user-profile";
                    }
                    break;
                default:
                    $module = "";
                    break;
            }
        }

        return $module;

    }
}
