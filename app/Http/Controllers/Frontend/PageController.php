<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Services\SettingService;
use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function handleContactForm(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'max:200'],
            'message' => ['required', 'max:1000']
        ]);

        $setting = SettingService::getEmailSetting();

        Mail::to($setting->email)->send(new Contact($request->input('subject'), $request->input('message'), $request->input('email')));

        return response(['status' => 'success', 'message' => 'Mail sent successfully!']);

    }
}
