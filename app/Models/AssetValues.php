<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetValues extends Model
{
    use HasFactory;

    protected $fillable = [
        'nab',
        'current_balance',
    ];

    public function getTotalBalance()
    {
        return $this->sum('current_balance');
    }
}
