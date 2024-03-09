<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $authUser = \auth()->user();
        $source_name = DB::connection('manager')->table('sources')->where('id', $authUser->id)->first();


//------------------------------- + Виджет текущего баланса за весь период: -----------------------------------

////        $totalIncome = Payment_log::query()
//        $totalIncome = DB::connection('readonly')
//            ->table('payment_logs')
//            ->join('users as u', 'u.id', '=', 'payment_logs.user_id')
//            ->join('sources as s', function ($join) {
//                $join->on(DB::raw('s.name'), '=', DB::raw("cast(u.registered_params as jsonb) ->> 'source'"));
//            })
//            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
//            ->where('payment_logs.status', true)
//            ->where('u.id', $authUser->id)
//            ->selectRaw('SUM(payment_logs.income)/2 as total_income')
//            ->first()
//            ->total_income;
//
//       if ($totalIncome === null) $totalIncome = 0;

//        $totalIncome = DB::connection('readonly')
//            ->table('users as u')
//            ->select(
//                'u.id as partner_id',
//                'pp.name as partner_name',
//                DB::raw("CAST(u.registered_params AS jsonb) ->> 'source' as src")
//            )
//            ->join('sources as s', function ($join) {
//                $join->on(DB::raw("CAST(u.registered_params AS jsonb) ->> 'source'"), '=', 's.name');
//            })
//            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
//            ->leftJoin('payment_logs as p', function ($join) {
//                $join->on('u.id', '=', 'p.user_id')
//                    ->where('p.status', 1)
//                    ->where('p.payment_type', 'subscription');
//            })
//            ->where('s.offer_id', 6)
//            ->where('pp.id', 11)
//            ->whereNotNull('pp.name')
//            ->selectRaw('SUM(p.income)/2 as total_income')
//            ->first()
//            ->total_income;


//------------------------------- + Виджет кол-ва подписчиков за весь период: -----------------------------------

//        $allsubScribers = DB::table('users as u')
//            ->select('u.id as partner_id', 'pp.name as partner_name', DB::raw("CAST(u.registered_params AS jsonb) ->> 'source' as src"))
//            ->join('sources as s', function ($join) {
//                $join->on(DB::raw("CAST(u.registered_params AS jsonb) ->> 'source'"), '=', 's.name');
//            })
//            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
//            ->leftJoin('payment_logs as p', 'u.id', '=', 'p.user_id')
//            ->where('s.offer_id', 6)
//            ->where('pp.id', $authUser->id)
//            ->whereNotNull('pp.name')
//            ->where('p.status', true)
//            ->where('p.payment_type', '=', 'subscription')
//            ->get();
//
//                $all_subscriptions = $allsubScribers->count();

//        $sourceNames = DB::table('sources')
//            ->select('name')
//            ->where('offer_id', 6)
//            ->pluck('name');
//
//        $allUsersQuery = DB::table('users as u')
//            ->select(
//                'u.id as pid',
//                'pp.name as pname',
//                DB::raw("CAST(u.registered_params AS jsonb) ->> 'source' as src")
//            )
//            ->join('sources as s', function ($join) {
//                $join->on(DB::raw("CAST(u.registered_params AS jsonb) ->> 'source'"), '=', 's.name');
//            })
//            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
//            ->whereIn(DB::raw("CAST(u.registered_params AS jsonb) ->> 'source'"), $sourceNames)
//            ->whereNotNull('pp.name')
//            ->where('pp.id', $authUser->id);
//
//        $allUsers = $allUsersQuery->get();
//
//        $subscribersQuery = DB::table('payment_logs as p')
//            ->select(
//                'p.user_id as pid',
//                'p.amount'
//            )
//            ->joinSub($allUsersQuery, 'u', function ($join) {
//                $join->on('p.user_id', '=', 'u.pid');
//            });
////            ->where('p.status', true)
////            ->where('p.payment_type', '=', 'subscription');
//
//        $subscribers = $subscribersQuery->get();
////dd($allUsers);
//        $result = DB::table(DB::raw('(' . $allUsersQuery->toSql() . ') as u'))
//            ->mergeBindings($allUsersQuery)
//            ->leftJoin(DB::raw('(' . $subscribersQuery->toSql() . ') as s'), function ($join) {
//                $join->on('s.pid', '=', 'u.pid');
//            })
//            ->mergeBindings($subscribersQuery)
//            ->selectRaw('count(DISTINCT s.pid) as subscriptions')
//            ->groupBy('u.pname')
//            ->get();
//




//-------------------------------  Виджет кол-ва активных подписчиков  -----------------------------------


//        $activeScribers = DB::table('users as u')
//            ->select('u.id as partner_id', 'pp.name as partner_name', 'u.status AS status,', DB::raw("CAST(u.registered_params AS jsonb) ->> 'source' as src"))
//            ->join('partners as pp', 'pp.id', '=', 'u.partner_id')
//            ->join('sources as s', function ($join) {
//                $join->on(DB::raw("CAST(u.registered_params AS jsonb) ->> 'source'"), '=', 's.name');
//            })
//            ->leftJoin('payment_logs as p', 'u.id', '=', 'p.user_id')
//            ->where('s.offer_id', 6)
//            ->where('pp.id', $authUser)
//            ->whereNotNull('pp.name')
//            ->where('p.status', true)
//            ->where('p.payment_type', '=', 'subscription')
////            ->addSelect(DB::raw('u.pid'))
//            ->whereIn('u.status', ['subscribed', 'lite'])
////            ->groupBy('pp.name')
//            ->get();
//        $acive_subscriptions = $activeScribers->count();

//        $subscribers = DB::table('users as u')
//            ->join('sources as s', 's.name', '=', DB::raw("cast(u.registered_params as jsonb) ->> 'source'"))
//            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
//            ->select('u.id as pid', 'u.status as status', 'pp.name as pname', DB::raw("cast(u.registered_params as jsonb) ->> 'source' as src"))
//            ->whereRaw("cast(u.registered_params as jsonb) ->> 'source' IN (SELECT name FROM sources WHERE offer_id = 6)")
//            ->whereNotNull('pp.name')
//            ->where('pp.id', $authUser->id);
//
//        $subscribersCte = $subscribers->toSql();
//
//        $subscriptionsCount = DB::select("
//    SELECT count(distinct s.pid) as subscriptions
//    FROM ({$subscribersCte}) as all_users
//    LEFT JOIN ({$subscribersCte}) as s ON s.pid = all_users.pid
//", [$authUser->id, $authUser->id]);
//
//        $acive_subscriptions = $subscriptionsCount[0]->subscriptions;





//------------------------------- + Виджет Доступные балансы:  -----------------------------------


//        $data = DB::table('payment_logs as p')
//            ->select('ptp.amount', 'p.income')
//            ->join('users as u', 'u.id', '=', 'p.user_id')
//            ->join('sources as s', function ($join) {
//                $join->on(DB::raw("CAST(u.registered_params AS jsonb) ->> 'source'"), '=', 's.name');
//            })
//            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
//            ->join('payment_to_partners as ptp', 'pp.id', '=', 'ptp.partner_id')
//            ->where('p.status', true)
//            ->where('pp.id', $authUser->id)
//            ->groupBy('ptp.amount', 'p.income')
//            ->get();
//
//        $sum_Array = $data->groupBy('amount')->map(function($group) {
//            return $group->sum('income') / 2 - $group->first()->amount;
//        });
//
//        $available_balances = $sum_Array->sum();

//------------------------------- Таблица подписчиков  -----------------------------------

//        $sourceNames = DB::table('sources')
//            ->where('offer_id', 6)
//            ->pluck('name');
//
//        $allUsers = DB::table('users AS u')
//            ->select('u.id AS pid', 'pp.name as pname', DB::raw("CAST(u.registered_params AS jsonb) ->> 'source' as src"))
//                ->join('sources AS s', DB::raw('s.name'), '=', DB::raw('cast(u.registered_params as jsonb) ->> \'source\''))
//                ->join('partners AS pp', 'pp.id', '=', 's.partner_id')
//                ->whereIn(DB::raw('cast(u.registered_params as jsonb) ->> \'source\''), $sourceNames)
//                ->whereNotNull('pp.name')
//                ->where('pp.id', $authUser->id)
//    ->get();


//        $subscribers = DB::table('payment_logs AS p')
//    ->select('p.user_id AS pid', 'p.amount')
//    ->join('users AS u', 'u.id', '=', 'p.user_id')
//    ->where('p.status', true)
//    ->where('p.payment_type', 'subscription')
//    ->get();
//
//        $result = $allUsers
//            ->leftJoin('subscribers AS s', 's.pid', '=', 'u.pid')
//            ->groupBy('u.pname')
//            ->selectRaw('count(DISTINCT s.pid) AS subscriptions')
//            ->get();
//
//
//        $tableScribers = $allUsers
//            ->groupBy('pname')
//            ->map(function ($group) {
//                return [
//                    'pname' => $group->first()->pname,
//                    'subscriptions' => $group->pluck('uid')->unique()->count(),
//                ];
//            })
////            ->intersect($subscribers)
//            ->values()
//            ->toArray();

        //++++++++++++
//        $tableScribers = DB::table('payment_logs as p')
//            ->select(
//                DB::raw('DATE(p.created_at) as day'),
//                DB::raw('COUNT(DISTINCT u.id) as registered'),
//                DB::raw('COUNT(p.id) as subscribed'),
//                DB::raw('COALESCE(COUNT(p.id) * 100.0 / COUNT(DISTINCT u.id), 0) AS cr'),
//                DB::raw('COUNT(DISTINCT p.user_id) as trx'),
//                DB::raw('SUM(p.income) / 2 as total_income')
//            )
//            ->join('users as u', 'u.id', '=', 'p.user_id')
//            ->join('sources as s', 's.name', '=', DB::raw("CAST(u.registered_params AS jsonb) ->> 'source'"))
//            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
//            ->where('p.offer_id', 6)
//            ->where('p.status', true)
//            ->where('pp.id', $authUser->id)
//            ->whereIn('p.amount', [1, 20, 99, 100, 499])
//            ->whereIn(DB::raw("CAST(u.registered_params AS jsonb) ->> 'source'"), function ($query) {
//                $query->select('name')->from('sources')->where('offer_id', 6);
//            })
//            ->when($request->filled('dateFrom'), function ($query) use ($request) {
//                $query->whereDate('p.created_at', '>=', $request->input('dateFrom'));
//            })
//            ->when($request->filled('dateTo'), function ($query) use ($request) {
//                $query->whereDate('p.created_at', '<=', $request->input('dateTo'));
//            })
//
//            ->groupBy('day')
//            ->orderByDesc('total_income')
//            ->get();
//----------------------------------------------
//        $data = DB::table('payment_logs as p')
//            ->selectRaw('cast(u.registered_params as jsonb) ->> \'source\' as src, p.user_id as pid, p.income, DATE(p.created_at) as day, p.amount')
//            ->join('users as u', 'u.id', '=', 'p.user_id')
//            ->join('sources as s', function ($join) {
//                $join->on('s.name', '=', DB::raw('cast(u.registered_params as jsonb) ->> \'source\''));
//            })
//            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
//            ->where('p.offer_id', 6)
//            ->where('p.status', true)
//            ->where('pp.id', $authUser->id);
////
//        $dataSql = $data->toSql();
////
//        $sourceNames = DB::table('sources')->select('id', 'name')->where('offer_id', 6)->get();
////        $sourceNames = DB::table('sources')->select('name')->where('offer_id', 6)->pluck('name');
////        $sourceNamesArray = $sourceNames->pluck('name')->toArray();
////
//        $registeredBySource = DB::table('users as u')
//            ->selectRaw('u.created_at::date as day, COUNT(u.id) as cnt, cast(u.registered_params as jsonb) ->> \'source\' as src')
//            ->join('sources as s', 's.name', '=', DB::raw('cast(u.registered_params as jsonb) ->> \'source\''))
//            ->join('partners as pp', 'pp.id', '=', 's.partner_id')
//            ->where('u.offer_id', 6)
//            ->whereIn(DB::raw('cast(u.registered_params as jsonb) ->> \'source\''), $sourceNames->pluck('name')->toArray())
//            ->groupBy('day', 'src');
//
//        $registeredBySourceSql = $registeredBySource->toSql();
//
//        $subscribedBySource = DB::table('payment_logs as p')
//            ->selectRaw('p.created_at::date as day, COUNT(p.id) as cnt, cast(u.registered_params as jsonb) ->> \'source\' as src')
//            ->join('users as u', 'u.id', '=', 'p.user_id')
//            ->where('p.offer_id', 6)
//            ->where('p.status', true)
//            ->whereIn('p.amount', [1, 20, 99, 100, 499])
//            ->groupBy('day', 'src');
//
//        $subscribedBySourceSql = $subscribedBySource->toSql();

//****************************

//        $tableScribers = DB::table(DB::raw("({$data->toSql()}) as data"))
//            ->mergeBindings($data)
//            ->leftJoin(DB::raw("({$registeredBySource->toSql()}) as registered_by_source"), function ($join) {
//                $join->on('registered_by_source.day', '=', 'data.day')
//                    ->on('registered_by_source.src', '=', 'data.src');
//            })
//            ->leftJoin(DB::raw("({$subscribedBySource->toSql()}) as subscribed_by_source"), function ($join) {
//                $join->on('subscribed_by_source.day', '=', 'data.day')
//                    ->on('subscribed_by_source.src', '=', 'data.src');
//            })
//            ->leftJoin('source_names as n', 'n.name', '=', 'data.src')
//            ->select('data.day', 'registered_by_source.cnt as registered', 'subscribed_by_source.cnt as subscribed',
//                DB::raw('COALESCE(subscribed_by_source.cnt * 100.0 / registered_by_source.cnt, 0) AS cr'),
//                DB::raw('count(data.income) as trx'),
//                DB::raw('sum(data.income)/2 as total_income'))
//            ->groupBy('data.day', 'registered', 'subscribed')
//            ->orderByDesc('day')
//            ->orderByDesc('total_income')
//            ->get();
//********************************

//        $tableScribers = DB::table(DB::raw("({$data->toSql()}) as data"))
//            ->mergeBindings($data)
//            ->leftJoin(DB::raw("({$registeredBySource->toSql()}) as registered_by_source"), function ($join) {
//                $join->on('registered_by_source.day', '=', 'data.day')
//                    ->on('registered_by_source.src', '=', 'data.src');
//            })
//            ->leftJoin(DB::raw("({$subscribedBySource->toSql()}) as subscribed_by_source"), function ($join) {
//                $join->on('subscribed_by_source.day', '=', 'data.day')
//                    ->on('subscribed_by_source.src', '=', 'data.src');
//            })
//            ->leftJoin(DB::raw('(VALUES ' . implode('),', array_fill(0, count($sourceNamesArray), '(?)')) . ') as n(name)'), 'n.name', '=', 'data.src')
//            ->addBinding($sourceNamesArray, 'select')
//            ->select('data.day', 'registered_by_source.cnt as registered', 'subscribed_by_source.cnt as subscribed',
//                DB::raw('COALESCE(subscribed_by_source.cnt * 100.0 / registered_by_source.cnt, 0) AS cr'),
//                DB::raw('count(data.income) as trx'),
//                DB::raw('sum(data.income)/2 as total_income'))
//            ->groupBy('data.day', 'registered', 'subscribed')
//            ->orderByDesc('day')
//            ->orderByDesc('total_income')
//            ->get();
//-----------------------------------------------


//        $tableScribers = DB::table(DB::raw("({$dataSql}) as data"))
//            ->mergeBindings($data)
//            ->leftJoin(DB::raw("({$registeredBySourceSql}) as registered_by_source"), function ($join) {
//                $join->on('registered_by_source.day', '=', 'data.day')
//                    ->on('registered_by_source.src', '=', 'data.src');
//            })
//            ->leftJoin(DB::raw("({$subscribedBySourceSql}) as subscribed_by_source"), function ($join) {
//                $join->on('subscribed_by_source.day', '=', 'data.day')
//                    ->on('subscribed_by_source.src', '=', 'data.src');
//            })
//            ->select('data.day', 'registered_by_source.cnt as registered', 'subscribed_by_source.cnt as subscribed',
//                DB::raw('COALESCE(subscribed_by_source.cnt * 100.0 / registered_by_source.cnt, 0) AS cr'),
//                DB::raw('count(data.income) as trx'),
//                DB::raw('sum(data.income)/2 as total_income'))
//            ->groupBy('data.day', 'registered', 'subscribed')
//            ->orderByDesc('day')
//            ->orderByDesc('total_income')
//            ->get();




//        return Inertia::render('Dashboard/Index', ['source_name' => $user->source->name, 'widget_total_income' => $totalIncome, 'widget_available_balances'=> $available_balances, 'widget_period_subscribed' => $all_subscriptions, 'widget_active_subscribed' => $acive_subscriptions, 'tableScribers' => DateFilterResource::collection($tableScribers), 'isLoading' => false]);

        return Inertia::render('Dashboard/Index', ['source_name' => $source_name->name, 'widget_total_income' => 21, 'widget_available_balances'=> 21, 'widget_period_subscribed' => 21, 'widget_active_subscribed' => 21]);

    }
}
