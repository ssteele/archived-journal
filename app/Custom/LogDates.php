<?php
namespace App\Custom;

class LogDates
{
    public $dateLimit;
    public $datesSubmitted;

    /**
     * Construct
     * @param integer $dateLimit    Number of days back to fetch
     */
    public function __construct($dateLimit)
    {
        $this->dateLimit = $dateLimit;
    }

    private function queryDb()
    {
        $this->datesSubmitted = \DB::table('entries')
            ->select('date')
            ->where('user_id', \Auth::user()->id)
            ->orderBy('date', 'desc')
            ->take($this->dateLimit)
            ->get();
    }

    /**
     * Public access method used by the site
     * @return object    LogDates
     */
    public function get()
    {
        $this->queryDb();
        return $this;
    }

    /**
     * Public access method used for unit tests
     * @return object    LogDates
     */
    public function mock($data)
    {
        $this->datesSubmitted = $data;
        return $this;
    }
}
