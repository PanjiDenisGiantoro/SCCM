<?php

namespace App\Http\Controllers;

use App\Mail\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendWelcomeEmail()
    {
            Mail::to('panjidenisgiantoroo@gmail.com')->queue(new SendWelcomeEmail());
            return response()->json(['message' => 'Email queued successfully!']);
    }
}
