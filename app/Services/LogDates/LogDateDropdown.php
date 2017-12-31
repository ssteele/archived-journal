<?php
namespace App\Services\LogDates;

use Carbon\Carbon;

class LogDateDropdown
{
    /** @var integer */
    private $dateLimit;

    /** @var array */
    private $datesSubmitted;

    /**
     * Construct
     * @param integer $dateLimit    Number of days back to fetch
     */
    public function __construct(LogDate $logDate)
    {
        $this->dateLimit = $logDate->dateLimit;
        $this->datesSubmitted = array_reverse($logDate->datesSubmitted);
    }

    /**
     * Compare recent dates to those already logged to the DB
     * @param  integer $index    Number of days previous to current date
     * @return integer           Valid unlogged dates
     */
    private function populateUnloggedDates($index)
    {
        $daysAgo = $this->dateLimit - ($index + 1);
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
