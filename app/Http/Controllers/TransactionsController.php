<?php

namespace App\Http\Controllers;

use App\Models\AssetValues;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public static $types = [
        'topup' => 'Topup',
        'withdraw' => 'Withdraw',
    ];

    protected $transactions;

    protected $user;

    protected $assetValues;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->assetValues = AssetValues::orderBy('created_at', 'desc')->first();
        $this->user = User::find($this->request->user_id);
        $this->transactions = new Transactions();

        $this->transactions->user_id = $this->request->user_id;
        $this->transactions->amount = $this->request->amount_rupiah;
        $this->transactions->unit_value = round($this->transactions->amount / $this->assetValues->nab, 4, PHP_ROUND_HALF_DOWN);

        return $this;
    }

    public function topup()
    {
        $this->transactions->type = TransactionsController::$types['topup'];
        $this->user->total_unit += $this->transactions->unit_value;
        $this->transactions->total_unit_value = round($this->user->total_unit, 4, PHP_ROUND_HALF_DOWN);
        $this->transactions->total_balance = round($this->transactions->total_unit_value * $this->assetValues->nab, 4, PHP_ROUND_HALF_DOWN);

        return $this;
    }

    public function withdraw()
    {
        $this->transactions->type = TransactionsController::$types['withdraw'];
        $this->user->total_unit -= $this->transactions->unit_value;
        $this->transactions->total_unit_value = round($this->user->total_unit, 4, PHP_ROUND_HALF_DOWN);
        $this->transactions->total_balance = round($this->transactions->total_unit_value * $this->assetValues->nab, 4, PHP_ROUND_HALF_DOWN);

        return $this;
    }

    /**
     * Save a newly created transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save()
    {
        \DB::beginTransaction();

        try {

            $this->user->save();
            $this->transactions->save();

        } catch (\Exception $e) {
            \DB::rollback();

            throw new HttpResponseException(
                response()->json([
                    'data' => 'Not Found',
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ], 400)
            );
        }

        \DB::commit();

        return $this->transactions;
    }
}
