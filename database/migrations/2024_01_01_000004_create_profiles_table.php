<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->string('title')->nullable()->comment('Professional title');
            $table->text('summary')->nullable()->comment('Professional summary');
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->string('website')->nullable();
            $table->json('skills')->nullable()->comment('Array of skills');
            $table->json('work_experiences')->nullable()->comment('Array of work experience objects');
            $table->json('educations')->nullable()->comment('Array of education objects');
            $table->json('certifications')->nullable()->comment('Array of certification objects');
            $table->json('languages')->nullable()->comment('Array of language objects');
            $table->json('references')->nullable()->comment('Array of reference objects');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};