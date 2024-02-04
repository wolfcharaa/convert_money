<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('converter_type', static function (Blueprint $table) {
            $table->id();
            $table->string('short_name');
            $table->string('name');
            $table->string('url');
            $table->string('api_key')->nullable();
        });

        DB::statement(/** @lang PostgreSQL */ <<<SQL
            INSERT INTO converter_type VALUES ('one', 'http', 'api'); 
        SQL);

        Schema::create('forex_costs_actual', static function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('forex_type')
                ->constrained();
            $table->string('currency');
            $table->float('forex');
        });

        Schema::create('forex_costs_history', static function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('forex_type')
                ->constrained();
            $table->string('currency');
            $table->float('forex');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forex_costs');
    }
};
