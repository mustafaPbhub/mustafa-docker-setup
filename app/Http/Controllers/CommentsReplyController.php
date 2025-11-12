<?php

namespace App\Http\Controllers;

use App\Models\ReplyComments;
use Illuminate\Http\Request;

class CommentsReplyController extends Controller
{
    public function commentsReply(Request $request)
    {
        try {
            $data      = $request->except('_token');
            $data['ip_address']  = $request->ip();
            $data['mac_address'] = ReplyComments::getMac();
            $data['status']  = 0 ;
            $Comment = ReplyComments::create($data);
            if ($Comment) {
                return redirect()->back()->with('success', 'Reply has been sent successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to send comment');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}