<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request){
       try{
        $data        = $request->except('_token');
        foreach ($data as $key => $value) {
            if(empty($value)) {
               return redirect()->back()->with('error', $key.' is required');
            }
        }
        $checkemail  = Subscriber::where('email', $data['email'])->count();
        $data['ip_address']  = $request->ip();
        $data['mac_address'] = Subscriber::getMac();
        $data['is_consent']  = isset($data['is_consent']) && $data['is_consent'] == 'on' ? 1 : 0;
        if($checkemail> 0){
            return response()->json(['available' => true]);
        }
        else{
            $subscribe = Subscriber::create($data);
            if($subscribe){
                return response()->json(['success' => true]);
            }
            else{
                return response()->json(['error' => true]);
            }
        }
       }
       catch(\Exception $e){
        return response()->json(['error' => $e->getMessage()]);
       }
    }

}
