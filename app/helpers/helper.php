<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Models\Setting;

if(!function_exists('generate_sitemap')) {
   function generate_sitemap($sitemapData , $directoryName , $filename ){
    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

        foreach($sitemapData  as $data){
            $url = $xml->addChild('url');
            $url->addChild('loc',  htmlspecialchars($data['url']));
            if(!empty($data['lastmod'])){
            $url->addChild('lastmod', $data['lastmod']);
            }
            if(!empty($data['changeFreq'])){
            $url->addChild('changefreq', $data['changeFreq']);
            }
            if(!empty($data['priority'])){
            $url->addChild('priority', $data['priority']);
            }

        }
        $filePath = public_path($directoryName.'/'.$filename);
        $directory = dirname($filePath);
        if(!file_exists($directory)){
            mkdir($directory, 0777 , true);
        }
        $xmlContent = $xml->asXML();
        file_put_contents($filePath, $xmlContent);
        return response(['success' => true, 'xml' => $xml]);
    }

}
if(!function_exists('lower_file_name')){
    function lower_file_name($folderName){
            $folderPath = public_path($folderName);
            $files      = File::files($folderPath);
            $fileNames  = array();
            foreach ($files as $file) {
                $oldFileName = $file->getFileName();
                $newFileName = str_replace(' ','-' , strtolower($oldFileName));
                $fileRenamed = rename($file->getPathname(), $file->getPath()."/".$newFileName);
            }
            if($fileRenamed == true){
                return true;
            }
            else{
                return false;
            }
    }
}

if (!function_exists('home_schema')) {
    function home_schema() {
        
        
        $siteUrl = route('home');
        $page = 'home';
        if(Route::is('blog_details')){
            $siteUrl = route('blogs');
            $page =  'blog';
        }
        else if(Route::is('store_details')){
            $siteUrl = route('stores');
            $page = 'store';
        }
        else if(Route::is('blog_category')){
            $siteUrl = route('blogs');
            $page =  'blog';
        }
        else if(Route::is('category_details')){
            $siteUrl = route('categories');
            $page = 'categories';
        }
        $schema = Setting::where('page', $page)->first();
        if (!$schema) {
            return '{}';
        }
        $data = [
            "@type" => "WebSite",
            "@id" => $siteUrl . '#website',
            "url" => $siteUrl,
            "name" => $schema->meta_title ,
            "description" => $schema->meta_description
        ];

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}