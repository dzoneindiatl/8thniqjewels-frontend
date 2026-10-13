<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'is_make_to_order')) {
                $table->boolean('is_make_to_order')->default(false);
            }

            if (!Schema::hasColumn('orders', 'pending_amount')) {
                $table->decimal('pending_amount', 12, 2)->default(0);
            }

            if (!Schema::hasColumn('orders', 'is_half_payment')) {
                $table->boolean('is_half_payment')->default(false);
            }
        });
    }

    public function down(): void
    {
        // These fields may have been provisioned before this migration is recorded.
    }
};
