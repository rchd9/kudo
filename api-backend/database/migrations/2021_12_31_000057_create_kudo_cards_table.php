<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKudoCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kudo_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kudo_id');
            $table->string('subject', 255);
            $table->text('comment');
            $table->timestamps();

            $table->index('kudo_id');
            $table->foreign('kudo_id')->references('id')->on('kudos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kudo_cards');
        $table->dropForeign('kudo_cards_kudo_id_foreign');
        $table->dropIndex('kudo_cards_kudo_id_index');
        $table->dropColumn('user_id');
    }
}
