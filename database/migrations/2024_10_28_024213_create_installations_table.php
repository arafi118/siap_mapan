<?php

use App\Models\Package;
use App\Models\Village;
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
        Schema::create('installations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Package::class);
            $table->foreignIdFor(Village::class, 'desa');
            $table->text('lokasi');
            $table->string('status');
            $table->date('order');
            $table->date('pasang');
            $table->date('aktif');
            $table->date('blokir');
            $table->date('cabut');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installations');
    }
};
