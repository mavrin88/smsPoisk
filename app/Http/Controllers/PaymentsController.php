<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Http\Resources\PaymentsResource;
use App\Models\Payment_to_partner;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PaymentsController extends Controller
{
    public function index()
    {
        $user = \auth()->user();
    
        $payment = Payment_to_partner::where('partner_id', $user->id)->get();

        return Inertia::render('Payments/Index', ['payments' =>  PaymentsResource::collection($payment)]);

    }

}
