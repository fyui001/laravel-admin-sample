<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use \Database\Libs\BlueprintTrait;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('release_flags', function (Blueprint $table) {
            $table->string('name')->primary();
            $table->boolean('is_enabled');
            $this->dateTimes($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('release_flags');
    }
};
