<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'total_unit',
    ];

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }

    public function getTotalUnit()
    {
        return $this->sum('total_unit');
    }

    public function getCurrentNabAttribute(): float
    {
        $assetValues = AssetValues::orderBy('created_at', 'desc')->first();

        return $assetValues->nab ?? 0;
    }

    public function getTotalBalanceAttribute()
    {
        return round($this->current_nab * $this->total_unit, 4, PHP_ROUND_HALF_DOWN);
    }
}
