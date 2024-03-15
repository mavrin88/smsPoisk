<?php

namespace App\Http\Controllers;

use App\Http\Resources\DateFilterResource;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $authUser = \auth()->user();
        $source = DB::connection('manager')->table('sources')->where('partner_id', $authUser->partner_id)->first();


//------------------------------- + Виджет текущего баланса за весь период: -----------------------------------

        $result = DB::connection('readonly')->table('payment_logs as p')
            ->select(DB::raw('SUM(p.income)/2 as total_income'))
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->join('sources as s', function ($join) {
                $join->on('s.name', '=', DB::raw("CAST(u.registered_params as jsonb) ->> 'source'"));
            })
            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
            ->where('p.status', true)
            ->where('u.offer_id', 6)
            ->where('pp.id', $authUser->partner_id)
            ->first()
            ->total_income;

        if ($result === null) {
            $totalIncome = 0;
        } else {
            $totalIncome = number_format($result, 2, '.', '');
        }

//------------------------------- + Виджет кол-ва подписчиков: -----------------------------------

        $all_subscriptions = DB::connection('readonly')
            ->table('users as u')
            ->select('u.id as partner_id', 'pp.name as partner_name', DB::raw("CAST(u.registered_params AS jsonb) ->> 'source' as src"))
            ->join('sources as s', function ($join) {
                $join->on(DB::raw("CAST(u.registered_params AS jsonb) ->> 'source'"), '=', 's.name');
            })
            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
            ->leftJoin('payment_logs as p', 'u.id', '=', 'p.user_id')
            ->where('s.offer_id', 6)
            ->where('pp.id', $authUser->partner_id)
            ->whereNotNull('pp.name')
            ->where('p.status', true)
            ->where('p.payment_type', '=', 'subscription')
            ->distinct()
            ->count('u.id');

//-------------------------------  Виджет кол-ва активных подписчиков  -----------------------------------

        $sourceNames = DB::connection('readonly')
            ->table('sources')
            ->where('offer_id', 6)
            ->pluck('name');

        $allUsersSubquery = DB::connection('readonly')
            ->table('users as u')
            ->select('u.id AS pid', 'u.status AS status', 'pp.name as pname', DB::raw("CAST(u.registered_params as jsonb) ->> 'source' as src"))
            ->join('sources as s', function ($join) {
                $join->on(DB::raw("CAST(u.registered_params as jsonb) ->> 'source'"), '=', 's.name');
            })
            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
            ->whereIn('s.name', $sourceNames)
            ->whereNotNull('pp.name')
            ->where('pp.id', $authUser->partner_id);

        $subscribersSubquery = DB::connection('readonly')
            ->table('users as u')
            ->select('u.id AS pid')
            ->whereIn('u.status', ['subscribed', 'lite']);

        $acive_subscriptions = DB::connection('readonly')
            ->table(DB::raw("({$allUsersSubquery->toSql()}) as u"))
            ->leftJoin(DB::raw("({$subscribersSubquery->toSql()}) as s"), function ($join) {
                $join->on('s.pid', '=', 'u.pid');
            })
            ->selectRaw('count(DISTINCT s.pid) as subscriptions')
            ->mergeBindings($allUsersSubquery)
            ->mergeBindings($subscribersSubquery)
            ->get();
        $acive_subscriptions = $acive_subscriptions[0]->subscriptions;

//------------------------------- + Виджет Доступные балансы:  -----------------------------------

        $result = DB::connection('readonly')->table('payment_logs as p')
//            ->select(DB::raw('CEILING((CAST(SUM(p.income)/2 - pt.payouts_sum AS numeric) * 20)) / 20.0 as available_balance'))
            ->select(DB::raw('CEIL((SUM(p.income)/2 - COALESCE(pt.payouts_sum, 0)) * 20) / 20.0 as available_balance'))
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->join('sources as s', DB::raw("cast(u.registered_params as jsonb)->>'source'"), '=', 's.name')
            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
            ->where('p.status', true)
            ->where('pp.id', $authUser->partner_id)
            ->where('u.offer_id', 6)
            ->join(DB::raw("(SELECT SUM(amount) as payouts_sum FROM payment_to_partners WHERE partner_id = $authUser->partner_id) as pt"), DB::raw('1'), '=', DB::raw('1'))
            ->groupBy('pt.payouts_sum')
            ->get();

        if ($result->isNotEmpty()) {
            $available_balances = $result[0]->available_balance;
//    $available_balances = number_format($balances, 2, '.', '');
        } else {
            $available_balances = 0;
        }

//------------------------------- Таблица подписчиков  -----------------------------------

        $dataSubquery = DB::connection('readonly')
            ->table('payment_logs as p')
            ->select(
                DB::raw("CAST(u.registered_params as jsonb) ->> 'source' as src"),
                'p.user_id as pid',
                'p.income',
                DB::raw("DATE(p.created_at) as day"),
                'p.amount'
            )
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->join('sources as s', 's.name', '=', DB::raw("CAST(u.registered_params as jsonb) ->> 'source'"))
            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
            ->where('p.offer_id', 6)
            ->where('p.status', true)
            ->where('pp.id', $authUser->partner_id)
            ->when($request->filled('dateFrom'), function ($query) use ($request) {
                $query->whereDate('p.created_at', '>=', $request->input('dateFrom'));
            })
            ->when($request->filled('dateTo'), function ($query) use ($request) {
                $query->whereDate('p.created_at', '<=', $request->input('dateTo'));
            });

        $sourceNames = DB::connection('readonly')
            ->table('sources')
            ->select('id', 'name')
            ->where('offer_id', 6)
            ->get();

        $registeredBySourceSubquery = DB::connection('readonly')
            ->table('users as u')
            ->select(
                DB::raw("u.created_at::date as day"),
                DB::raw("COUNT(u.id) as cnt"),
                DB::raw("CAST(u.registered_params as jsonb) ->> 'source' as src")
            )
            ->join('sources as s', 's.name', '=', DB::raw("CAST(u.registered_params as jsonb) ->> 'source'"))
            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
            ->where('u.offer_id', 6)
            ->whereIn(DB::raw("CAST(u.registered_params as jsonb) ->> 'source'"), $sourceNames->pluck('name'))
            ->when($request->filled('dateFrom'), function ($query) use ($request) {
                $query->whereDate('u.created_at', '>=', $request->input('dateFrom'));
            })
            ->when($request->filled('dateTo'), function ($query) use ($request) {
                $query->whereDate('u.created_at', '<=', $request->input('dateTo'));
            })
            ->groupBy('day', 'src');

        $subscribedBySourceSubquery = DB::connection('readonly')
            ->table('payment_logs as p')
            ->select(
                DB::raw("p.created_at::date as day"),
                DB::raw("COUNT(p.id) as cnt"),
                DB::raw("CAST(u.registered_params as jsonb) ->> 'source' as src")
            )
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->where('p.offer_id', 6)
            ->where('p.status', true)
            ->whereIn('p.amount', [1, 20, 99, 100, 499])
            ->when($request->filled('dateFrom'), function ($query) use ($request) {
                $query->whereDate('p.created_at', '>=', $request->input('dateFrom'));
            })
            ->when($request->filled('dateTo'), function ($query) use ($request) {
                $query->whereDate('p.created_at', '<=', $request->input('dateTo'));
            })
            ->groupBy('day', 'src');

        $result = DB::connection('readonly')
            ->table(DB::raw("({$dataSubquery->toSql()}) as d"))
            ->leftJoin(DB::raw("({$registeredBySourceSubquery->toSql()}) as rbs"), function ($join) {
                $join->on('rbs.day', '=', 'd.day')->on('rbs.src', '=', 'd.src');
            })
            ->leftJoin(DB::raw("({$subscribedBySourceSubquery->toSql()}) as sbs"), function ($join) {
                $join->on('sbs.day', '=', 'd.day')->on('sbs.src', '=', 'd.src');
            })
            ->mergeBindings($dataSubquery)
            ->mergeBindings($registeredBySourceSubquery)
            ->mergeBindings($subscribedBySourceSubquery)
            ->select(
                'd.day',
                'rbs.cnt as registered',
                'sbs.cnt as subscribed',
                DB::raw('FLOOR(COALESCE(sbs.cnt * 100.0 / rbs.cnt, 0)) AS cr'),
                DB::raw('COUNT(d.pid) as trx'),
                DB::raw('CEILING((CAST(SUM(d.income)/2 AS numeric) * 20)) / 20.0 as total_income')
            )
            ->groupBy('d.day', 'rbs.cnt', 'sbs.cnt')
            ->orderByDesc('d.day')
            ->orderByDesc('total_income')
            ->get();

        $tableScribers = $result->map(function ($item) {
            $rounded = number_format($item->total_income, 2, '.', '');
            $rounded_value = rtrim($rounded, '0');
            if (substr($rounded_value, -1) == '.') {
                $rounded_value = rtrim($rounded_value, '.');
            }

            $newObject = new \stdClass;
            $newObject->day = $item->day;
            $newObject->registered = $item->registered;
            $newObject->subscribed = $item->subscribed;
            $newObject->cr = $item->cr;
            $newObject->trx = $item->trx;
            $newObject->total_income = $rounded_value;
            return $newObject;
        });


        return Inertia::render('Dashboard/Index', ['source_name' => $source->name, 'widget_total_income' => $totalIncome, 'widget_available_balances' => $available_balances, 'widget_period_subscribed' => $all_subscriptions, 'widget_active_subscribed' => $acive_subscriptions, 'tableScribers' => DateFilterResource::collection($tableScribers)]);

    }
}
