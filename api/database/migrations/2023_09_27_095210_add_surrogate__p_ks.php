<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders_goods', function (Blueprint $table) {
            $table->id();
        });
        Schema::table("attributes_boolean", function (Blueprint $table) {
            //dropping composite PK
            DB::unprepared('ALTER TABLE attributes_boolean DROP CONSTRAINT attributes_boolean_pkey');
            $table->id();
        });
        Schema::table("attributes_dictionary_values", function (Blueprint $table) {
            DB::unprepared('ALTER TABLE attributes_dictionary_values DROP CONSTRAINT attributes_dictionary_values_pkey');
            $table->id();
        });
        Schema::table("attributes_text", function (Blueprint $table) {
            DB::unprepared('ALTER TABLE attributes_text DROP CONSTRAINT attributes_text_pkey');
            $table->id();
        });
        Schema::table("attributes_float", function (Blueprint $table) {
            DB::unprepared('ALTER TABLE attributes_float DROP CONSTRAINT attributes_float_pkey');
            $table->id();
        });
        Schema::table("attributes_integer", function (Blueprint $table) {
            DB::unprepared('ALTER TABLE attributes_integer DROP CONSTRAINT attributes_integer_pkey');
            $table->id();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders_goods', function (Blueprint $table) {
            $table->dropPrimary("id");
            $table->dropColumn("id");
        });
        Schema::table("attributes_boolean", function (Blueprint $table) {
            $table->dropPrimary("id");
            $table->dropColumn("id");
            $table->primary(["attribute_id", "goods_id"]);
        });
        Schema::table("attributes_dictionary_values", function (Blueprint $table) {
            $table->dropPrimary("id");
            $table->dropColumn("id");
            $table->primary(["attribute_id", "goods_id"]);
        });
        Schema::table("attributes_text", function (Blueprint $table) {
            $table->dropPrimary("id");
            $table->dropColumn("id");
            $table->primary(["attribute_id", "goods_id"]);
        });
        Schema::table("attributes_float", function (Blueprint $table) {
            $table->dropPrimary("id");
            $table->dropColumn("id");
            $table->primary(["attribute_id", "goods_id"]);
        });
        Schema::table("attributes_integer", function (Blueprint $table) {
            $table->dropPrimary("id");
            $table->dropColumn("id");
            $table->primary(["attribute_id", "goods_id"]);
        });
    }
};
