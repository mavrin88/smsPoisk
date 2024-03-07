<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Contact;
use App\Models\Partner;
use App\Models\Payment_log;
use App\Models\Payment_to_partner;
use App\Models\Source;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class RegistrationController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Auth/Register');
    }

    public function store(RegisterRequest $request)
    {
        $passwordHash = Hash::make($request->getPassword());
        $latestRecord = Partner::latest('id')->first('id');
        $newId = $latestRecord->id + 1;

        $partner = Partner::create([
            'id' => $newId,
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => $passwordHash,
        ]);

        $source = Source::create([
            'id' => $partner->id,
            'name' => substr(Str::uuid()->toString(), 0, 8),
            'partner_id' => $partner->id,
            'offer_id' => 6 // временное
        ]);

        $registeredParams = [
            'source' => $source->name,
        ];

        $user = User::create([
            'id' => $partner->id,
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => $passwordHash,
            'source_id' => $source->id,
            'partner_id' => $partner->id,
            'telegram' => $partner->id,
            'registered_params' => json_encode($registeredParams)
        ]);

        $payment_log = Payment_log::create([
            'id' => $user->id,
            'user_id' => $user->id,
            'amount' => 30,
            'status' => true,
            'offer_id' => 6,
            'income' => 67,
            'payment_type' => 'subscription',
        ]);

        $payment_to_partner = Payment_to_partner::create([
            'id' => $user->id,
            'partner_id' => $user->id,
            'amount' => 30,
            'currency' => 'RUB',
            'type' => 'СБП',

        ]);


//---------------------------------------------------------------------------------------------
//        $passwordHash = Hash::make($request->getPassword());
//        $unique_value = substr(Str::uuid()->toString(), 0, 4);
//
//        $check_unique_value = DB::connection('partner_manager')->table('sources')->where('name', $unique_value)->exists();
//
//        if ($check_unique_value){
//            $unique_value = substr(Str::uuid()->toString(), 0, 4);
//        }
//
//        $latestRecord = DB::connection('partner_manager')->table('partners')->latest('id')->first('id');
//        $newId = $latestRecord->id + 1;
//
//        $registeredParams = [
//            'tg' => $request->getTelegramm(),
//            'sources' => $request->getSourceName(),
//            'from' => $request->getFrom(),
//        ];
//
//        $partnerData = [
//            'id' => $newId,
//            'name' => $request->getName(),
//            'email' => $request->getEmail(),
//            'password' => $passwordHash,
////            'registered_params' => json_encode($registeredParams),
//            'created_at' => now(),
//        ];
//
//        $partner = DB::connection('partner_manager')->table('partners')->insert($partnerData);
//        $newPartner = (object)$partnerData;
//
//  if ($partner){
//
//      $sourceData = [
//          'id' => $newPartner->id,
////          'id' => 1000,
//          'name' => $unique_value,
//          'partner_id' => $newPartner->id,
//          'is_cloaking' => true,
//          'offer_id' => 6,
//          'created_at' => now(),
//      ];
//
//      $source = DB::connection('partner_manager')->table('sources')->insert($sourceData);
//      $newSource = (object)$sourceData;
//      $registeredParams = ['source' => $newSource->name];
//
//  }
//
//if ($source){
//
//    $userData = [
//        'id' => $newSource->id,
//        'name' => $request->getName(),
//        'email' => $request->getEmail(),
//        'password' => $passwordHash,
//        'source_id' => $newSource->id,
//        'partner_id' => $newPartner->id,
//        'telegram' => $newPartner->id,
//        'registered_params' => json_encode($registeredParams)
//    ];
//
//    $users = DB::connection('partner_manager')->table('users')->insert($userData);
//    $newUser = (object)$userData;
//
//}

//временное для уточнения
//        if ($source){
//
//            $payment_logData = [
//                'id' => $newUser->id,
//                'user_id' => $newUser->id,
//                'amount' => 30,
//                'status' => true,
//                'offer_id' => 6,
//                'income' => 67,
//                'payment_type' => 'subscription',
//            ];
//
//            $payment_logs = DB::connection('partner_manager')->table('payment_logs')->insert($payment_logData);
//
//            if ($payment_logs){
//
//                $payment_to_partnerData = [
//                    'id' => $newUser->id,
//                    'partner_id' => $newUser->id,
//                    'amount' => 30,
//                    'currency' => 'RUB',
//                    'type' => 'СБП',
//                ];
//                $payment_partner = DB::connection('partner_manager')->table('payment_to_partners')->insert($payment_to_partnerData);
//            }
//
//        }


        return redirect('/login');
    }

}


