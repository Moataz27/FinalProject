<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('access_token', 64)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('password');
            $table->integer('start_at')->nullable();
            $table->integer('grade')->nullable();
            $table->string('image')->nullable();
            $table->text('bio')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
