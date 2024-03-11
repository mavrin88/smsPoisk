<?php

namespace App\Http\Controllers;


use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PaymentsResource;

class PaymentsController extends Controller
{
    public function index()
    {
        $user = \auth()->user();
        $payment = DB::connection('readonly')
            ->table('payment_to_partners')
            ->where('partner_id', $user->partner_id)
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Payments/Index', ['payments' =>  PaymentsResource::collection($payment)]);

    }

}
