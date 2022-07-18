<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected $tables = [
        'acceptances',
        'bios',
        'conferences',
        'dismissed_conferences',
        'failed_jobs',
        'favorites',
        'firewall',
        'migrations',
        'oauth_access_tokens',
        'oauth_auth_codes',
        'oauth_clients',
        'oauth_personal_access_clients',
        'oauth_refresh_tokens',
        'password_resets',
        'rejections',
        'submissions',
        'talk_reactions',
        'talk_revisions',
        'talks',
        'users',
        'users_social',
    ];

    public function up()
    {
        $this->changeAll('utf8mb4', 'utf8mb4_unicode_ci');
    }

    public function down()
    {
        $this->changeAll('utf8', 'utf8_unicode_ci');
    }

    private function changeAll($encoding, $collation)
    {
        DB::raw('SET FOREIGN_KEY_CHECKS=0;');
        DB::raw('ALTER DATABASE ' . config('database.connections.mysql.database') . " CHARACTER SET = {$encoding} COLLATE = {$collation}");

        foreach ($this->tables as $table) {
            DB::statement("ALTER TABLE {$table} CONVERT TO CHARACTER SET {$encoding} COLLATE {$collation};");

            // @todo: Get DBAL to get every column in the table for each, generate a create statement for it, and modify that stateent to be new collation/encoding
            // e.g. ALTER TABLE {$table} CHANGE {$column} {$column} {$columnDetails} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        }

        DB::raw('SET FOREIGN_KEY_CHECKS=1;');
    }
}
