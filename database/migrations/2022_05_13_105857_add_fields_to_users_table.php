<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('image')->after('password')->nullable();
            $table->string('mobile_no')->after('image')->nullable();
            $table->text('address')->after('mobile_no')->nullable();
            $table->string('user_no')->after('address')->nullable();
            $table->integer('status')->after('user_no')->default(1);
            $table->unsignedBigInteger('added_by')->after('status')->nullable();
            $table->foreign('added_by')->references('id')->on('users');
            $table->integer('is_super_admin')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('mobile_no');
            $table->dropColumn('address');
            $table->dropColumn('user_no');
            $table->dropColumn('status');
            $table->dropForeign(['added_by']);
            $table->dropColumn('added_by');
            $table->dropColumn('is_super_admin');
        });
    }
}
 