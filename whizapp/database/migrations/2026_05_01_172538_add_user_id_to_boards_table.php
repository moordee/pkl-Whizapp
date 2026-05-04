<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('boards')) {
            Schema::create('boards', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('share_token')->unique()->nullable();
                $table->boolean('is_public')->default(false);
                $table->timestamps();
            });
        } else {
            Schema::table('boards', function (Blueprint $table) {
                if (!Schema::hasColumn('boards', 'user_id')) {
                    $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('boards', 'slug')) {
                    $table->string('slug')->unique()->after('name');
                }
                if (!Schema::hasColumn('boards', 'share_token')) {
                    $table->string('share_token')->unique()->nullable()->after('slug');
                }
                if (!Schema::hasColumn('boards', 'is_public')) {
                    $table->boolean('is_public')->default(false)->after('share_token');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boards', function (Blueprint $table) {
            //
        });
    }
};
