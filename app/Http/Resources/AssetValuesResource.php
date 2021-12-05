<?php

namespace App\Http\Resources;

use Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetValuesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (Request::is('api/v1/ib/listNAB')) {
            $data = [
                'nab' => $this->nab,
                'date' => $this->created_at,
            ];
        } else {
            $data = [
                'nab' => $this->nab,
                'current_balance' => $this->current_balance,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
        }

        return $data;
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'status' => '201',
            'message' => $this->nab,
        ];
    }
}
