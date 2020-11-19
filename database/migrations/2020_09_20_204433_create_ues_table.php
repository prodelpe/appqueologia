<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ues', function (Blueprint $table) {
            $table->id();
            $table->string('codi');
            $table->foreignId('excavacio_id')
                    ->constraint('excavacions');
            $table->string('sector')
                    ->nullable();
            $table->string('definicio')
                    ->nullable();
            $table->text('descripcio')
                    ->nullable();
            $table->text('interpretacio')
                    ->nullable();
            $table->string('cronologia')
                    ->nullable();
            $table->string('criteris_datacio')
                    ->nullable();
            $table->text('observacions')
                    ->nullable();


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
        Schema::dropIfExists('ues');
    }

}
