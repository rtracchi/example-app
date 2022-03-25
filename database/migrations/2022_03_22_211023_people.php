<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create tables
        Schema::create('planets', function($table){
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('rotation_period')->nullable();
            $table->integer('orbital_period')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('people', function($table){
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('planet_id')->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        // retrieve people
        $body = ['format' => 'json'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://swapi.dev/api/people/?format=json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        $output = curl_exec($ch);
        $data = json_decode($output, true);
        curl_close($ch);

        // populate created tables
        $planets_ids = [];

        foreach ($data['results'] as $value) {
            $planet_id = basename($value['homeworld']);
            if (!in_array($planet_id, $planets_ids)) {
                array_push($planets_ids, $planet_id);
            }
            DB::table('people')->insert(
                array(
                    'name' => $value['name'],
                    'planet_id' => $planet_id
                )
            );
        }

        foreach ($planets_ids as $value) {

            // retrieve planets
            $body = ['format' => 'json'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://swapi.dev/api/planets/".$value."/?format=json");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            $output = curl_exec($ch);
            $data = json_decode($output, true);
            curl_close($ch);

            if ($data['rotation_period'] == 'unknown') {
                $rotation_period = null;
            } else {
                $rotation_period = $data['rotation_period'];
            }

            if ($data['orbital_period'] == 'unknown') {
                $orbital_period = null;
            } else {
                $orbital_period = $data['orbital_period'];
            }

            DB::table('planets')->insert(
                array(
                    'id' => $value,
                    'name' => $data['name'],
                    'rotation_period' => $rotation_period,
                    'orbital_period' => $orbital_period,
                )
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
        Schema::dropIfExists('planets');
    }
};
