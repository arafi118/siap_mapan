<?php

use App\Models\Account;
use App\Models\Usage;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Account::class, 'rekening_debit');
            $table->foreignIdFor(Account::class, 'rekening_kredit');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Usage::class);
            $table->integer('total');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
