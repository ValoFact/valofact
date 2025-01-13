<?php

use App\enums\OrderStatus;
use App\enums\QuantityUnit;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('quantity');
            $table->enum('quantity_unit', [QuantityUnit::KG->value, QuantityUnit::TON->value])->default(QuantityUnit::KG->value);
            $table->string('quality')->nullable();
            $table->string('location');
            $table->boolean('include_transportation');
            $table->decimal('start_price');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->enum('status', [OrderStatus::AVAILABLE->value, OrderStatus::SOLD->value, OrderStatus::EXPIRED->value])->default(OrderStatus::AVAILABLE->value);
            $table->timestamps();
            $table->foreignIdFor(User::class);
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
