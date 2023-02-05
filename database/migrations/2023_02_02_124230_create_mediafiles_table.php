<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediafilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mediafiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('storage_type')->nullable(); // 0 - local file
            $table->string('uri', 1024);
            $table->char('sha256checksum', 32)->charset('binary')->unique(); // контрольная сумма файла SHA-256
            $table->foreignId('user_id') //author
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
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
        Schema::dropIfExists('mediafiles');
    }
}
