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
        Schema::table('wishlist_items', function (Blueprint $table) {
            if (!Schema::hasColumn('wishlist_items', 'item_type')) {
                $table->string('item_type')->nullable()->after('title');
            }
            if (!Schema::hasColumn('wishlist_items', 'notes')) {
                $table->text('notes')->nullable()->after('source');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wishlist_items', function (Blueprint $table) {
            //
        });
    }
};
