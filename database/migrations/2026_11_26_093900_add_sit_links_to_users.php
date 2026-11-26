<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $schema = Schema::connection('creditos');

        $schema->table('users', function (Blueprint $table) use ($schema) {
            if (! $schema->hasColumn('users', 'sit_user_id')) {
                $table->unsignedBigInteger('sit_user_id')->nullable()->index();
            }
            if (! $schema->hasColumn('users', 'sit_catedratico_id')) {
                $table->unsignedBigInteger('sit_catedratico_id')->nullable()->index();
            }
        });
    }

    public function down(): void
    {
        $schema = Schema::connection('creditos');

        $schema->table('users', function (Blueprint $table) use ($schema) {
            if ($schema->hasColumn('users', 'sit_catedratico_id')) {
                $table->dropIndex(['sit_catedratico_id']);
                $table->dropColumn('sit_catedratico_id');
            }
            if ($schema->hasColumn('users', 'sit_user_id')) {
                $table->dropIndex(['sit_user_id']);
                $table->dropColumn('sit_user_id');
            }
        });
    }
};
