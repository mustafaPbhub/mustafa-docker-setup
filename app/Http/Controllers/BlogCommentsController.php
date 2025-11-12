<?php

namespace App\Http\Controllers;

use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentsController extends Controller
{
    public function blogsComment(Request $request)
    {
        try {
            $data      = $request->except('_token');
            $data['ip_address']  = $request->ip();
            $data['mac_address'] = BlogComment::getMac();
            $data['status']  = 0 ;
            $Comment = BlogComment::create($data);
            if ($Comment) {
                return redirect()->back()->with('success', 'Comment has been sent successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to send comment');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}