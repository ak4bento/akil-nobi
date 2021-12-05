<?php

namespace App\Http\Controllers;

use App\Http\Requests\WithdrawRequest;
use App\Http\Resources\WithdrawResource;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WithdrawRequest $request)
    {
        $transaction = new TransactionsController($request);

        return new WithdrawResource($transaction->create()->withdraw()->save());
    }
}
