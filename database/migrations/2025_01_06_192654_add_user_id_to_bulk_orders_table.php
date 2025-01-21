<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToBulkOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('bulk_orders', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->after('status'); // Adding the user_id column
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Setting up the foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('bulk_orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
