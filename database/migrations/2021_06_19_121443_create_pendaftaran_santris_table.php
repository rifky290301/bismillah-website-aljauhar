<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaranSantrisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran_santris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nama_panggilan');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('email');
            $table->string('status');
            $table->string('tempat_status');
            $table->string('orang_tua_wali');
            $table->string('pekerjaan_orang_tua_wali');
            $table->string('alamat');
            $table->string('desa_kelurahan');
            $table->string('kecamatan');
            $table->string('kabupaten_kota');
            $table->string('kodepos');
            $table->string('no_telepon');
            $table->string('no_telepon_keluarga');
            $table->string('ukuran_jas_almamater');
            $table->string('pas_foto')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftaran_santris');
    }
}
