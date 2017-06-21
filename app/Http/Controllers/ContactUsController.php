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
        $email[]=explode(',',$data["email"]);
        $result=Mail::send('emails.contactUs', ['file' => $file,'data'=>$data], function ($m) use ($data,$email,$file) {
            foreach ($email as $id=>$email_id) {
                $m->to($email_id)->subject('Contact for ' . $data['subject'] . ".");
            }
            $size = sizeOf($file);
            for ($i=0; $i < $size; $i++) {
                $m->attach($file[$i]->getRealPath(), [
                    'as' => $file[$i]->getClientOriginalName(),
                    'mime' => $file[$i]->getMimeType()
                ]);
                }
        });
        if ($result==null) {
            return redirect()->route('home')->withErrors(['message' => 'Email is successfully send.']);
        } else {
            return redirect()->back()->withErrors(['message' => 'Email is not successfully send.']);
        }
    }
}
