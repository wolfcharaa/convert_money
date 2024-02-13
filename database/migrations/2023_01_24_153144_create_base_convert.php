<?php

declare(strict_types=1);

use App\Models\ConverterType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('converter_types', static function (Blueprint $table) {
            $table->id();
            $table->string('short_name');
            $table->string('name');
            $table->string('url');
            $table->string('api_key')->nullable();
        });

        DB::statement(<<<SQL
                INSERT INTO converter_types (id, short_name, name,  url) VALUES (:id, :shortName, :name, :url); 
            SQL,
            [
                'id' => ConverterType::OER,
                'shortName' => 'OER',
                'name' => 'openexchangerates',
                'url' => 'https://openexchangerates.org/api'
            ]
        );

        Schema::create('forex_cost_actuals', static function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('converter_types')
                ->constrained();
            $table->string('currency');
            $table->float('forex');
        });

        Schema::create('forex_cost_history', static function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('converter_types')
                ->constrained();
            $table->string('currency');
            $table->float('forex');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forex_cost_history');
        Schema::dropIfExists('forex_cost_actuals');
        Schema::dropIfExists('converter_types');
    }
};
