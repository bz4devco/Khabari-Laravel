<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->nullable()->comment("new title for url request slug");
            $table->foreignId('category_id')->constrained('new_categories');
            $table->text('image')->nullable();
            $table->text('abstract');
            $table->text('body');
            $table->integer('visit_counter');
            $table->tinyInteger('commentable')->default(0)->comment('0 => uncommentable, 1 => commentable');
            $table->string('tag');
            $table->integer('sort')->default(1);
            $table->tinyInteger('status');
            $table->timestamp('new_date');            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
