<?php

use App\Models\User;
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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('email')->unique();
            $table->string('telephone');
            $table->string('address');
            $table->string('secondary_establishment_number');
            $table->string('category_code');
            $table->string('tva_code');
            $table->string('tax_number');
            $table->string('first_activity')->nullable();
            $table->date('active_since')->nullable();
            $table->foreignIdFor(User::class);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
