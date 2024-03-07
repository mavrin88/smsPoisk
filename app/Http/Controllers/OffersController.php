<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ExpensesResource;
use App\Http\Requests\CreateExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Repositories\Interfaces\ExpensesRepositoryInterface;

class OffersController extends Controller
{
//    private Expenses $expenses;
//    private ExpensesRepositoryInterface $expensesRepository;
//    private const PER_PAGE = 20;
//
//    public function __construct(Expenses $expenses, ExpensesRepositoryInterface $expensesRepository)
//    {
//        $this->expenses = $expenses;
//        $this->expensesRepository = $expensesRepository;
//    }

    public function index(Request $request)
    {
        $dateFrom = $request->get('dateFrom');
        $dateTo = $request->get('dateTo');

    }

}
