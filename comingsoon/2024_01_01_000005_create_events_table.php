<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('event_name');
            $table->enum('event_type', ['wedding', 'engagement', 'reception', 'anniversary', 'other']);
            $table->string('client_name');
            $table->date('event_date');
            $table->string('venue');
            $table->string('city');
            $table->string('province');
            $table->string('budget_range')->nullable();
            $table->integer('guest_count')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['planned', 'ongoing', 'completed', 'cancelled'])->default('planned');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};