<?php

namespace algeriany\wallet\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['balance'];
    public function transfers()
    {
        return $this->hasMany(WalletTransfer::class, 'from_wallet_id');
    }
    public function walletable()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->wallet_id = (string) Str::uuid();
        });
    }
}
