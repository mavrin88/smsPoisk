<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;

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

//-------------- Users
        $usersData = [
            'first_name' => $request->getName(),
            'last_name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => $passwordHash,
            'account_id' => rand(1, 100),
            'created_at' => now(),
        ];

        $user = DB::connection('mysql')->table('users')->insertGetId($usersData);

//-------------- Partners
        if ($user) {

            $registeredParams = [
                'tg' => $request->getTelegramm(),
                'sources' => $request->getSourceName(),
                'from' => $request->getFrom(),
            ];

            $partnerData = [
                'name' => $request->getName(),
                'email' => $request->getEmail(),
                'password' => $passwordHash,
                'registered_params' => json_encode($registeredParams),
                'created_at' => now(),
            ];

            $partner = DB::connection('manager')->table('partners')->insertGetId($partnerData);
        }

//-------------- Sources
        $unique_value = substr(Str::uuid()->toString(), 0, 4);

        $check_unique_value = DB::connection('manager')->table('sources')->where('name', $unique_value)->exists();

        if ($check_unique_value) {
            $unique_value = substr(Str::uuid()->toString(), 0, 4);
        }

        if ($partner) {

            $sourceData = [
                'name' => $unique_value,
                'partner_id' => $partner,
                'is_cloaking' => true,
                'offer_id' => 6,
                'created_at' => now(),
            ];

            $source = DB::connection('manager')->table('sources')->insert($sourceData);
        }

        if ($source) {

            DB::connection('mysql')
                ->table('users')
                ->where('id', $user)
                ->update(['partner_id' => $partner, 'updated_at' => now()]);
        }

        return redirect('/login');
    }

}



