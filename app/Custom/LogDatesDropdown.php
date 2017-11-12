<?php
namespace App\Custom;

use Carbon\Carbon;

class LogDatesDropdown
{
    private $datesSubmitted;
    private $dateLimit;

    /**
     * Construct
     * @param integer $dateLimit    Number of days back to fetch
     */
    public function __construct(LogDates $logDates)
    {
        $this->dateLimit = $logDates->dateLimit;
        $this->datesSubmitted = array_reverse($logDates->datesSubmitted);
    }

    /**
     * Compare recent dates to those already logged to the DB
     * @param  integer $index    Number of days previous to current date
     * @return integer           Valid unlogged dates
     */
    private function populateUnloggedDates($index)
    {
        $daysAgo = $this->dateLimit - $index;
        $isLoggedDate = new Carbon($daysAgo . ' days ago');

        foreach ($this->datesSubmitted as $objDate) {
            $candidateDate = new Carbon($objDate->date);
            if ($isLoggedDate->isSameDay($candidateDate)) {
                return;
            }
        }

        // date is not logged, so return it to include in the dropdown
        return $isLoggedDate;
    }

    /**
     * Gather valid unlogged date options and create the dropdown
     * @return string    Select field options
     */
    public function create()
    {
        $options = '<option value="NULL"></option>';

        for ($i=0; $i<$this->dateLimit; $i++) {
            // is valid unlogged date?
            $date = $this->populateUnloggedDates($i);
            if (! is_null($date)) {
                // if so, add it as an option to the bootstrap dropdown
                $optionValue = $date->format('Y-m-d');
                $optionDisplay = $date->format('m.d.y (D)');

                $options .= '<option value="' . $optionValue . '">' . $optionDisplay . '</option>';
            }
        }

        return $options;
    }
}
