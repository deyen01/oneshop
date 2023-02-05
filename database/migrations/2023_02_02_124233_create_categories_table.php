<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255); // название категории
            $table->unsignedBigInteger('parent_id') // родительская категория
                ->nullable();
            $table->foreignId('picture_id') // картинка категории
                ->nullable()
                ->constrained('mediafiles')
                ->cascadeOnUpdate()
                ->nullOnDelete();
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
        Schema::dropIfExists('categories');
    }
}
