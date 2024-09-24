<?php

namespace algeriany\wallet\Services;

use algeriany\wallet\Models\Wallet;
use Illuminate\Support\Facades\Log;
use algeriany\wallet\Models\WalletTransfer;

class WalletService
{
    public function createWallet($walletable, $initialBalance = 0)
    {
        $wallet = $walletable->wallet()->first();
        if ($wallet) {
            return  $wallet->increment('balance', $initialBalance);
        } else {
            return $walletable->wallet()->create([
                'balance' => $initialBalance,
            ]);
        }
    }

    public function addFunds($wallet, $amount)
    {
        $wallet->balance += $amount;
        $wallet->save();
    }

    public function deductFunds($wallet, $amount)
    {
        if ($wallet->balance >= $amount) {
            $wallet->balance -= $amount;
            $wallet->save();
        } else {
            throw new \Exception(__("Insufficient funds"));
        }
    }

    public function transferFunds(Wallet $fromWallet, Wallet $toWallet, float $amount)
    {

        if ($amount <= 0) {
            throw new \Exception(__('The transfer amount must be greater than zero.'));
        }


        if ($fromWallet->balance < $amount) {
            throw new \Exception(__("Insufficient funds in the source wallet."));
        }

        Log::info("Transfer initiated: From Wallet ID {$fromWallet->id} to Wallet ID {$toWallet->id} with amount {$amount}");

        $fromWallet->balance = bcsub($fromWallet->balance, $amount, 2);
        $fromWallet->save();


        $toWallet->balance = bcadd($toWallet->balance, $amount, 2);
        $toWallet->save();


        $this->recordTransfer($fromWallet->id, $toWallet->id, $amount);
        Log::info("Transfer successful: {$amount} transferred from Wallet ID {$fromWallet->id} to Wallet ID {$toWallet->id}");
    }

    protected function recordTransfer($fromWalletId, $toWalletId, $amount)
    {
        WalletTransfer::create([
            'from_wallet_id' => $fromWalletId,
            'to_wallet_id' => $toWalletId,
            'amount' => $amount,
        ]);
    }
}
