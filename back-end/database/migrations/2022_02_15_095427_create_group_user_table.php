<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('group_user')) {
                Schema::create('group_user', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('group_id')->constrained('groups', 'id');
                    $table->foreignId('user_id')->constrained('users', 'id')->unique();
                    $table->timestamps();
                });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_user');
    }
}
