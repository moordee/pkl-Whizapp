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
        if (!Schema::hasTable('wishlist_items')) {
            Schema::create('wishlist_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('board_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->decimal('price', 10, 2)->nullable();
                $table->string('image_url')->nullable();
                $table->text('item_url');
                $table->string('source')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('wishlist_items', function (Blueprint $table) {
                if (!Schema::hasColumn('wishlist_items', 'board_id')) {
                    $table->foreignId('board_id')->after('id')->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('wishlist_items', 'title')) {
                    $table->string('title')->after('board_id');
                }
                if (!Schema::hasColumn('wishlist_items', 'price')) {
                    $table->decimal('price', 10, 2)->nullable()->after('title');
                }
                if (!Schema::hasColumn('wishlist_items', 'image_url')) {
                    $table->string('image_url')->nullable()->after('price');
                }
                if (!Schema::hasColumn('wishlist_items', 'item_url')) {
                    $table->text('item_url')->after('image_url');
                }
                if (!Schema::hasColumn('wishlist_items', 'source')) {
                    $table->string('source')->nullable()->after('item_url');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
