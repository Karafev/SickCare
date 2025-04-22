<?php
namespace App\Models;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvoqueAlergieATable extends Migration
{
    public function up()
    {
        Schema::create('provoque_alergie_à', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_aliment')->constrained('aliment_recettes')->onDelete('cascade');
            $table->foreignId('id_maladie')->constrained('maladies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('provoque_alergie_à');
    }
}
