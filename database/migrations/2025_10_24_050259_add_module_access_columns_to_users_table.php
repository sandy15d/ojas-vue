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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_sales_access')->default(false)->after('email_verified_at');
            $table->boolean('has_hr_access')->default(false)->after('has_sales_access');
            $table->boolean('has_cogs_access')->default(false)->after('has_hr_access');
            $table->boolean('has_budget_access')->default(false)->after('has_cogs_access');
            $table->string('default_module')->nullable()->after('has_budget_access');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'has_sales_access',
                'has_hr_access',
                'has_cogs_access',
                'has_budget_access',
                'default_module',
            ]);
        });
    }
};
