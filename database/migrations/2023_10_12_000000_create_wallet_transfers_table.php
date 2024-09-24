<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTransfersTable extends Migration
{
    public function up()
    {
        Schema::create('wallet_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_wallet_id');
            $table->unsignedBigInteger('to_wallet_id');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            $table->foreign('from_wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('to_wallet_id')->references('id')->on('wallets')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('wallet_transfers');
    }
}