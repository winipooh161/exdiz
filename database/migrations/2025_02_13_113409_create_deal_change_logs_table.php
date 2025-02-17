<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealChangeLogsTable extends Migration
{
    /**
     * Запуск миграции.
     */
    public function up()
    {
        Schema::create('deal_change_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deal_id');
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
            $table->json('changes'); // JSON с изменёнными полями: ключ => ['old' => ..., 'new' => ...]
            $table->timestamps();

            $table->index('deal_id');
            $table->foreign('deal_id')->references('id')->on('deals')->onDelete('cascade');
        });
    }

    /**
     * Откат миграции.
     */
    public function down()
    {
        Schema::dropIfExists('deal_change_logs');
    }
}
