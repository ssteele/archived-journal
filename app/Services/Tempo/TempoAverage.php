<?php
namespace App\Services\Tempo;

class TempoAverage
{
    private $tempo;
    private $breakpoints;
    private $step;
    private $days = 0;
    private $total = 0;
    private $average = 0;

    /**
     * Construct
     * @param object $tempo    Tempo object
     */
    public function __construct(Tempo $tempo)
    {
        $this->tempo = $tempo->data;
        $this->defineBreakpoints();
    }

    /**
     * Set weighted average breakpoints
     */
    private function defineBreakpoints()
    {
        $this->breakpoints = [
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
    private function average()
    {
        $this->average += ($this->step['weight'] * $this->total / $this->days);
    }

    /**
     * Step through weight breakpoints and sum averages
     */
    private function weightedAverage()
    {
        foreach ($this->breakpoints as $this->step) {
            if ($this->step['end'] > count($this->tempo)) {
                break;
            }

            $this->days = $this->total = 0;

            for ($i=$this->step['start']; $i<=$this->step['end']; $i++) {
                // count as 0 if nonexistent
                $tempo = (isset($this->tempo[$i])) ? $this->tempo[$i] : 0;

                $this->total += $tempo;
                $this->days++;
            }

            $this->average();
        }
    }

    /**
     * Weighted average calculation driver
     * @return float    Recent tempo weighted average
     */
    public function calculate()
    {
        $this->weightedAverage();
        return round($this->average, 2);
    }
}
