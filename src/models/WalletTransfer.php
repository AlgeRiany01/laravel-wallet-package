<?php

namespace algeriany\wallet\Models;

use algeriany\wallet\Models\Wallet;
use Illuminate\Database\Eloquent\Model;

class WalletTransfer extends Model
{

    protected $fillable = [
        'from_wallet_id',
        'to_wallet_id',
        'amount',
    ];


    public function fromWallet()
    {
        return $this->belongsTo(Wallet::class, 'from_wallet_id');
    }

    public function toWallet()
    {
        return $this->belongsTo(Wallet::class, 'to_wallet_id');
    }
}
