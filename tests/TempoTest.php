<?php

use App\Custom\Tempo;
use App\Custom\TempoAverage;


class TempoTest extends TestCase {


    public function test_phase_1_weighted_calculation() {

        $data = [
            (object)(['tempo' => '2']),
        ];

        $tempo = new Tempo( 28 );
        $tempo_average = new TempoAverage( $tempo->mock( $data ) );

        $this->assertEquals( 0.6, $tempo_average->calculate() );

    }


    public function test_phase_1_2_weighted_calculation() {

        $data = [
            (object)(['tempo' => '2']),
            (object)(['tempo' => '1']),
            (object)(['tempo' => '5']),
        ];

        $tempo = new Tempo( 28 );
        $tempo_average = new TempoAverage( $tempo->mock( $data ) );

        $this->assertEquals( 1.35, $tempo_average->calculate() );

    }


    public function test_phase_1_3_weighted_calculation() {

        $data = [
            (object)(['tempo' => '2']),
            (object)(['tempo' => '1']),
            (object)(['tempo' => '5']),
            (object)(['tempo' => '19']),
            (object)(['tempo' => '8']),
            (object)(['tempo' => '12']),
            (object)(['tempo' => '1']),
        ];

        $tempo = new Tempo( 28 );
        $tempo_average = new TempoAverage( $tempo->mock( $data ) );

        $this->assertEquals( 3.35, $tempo_average->calculate() );

    }


    public function test_phase_1_4_weighted_calculation() {

        $data = [
            (object)(['tempo' => '2']),
            (object)(['tempo' => '1']),
            (object)(['tempo' => '5']),
            (object)(['tempo' => '19']),
            (object)(['tempo' => '8']),
            (object)(['tempo' => '12']),
            (object)(['tempo' => '1']),
            (object)(['tempo' => '6']),
            (object)(['tempo' => '1']),
            (object)(['tempo' => '6']),
            (object)(['tempo' => '4']),
            (object)(['tempo' => '3']),
            (object)(['tempo' => '6']),
            (object)(['tempo' => '1']),
        ];

        $tempo = new Tempo( 28 );
        $tempo_average = new TempoAverage( $tempo->mock( $data ) );

        $this->assertEquals( 3.93, $tempo_average->calculate() );

    }


    public function test_1_5_weighted_calculation() {

        $data = [
            (object)(['tempo' => '2']),
            (object)(['tempo' => '1']),
            (object)(['tempo' => '5']),
            (object)(['tempo' => '19']),
            (object)(['tempo' => '8']),
            (object)(['tempo' => '12']),
            (object)(['tempo' => '1']),
            (object)(['tempo' => '6']),
            (object)(['tempo' => '1']),
            (object)(['tempo' => '6']),
            (object)(['tempo' => '4']),
            (object)(['tempo' => '3']),
            (object)(['tempo' => '6']),
            (object)(['tempo' => '1']),
            (object)(['tempo' => '1']),
            (object)(['tempo' => '11']),
            (object)(['tempo' => '12']),
            (object)(['tempo' => '4']),
            (object)(['tempo' => '2']),
            (object)(['tempo' => '15']),
            (object)(['tempo' => '3']),
            (object)(['tempo' => '11']),
            (object)(['tempo' => '11']),
            (object)(['tempo' => '1']),
            (object)(['tempo' => '7']),
            (object)(['tempo' => '3']),
            (object)(['tempo' => '12']),
            (object)(['tempo' => '8']),
        ];

        $tempo = new Tempo( 28 );
        $tempo_average = new TempoAverage( $tempo->mock( $data ) );

        $this->assertEquals( 4.65, $tempo_average->calculate() );

    }

}
