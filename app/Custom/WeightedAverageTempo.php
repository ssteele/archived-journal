<?php namespace App\Custom;


class WeightedAverageTempo {


    private $_tempo;
    private $_breakpoints;
    private $_step;
    private $_days = 0;
    private $_total = 0;
    private $_average = 0;


    /**
     * Construct
     * @param object $tempo    Tempo object
     */
    public function __construct( Tempo $tempo ) {

        $this->_tempo = $tempo->data;
        $this->_define_breakpoints();

    }


    /**
     * Set weighted average breakpoints
     */
    private function _define_breakpoints() {

        $this->_breakpoints = [
            ['weight' => 0.3, 'start' => 0, 'end' => 0],
            ['weight' => 0.25, 'start' => 1, 'end' => 2],
            ['weight' => 0.2, 'start' => 3, 'end' => 6],
            ['weight' => 0.15, 'start' => 7, 'end' => 13],
            ['weight' => 0.1, 'start' => 14, 'end' => 27],
        ];

    }


    /**
     * Update average using weight, tempo total, and day count
     */
    private function _average() {

        $this->_average += ( $this->_step['weight'] * $this->_total / $this->_days );

    }


    /**
     * Step through weight breakpoints and sum averages
     */
    private function _weighted_average() {

        foreach ( $this->_breakpoints as $this->_step ) {

            if ( $this->_step['end'] > count( $this->_tempo ) ) {
                break;
            }

            $this->_days = $this->_total = 0;

            for ( $i=$this->_step['start'] ; $i<=$this->_step['end'] ; $i++ ) {

                $this->_total += $this->_tempo[$i];
                $this->_days++;

            }

            $this->_average();

        }

    }


    /**
     * Weighted average calculation driver
     * @return float    Recent tempo weighted average
     */
    public function calculate() {

        $this->_weighted_average();
        return round( $this->_average, 2 );

    }

}
