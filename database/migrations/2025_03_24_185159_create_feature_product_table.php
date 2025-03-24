<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feature_product', function (Blueprint $table) {
            $table->id(); // Clé primaire optionnelle
            $table->foreignId('feature_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('value'); // La valeur de la caractéristique (ex: "40cm", "rouge")
            $table->timestamps(); // Pour created_at et updated_at

            // Clé unique pour éviter les doublons de combinaisons feature/product
            $table->unique(['feature_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feature_product');
    }
};