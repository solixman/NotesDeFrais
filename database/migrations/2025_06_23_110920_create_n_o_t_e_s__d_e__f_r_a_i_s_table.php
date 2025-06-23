<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesDeFraisTable extends Migration
{
    public function up(): void
    {
        Schema::create('notes_de_frais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->date('date_depense');
            $table->enum('categorie', ['repas', 'hôtel', 'transport']);
            $table->decimal('montant', 10, 2);
            $table->string('devise', 3);
            $table->text('description')->nullable();
            $table->string('fichier_justificatif')->nullable();
            $table->enum('statut', ['brouillon', 'soumise', 'validée', 'rejetée', 'remboursée']);
            $table->text('commentaire_validation')->nullable();
            $table->dateTime('date_validation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes_de_frais');
    }
}
