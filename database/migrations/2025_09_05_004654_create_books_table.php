<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('resume', 500);
            $table->text('summary')->nullable();
            $table->bigInteger('price');
            $table->integer('number_pages');
            $table->string('isbn', 13)->unique();
            $table->date('publication_date')->nullable();
            $table->foreignId('author_id')->constrained('authors');
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
