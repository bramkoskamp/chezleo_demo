<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Seed the roles table.
     */
    public function seed(): void
    {
        DB::table('roles')->insert([
            ['role_name' => 'admin', 'id' => 3],
            ['role_name' => 'colleague', 'id' => 2],
            ['role_name' => 'guest', 'id' => 1],
        ]);
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->timestamps();
        });

        // Seed the roles table
        $this->seed();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
