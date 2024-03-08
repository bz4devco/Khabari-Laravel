<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_comments', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->unsignedBigInteger('commentable_id');
            $table->string('commentable_type');
            $table->tinyInteger('seen')->default(0)->comment('0 => unseen and not seen with admins, 1 => seened with admin');
            $table->tinyInteger('approved')->default(0)->comment('0 => not approved  with admin , 1 => approved with admin');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('guest_comments');
    }
}
