<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSantrisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('santris', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_hp')->nullable();
            $table->string('no_kamar')->nullable();
            $table->enum("status", ['sekolah', 'kuliah', 'kerja', 'mencari pekerjaan']);
            $table->string('instansi')->nullable();
            $table->string('prodi')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tahun_masuk')->nullable();
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('santris');
    }
}
