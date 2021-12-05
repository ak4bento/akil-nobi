<?php

namespace App\Http\Requests;

use App\Models\AssetValues;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class WithdrawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $balance = 0;

        $user = User::find($this->user_id);

        $assetValue = AssetValues::orderBy('created_at', 'desc')->first();

        $balance = $user->total_unit * $assetValue->nab;

        $rules = [
            'user_id' => 'required|integer|exists:users,id',
            'amount_rupiah' => 'required|integer|min:1|max:' . $balance,
        ];

        return $rules;
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'data' => $validator->errors(),
            'status' => 'error',
            'message' => 'Data anda tidak dapat di proses',
        ], 422));
    }
}
