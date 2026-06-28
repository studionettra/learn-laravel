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
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 100);
            $table->string('phone', 20);
            $table->text('address');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('type_of_service', function (Blueprint $table) {
            $table->id();
            $table->string('service_name', 50);
            $table->integer('price');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('trans_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_customer')->constrained('customer')->onDelete('cascade');
            $table->string('order_code', 50);
            $table->date('order_date');
            $table->date('order_end_date')->nullable();
            $table->tinyInteger('order_status')->default(0); // 0 = baru, 1 = sudah di ambil
            $table->integer('order_pay')->nullable();
            $table->integer('order_change')->nullable();
            $table->integer('total')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('trans_order_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_order')->constrained('trans_order')->onDelete('cascade');
            $table->foreignId('id_service')->constrained('type_of_service')->onDelete('cascade');
            $table->integer('qty');
            $table->decimal('subtotal', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('trans_laundry_pickup', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_order')->constrained('trans_order')->onDelete('cascade');
            $table->foreignId('id_customer')->constrained('customer')->onDelete('cascade');
            $table->date('pickup_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_laundry_pickup');
        Schema::dropIfExists('trans_order_detail');
        Schema::dropIfExists('trans_order');
        Schema::dropIfExists('type_of_service');
        Schema::dropIfExists('customer');
    }
};
