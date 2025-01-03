<?php

use App\enums\OrderStatus;
use App\enums\QuantityUnit;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('quantity');
            $table->string('quantity_unit')->default(QuantityUnit::KG->value);
            $table->string('quality')->nullable();
            $table->string('location');
            $table->boolean('include_transportation');
            $table->decimal('start_price');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->string('status')->default(OrderStatus::AVAILABLE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
