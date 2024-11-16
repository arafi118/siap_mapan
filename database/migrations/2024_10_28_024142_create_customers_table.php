<?php

use App\Models\Business;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Business::class)->nullable();
            $table->foreignIdFor(Village::class, 'desa')->nullable();
            $table->string('nama');
            $table->string('nama_panggilan')->nullable();
            $table->string('nik');
            $table->string('jk')->nullable();
            $table->text('alamat');
            $table->text('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->text('domisi')->nullable();
            $table->char('hp')->nullable();
            $table->string('kk')->nullable();
            $table->string('agama')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->string('penjamin')->nullable();
            $table->char('nik_penjamin')->nullable();
            $table->string('hubungan')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('tempat_kerja')->nullable();
            $table->string('usaha')->nullable();
            $table->text('foto')->nullable();
            $table->date('terdaftar')->nullable();
            $table->string('status')->nullable();
            $table->string('petugas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
