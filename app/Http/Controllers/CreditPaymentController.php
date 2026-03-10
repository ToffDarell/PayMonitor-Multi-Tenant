<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditPaymentRequest;
use App\Models\Credit;
use App\Models\CreditPayment;

class CreditPaymentController extends Controller
{
    public function store(CreditPaymentRequest $request, Credit $credit): \Illuminate\Http\RedirectResponse
    {
        abort_if($credit->tenant_id !== auth()->user()->tenant_id, 403);

        $payment = $request->amount;

        CreditPayment::create([
            'credit_id'      => $credit->id,
            'user_id'        => auth()->id(),
            'amount'         => $payment,
            'payment_method' => $request->payment_method,
            'notes'          => $request->notes,
            'paid_at'        => now(),
        ]);

        $newAmountPaid = $credit->amount_paid + $payment;
        $newBalance = $credit->balance - $payment;

        $credit->update([
            'amount_paid' => $newAmountPaid,
            'balance'     => max(0, $newBalance),
            'status'      => $newBalance <= 0 ? 'paid' : $credit->status,
        ]);

        return redirect()->route('credits.show', $credit)->with('success', 'Payment recorded successfully.');
    }
}