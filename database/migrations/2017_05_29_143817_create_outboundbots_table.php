<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutboundBotsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('outbound_bots', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('phone_number');
            $table->integer('customer_list_id');
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
		Schema::drop('outbound_bots');
	}

}
