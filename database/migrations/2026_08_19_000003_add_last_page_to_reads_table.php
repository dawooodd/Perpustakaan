<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reads', function (Blueprint $table) {
            $table->unsignedInteger('last_page')->default(0)->after('last_read_at');
            $table->foreignId('last_chapter_id')->nullable()->after('last_page')->constrained('chapters')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('reads', function (Blueprint $table) {
            $table->dropForeign(['last_chapter_id']);
            $table->dropColumn(['last_page', 'last_chapter_id']);
        });
    }
};
