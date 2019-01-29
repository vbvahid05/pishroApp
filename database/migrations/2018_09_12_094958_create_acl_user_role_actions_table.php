<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclUserRoleActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acl_user_role_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ura_user_id') ;
            $table->integer('ura_roleAction_id');
            $table->string('ura_details');
            $table->integer   ('deleted_flag');
            $table->integer   ('archive_flag');
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
        Schema::dropIfExists('acl_user_role_actions');
    }
}
