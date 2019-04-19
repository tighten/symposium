<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTalkRevisionsTable extends Migration {
	public function up()
	{
		Schema::table('talk_revisions', function(Blueprint $table)
		{
			$table->foreign('talk_id')->references('id')->on('talks')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}

	public function down()
	{
		Schema::table('talk_revisions', function(Blueprint $table)
		{
			$table->dropForeign('talk_revisions_talk_id_foreign');
		});
	}

}
