<?php

use App\enums\BidStatus;
use App\Models\Order;
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
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount');
            $table->enum('status', [BidStatus::PENDING->value, BidStatus::ACCEPTED->value, BidStatus::OUTBID->value, BidStatus::REJECTED->value])->default(BidStatus::PENDING->value);
            $table->timestamp('bid_time');
            $table->timestamps();
            $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
