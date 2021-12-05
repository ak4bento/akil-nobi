<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopUpRequest;
use Illuminate\Http\Request;
use App\Http\Resources\TopUpResource;

class TopUpController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopUpRequest $request)
    {
        $transaction = new TransactionsController($request);

        return new TopUpResource($transaction->create()->topup()->save());
    }
}
