<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use App\Models\Payments;
use App\Models\TicketsEmailQueues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoices::query()
            ->with('payments')
            ->get();

        $payments30days = Payments::query()
            ->where('paidAt', '>', now()->subDays(30))
            ->get();

        $paymentsYear = Payments::query()
            ->where('paidAt', '>', now()->subDays(365))
            ->get();

        $monthsPayments = Payments::query()
            ->selectRaw('MONTH(paidAt) as month, SUM(paidAmount) as total')
            ->groupBy('month')
            ->get();

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = 0;
        }
        $monthsPayments->each(function ($item) use (&$months) {
            $months[$item->month] = $item->total;
        });

        $payments_30days = $payments30days->sum('paidAmount');
        $payments_year = $paymentsYear->sum('paidAmount');
        $invoices_total = $invoices->where('paid', false)
            ->where('debtDueDate', '<', now())
            ->sum('debtAmount');

        return view('dashboard', [
            'invoices'        => $invoices,
            'payments_30days' => $this->moneyFormat($payments_30days),
            'payments_year'   => $this->moneyFormat($payments_year),
            'invoices_total'  => $this->moneyFormat($invoices_total),
            'months'          => $months,
        ]);
    }

    public function payments(Request $request)
    {
        $payments = Payments::query()
            ->get();

        return view('payments', [
            'payments' => $payments,
        ]);
    }

    public function emailsQueue(Request $request)
    {
        $emails = TicketsEmailQueues::all();
        return view('emails-queue', [
            'emails' => $emails,
        ]);
    }

    public function invoices(Request $request)
    {
        $invoices = Invoices::query()
            ->with('payments')
            ->get();

        return view('invoices', [
            'invoices' => $invoices,
        ]);
    }
}
