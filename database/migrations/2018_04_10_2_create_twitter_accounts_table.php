<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateTwitterAccountsTable extends Migration
{
    public function up(): void
    {
        Schema::create(
            'twitter_accounts',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('username');
                $table->string('access_token');
                $table->string('access_token_secret');
                $table->string('consumer_key');
                $table->string('consumer_secret');
                $table->timestamps();

                $table->unique('user_id');
                $table->foreign(['user_id'])->references(['id'])->on('users')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('twitter_accounts');
    }
}
