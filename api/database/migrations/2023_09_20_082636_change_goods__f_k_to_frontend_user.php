<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table){
            $table->rename('backend_users');
        });
        Schema::table('goods', function (Blueprint $table){
            $table->dropForeign('goods_user');
            $table->foreign('author_id')
                ->references('id')
                ->on('frontend_users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('backend_users', function (Blueprint $table){
            $table->rename('user');
        });
        Schema::table('goods', function (Blueprint $table) {
            $table->dropForeign('goods_author_id_foreign');
            $table->foreign('author_id')
                ->references('id')
                ->on('user')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }
};
