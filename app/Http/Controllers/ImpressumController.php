<?php

namespace App\Http\Controllers;

use App\Models\Impressum;
use Illuminate\Http\Request;

class ImpressumController extends Controller
{
    public function contact_us(Request $request)
    {
        try {
            $data      = $request->except('_token');
            foreach ($data as $key => $value) {
                if(empty($value)) {
                   return redirect()->back()->with('error', $key.' is required');
                }
            }
            $data['ip_address']  = $request->ip();
            $data['mac_address'] = Impressum::getMac();
            $data['is_consent']  = isset($data['is_consent']) &&  $data['is_consent'] == 'on' ? 1 : 0 ;
            $Impressum = Impressum::create($data);
            if ($Impressum) {
                return redirect()->back()->with('success', 'Message has been sent successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to send message');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
