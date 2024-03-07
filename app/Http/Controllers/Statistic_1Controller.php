<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConversionResource;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class Statistic_1Controller extends Controller
{
    public function index()
    {
        $authUser = \auth()->user();

        $dataSubquery = DB::table('payment_logs as p')
            ->select(
                'p.user_id as pid',
                DB::raw("CAST(u.registered_params as jsonb) ->> 'source' as src"),
                'p.user_id',
                'p.income',
//                DB::raw("SUM(d.income) / 2 as income"),
                DB::raw("DATE(p.created_at) as day"),
                'p.payment_type',
                DB::raw("CAST(u.registered_params as jsonb) ->> 's1' as s1"),
                DB::raw("CAST(u.registered_params as jsonb) ->> 's2' as s2"),
                DB::raw("CAST(u.registered_params as jsonb) ->> 's3' as s3"),
                DB::raw("CAST(u.registered_params as jsonb) ->> 's4' as s4"),
                DB::raw("CAST(u.registered_params as jsonb) ->> 's5' as s5")
            )
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->join('sources as s', 's.name', '=', DB::raw("CAST(u.registered_params as jsonb) ->> 'source'"))
            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
            ->where('p.status', true)
            ->where('pp.id', $authUser->id)
            ->groupBy('p.user_id', 'src', 'day', 'p.income', 'p.payment_type',  's1', 's2', 's3', 's4', 's5');
//            ->groupBy('p.user_id', 'src', 'day', 'p.payment_type',  's1', 's2', 's3', 's4', 's5');

        $tableConversion = DB::table('payment_logs as p')
            ->select(
                'd.src',
                'd.pid',
                DB::raw("SUM(d.income) / 2 as income"),
                'd.day',
                'd.payment_type',
                'd.s1',
                'd.s2',
                'd.s3',
                'd.s4',
                'd.s5'
            )
            ->joinSub($dataSubquery, 'd', function ($join) {
                $join->on('d.pid', '=', 'p.user_id');
            })
            ->groupBy('d.src', 'd.pid', 'd.day', 'd.income','d.payment_type', 'd.s1', 'd.s2', 'd.s3', 'd.s4', 'd.s5')
//            ->groupBy('d.src', 'd.pid', 'd.day', 'd.payment_type', 'd.s1', 'd.s2', 'd.s3', 'd.s4', 'd.s5')
            ->get();


        return Inertia::render('Statistics_1/Index', ['tableConversion' => ConversionResource::collection($tableConversion)]);
    }

}
