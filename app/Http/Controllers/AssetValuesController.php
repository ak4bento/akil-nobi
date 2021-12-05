<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetValuesRequest;
use App\Http\Resources\AssetValuesResource;
use App\Models\AssetValues;
use App\Models\User;
use Illuminate\Http\Request;

class AssetValuesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetValuesRequest $request, AssetValues $assetValues)
    {
        // $assetValuesLast = $assetValues->orderBy('created_at', 'desc')->first();;
        $model = new AssetValues;

        $user = new User;
        $totalUnit = $user->getTotalUnit();

        $model->nab = 1;
        if ($totalUnit > 0) {
            $model->nab = round($request->current_balance / $totalUnit, 4, PHP_ROUND_HALF_DOWN);
        }

        $model->current_balance = $request->current_balance;
        $model->save();

        return new AssetValuesResource($model);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssetValues  $assetValues
     * @return \Illuminate\Http\Response
     */
    public function show(AssetValues $assetValues,Request $request)
    {
        return AssetValuesResource::collection(
            $assetValues
                ->select('nab', 'created_at')
                ->orderBy('created_at', 'desc')
                ->paginate($request->limit ?? 20)
        );
    }
}
