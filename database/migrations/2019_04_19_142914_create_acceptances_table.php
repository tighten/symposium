<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcceptancesTable extends Migration {
	public function up()
	{
		Schema::create('acceptances', function(Blueprint $table)
		{
			$table->char('id', 36)->primary();
			$table->string('talk_revision_id', 36);
			$table->string('conference_id', 36)->index('acceptances_conference_id_foreign');
			$table->timestamps();
			$table->unique(['talk_revision_id','conference_id'], 'acceptances_talk_revision_conference_unique');
		});
	}

	public function down()
	{
		Schema::drop('acceptances');
	}

}
