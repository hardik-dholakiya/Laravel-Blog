<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function send_email(Request $request)
    {
        $file=$request->file('file');
        $data=$request->except('_token','file');
        $result=Mail::send('emails.contactUs', ['file' => $file,'data'=>$data], function ($m) use ($data,$file) {
            $m->to($data['email'], $data['firstname']." ".$data['lastname'])->subject('Contact for '.$data['subject'].".");
            $m->attach($file->getPath(), [
                'as' => $file->getClientOriginalName(),
                'mime' => $file->getClientMimeType()
            ]);
        });
        if ($result==null) {
            return redirect()->route('home')->withErrors(['message' => 'Email is successfully send.']);
        } else {
            return redirect()->back()->withErrors(['message' => 'Email is not successfully send.']);
        }
    }
}
