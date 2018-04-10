<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class CreateTwitterAccountStatisticsTable extends Migration
{
    public function up(): void
    {
        Schema::create(
            'twitter_account_statistics',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('twitter_account_id')->unsigned();
                $table->integer('follower_count')->unsigned();
                $table->integer('following_count')->unsigned();
                $table->integer('friends_count')->unsigned();
                $table->integer('listed_count')->unsigned();
                $table->string('profile_image_url')->nullable();
                $table->timestamps();

                $table->index('twitter_account_id');
                $table->foreign(['twitter_account_id'])
                    ->references(['id'])
                    ->on('twitter_accounts')
                    ->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('twitter_account_statistics');
    }
}
