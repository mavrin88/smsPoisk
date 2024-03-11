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
        $dataSubquery = DB::connection('readonly')
            ->table('payment_logs as p')
            ->select(
                DB::raw("CAST(u.registered_params as jsonb) ->> 'source' as src"),
                'p.user_id as pid',
                'p.income',
                DB::raw("p.created_at as day"),
                'p.payment_type as pt',
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
            ->where('pp.id', $authUser->partner_id);

        $subquery = $dataSubquery->toSql();
        $bindings = $dataSubquery->getBindings();

        $tableConversion = DB::connection('readonly')
            ->select(DB::raw("SELECT
        d.day,
        CASE
            WHEN d.pt = 'discount' THEN 'Рекурент'
            WHEN d.pt = 'subscription' THEN 'Подписка'
            WHEN d.pt = 'recurrent' THEN 'Рекурент'
            ELSE d.pt
        END AS pt,
        d.income/2 as income,
        d.s1,
        d.s2,
        d.s3,
        d.s4,
        d.s5
    FROM ($subquery) as d
    ORDER BY d.day DESC"), $bindings);

        return Inertia::render('Statistics_1/Index', ['tableConversion' => ConversionResource::collection($tableConversion)]);
    }

}
