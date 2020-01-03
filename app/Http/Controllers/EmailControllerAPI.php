<?php

namespace App\Http\Controllers;

use App\Mail\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailControllerAPI extends Controller
{
    public function send(Request $request)
    {
        $title = ('Movement received');
        $content = $request->value . ' ' . $request->description;
        $address = $request->email;

        Mail::send("mail", ['title' => $title, 'content' => $content], function ($message) use ($address) {
            $message->subject('iWallet');
            $message->to($address);
        });

        return response()->json(['message' => 'Email sent']);
    }
}
