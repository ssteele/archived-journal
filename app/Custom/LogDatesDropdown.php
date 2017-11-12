<?php
namespace App\Custom;

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
        $this->datesSubmitted = $logDates->datesSubmitted;
    }

    /**
     * Compare recent dates to those already logged to the DB
     * @param  integer $index    Number of days previous to current date
     * @return integer           Valid unlogged dates
     */
    private function populateUnloggedDates($index)
    {
        $isLoggedDate = strtotime(date('Y-m-d', time() - (24 * 60 * 60) * $index));
        foreach ($this->datesSubmitted as $objDate) {
            if ($isLoggedDate == strtotime($objDate->date)) {
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
            $value = $this->populateUnloggedDates($i);
            if (! is_null($value)) {
                // if so, add it as an option to the bootstrap dropdown
                $optionValue = date('Y-m-d', $value);
                $optionDisplay = date('m.d.y (D)', $value);

                $options .= '<option value="' . $optionValue . '">' . $optionDisplay . '</option>';
            }
        }

        return $options;
    }
}
