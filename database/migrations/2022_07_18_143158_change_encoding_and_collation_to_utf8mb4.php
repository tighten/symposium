<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
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
        DB::raw('ALTER DATABASE ' . config('database.connections.mysql.database') . ' CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci');

        $tables = [
            'bios',
            'conferences',
            'favorites',
            'migrations',
            'oauth_access_token_scopes',
            'oauth_access_tokens',
            'oauth_auth_code_scopes',
            'oauth_auth_codes',
            'oauth_client_endpoints',
            'oauth_client_grants',
            'oauth_client_scopes',
            'oauth_clients',
            'oauth_grant_scopes',
            'oauth_grants',
            'oauth_refresh_tokens',
            'oauth_scopes',
            'oauth_session_scopes',
            'oauth_sessions',
            'password_resets',
            'submissions',
            'talk_revisions',
            'talks',
            'users'
        ];

        foreach ($tables as $table) {
            DB::statement('ALTER TABLE ' . $table . ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');

            // @todo: Get DBAL to get every column in the table for each, generate a create statement for it, and modify that stateent to be new collation/encoding
            // e.g. ALTER TABLE {$table} CHANGE {$column} {$column} {$columnDetails} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        }

        DB::raw('SET FOREIGN_KEY_CHECKS=1;');
    }
}
