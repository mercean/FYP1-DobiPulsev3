<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QRController extends Controller
{
    public function entry()
    {
        if (!Auth::check()) {
            session(['redirect_after_login' => route('qr.entry')]);
            return redirect()->route('login')->with('message', 'Please log in to continue.');
        }

        $accountType = Auth::user()->account_type ?? '';

        return match ($accountType) {
            'regular' => redirect()->route('orders.create'),
            'bulk'    => redirect()->route('bulk.orders.create'),
            default   => redirect('/')->with('error', 'Unrecognized account type.')
        };
    }

    public function demo()
    {
        return view('qr.demo');
    }
}
