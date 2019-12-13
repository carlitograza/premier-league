<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('chance_of_playing_next_round')->nullable();
            $table->string('chance_of_playing_this_round')->nullable();
            $table->string('code');
            $table->integer('cost_change_event')->nullable();
            $table->integer('cost_change_event_fall')->nullable();
            $table->integer('cost_change_start')->nullable();
            $table->integer('cost_change_start_fall')->nullable();
            $table->integer('dreamteam_count')->nullable();
            $table->integer('element_type')->nullable();
            $table->float('ep_next')->nullable();
            $table->float('ep_this')->nullable();
            $table->integer('event_points')->nullable();
            $table->string('first_name');
            $table->string('form')->nullable();
            $table->string('in_dreamteam')->nullable();
            $table->longText('news')->nullable();
            $table->string('news_added')->nullable();
            $table->integer('now_cost')->nullable();
            $table->string('photo')->nullable();
            $table->float('points_per_game')->nullable();
            $table->string('second_name')->nullable();
            $table->float('selected_by_percent')->nullable();
            $table->string('special')->nullable();
            $table->string('squad_number')->nullable();
            $table->string('status')->nullable();
            $table->string('team')->nullable();
            $table->integer('total_points')->nullable();
            $table->string('transfers_in')->nullable();
            $table->string('transfers_in_event')->nullable();
            $table->string('transfers_out')->nullable();
            $table->string('transfers_out_event')->nullable();
            $table->string('value_form')->nullable();
            $table->string('value_season')->nullable();
            $table->string('web_name')->nullable();
            $table->smallInteger('minutes')->nullable();
            $table->integer('goals_scored')->nullable();
            $table->integer('assists')->nullable();
            $table->integer('clean_sheets')->nullable();
            $table->integer('goals_conceded')->nullable();
            $table->integer('own_goals')->nullable();
            $table->integer('penalties_saved')->nullable();
            $table->integer('penalties_missed')->nullable();
            $table->integer('yellow_cards')->nullable();
            $table->integer('red_cards')->nullable();
            $table->integer('saves')->nullable();
            $table->integer('bonus')->nullable();
            $table->integer('bps')->nullable();
            $table->float('influence')->nullable();
            $table->float('creativity')->nullable();
            $table->float('threat')->nullable();
            $table->float('ict_index')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
