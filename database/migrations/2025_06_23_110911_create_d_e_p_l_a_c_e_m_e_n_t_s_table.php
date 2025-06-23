<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeplacementsTable extends Migration
{
    public function up(): void
    {
        Schema::create('deplacements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->string('objet');
            $table->string('lieu');
            $table->date('date_depart');
            $table->date('date_retour');
            $table->string('moyen_transport');
            $table->decimal('cout_estime', 10, 2);
            $table->enum('statut', ['en_attente', 'accepté', 'refusé', 'réalisé']);
            $table->text('commentaire_validation')->nullable();
            $table->dateTime('date_validation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deplacements');
    }
}
