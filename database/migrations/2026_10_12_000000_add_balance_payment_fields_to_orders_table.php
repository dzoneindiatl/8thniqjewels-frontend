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
            if (!Schema::hasColumn('orders', 'balance_payment_link_id')) {
                $table->string('balance_payment_link_id')->nullable();
            }
            if (!Schema::hasColumn('orders', 'balance_payment_link_url')) {
                $table->text('balance_payment_link_url')->nullable();
            }
            if (!Schema::hasColumn('orders', 'balance_payment_payment_id')) {
                $table->string('balance_payment_payment_id')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            foreach ([
                'is_make_to_order',
                'balance_payment_link_id',
                'balance_payment_link_url',
                'balance_payment_payment_id',
            ] as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
