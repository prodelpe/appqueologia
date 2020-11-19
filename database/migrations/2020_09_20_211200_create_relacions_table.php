<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelacionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('relacions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('excavacio_id')
                    ->constrained('excavacions');
//                    ->onDelete('cascade');

            $table->foreignId('ue_origen_id')
                    ->constrained('ues')
                   ->onDelete('cascade');

            $table->foreignId('tipus_relacio_id')
                    ->constrained('tipus_relacions');
//                    ->onDelete('cascade');

            $table->foreignId('ue_desti_id')
                    ->constrained('ues')
                    ->onDelete('cascade');

            $table->integer('inversa')
                    ->constrained('relacions')
                    ->default(0);
//                    ->onDelete('cascade');

            //$table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('relacions');
    }

}
