<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personal_addresses', function (Blueprint $blueprint) {
            $blueprint->string('image_path')->nullable()->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('personal_addresses', function (Blueprint $blueprint) {
            $blueprint->dropColumn('image_path');
        });
    }
};