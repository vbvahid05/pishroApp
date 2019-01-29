<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acl_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('actn_title');
            $table->string('actn_actn_slug');
            $table->string('actn_details');
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
        Schema::dropIfExists('acl_actions');
    }
}
