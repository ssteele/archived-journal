<?php
namespace App\Custom;

class LogDates
{
    public $date_limit;
    public $dates_submitted;

    /**
     * Construct
     * @param integer $date_limit    Number of days back to fetch
     */
    public function __construct($date_limit)
    {
        $this->date_limit = $date_limit;
    }

    private function _query_db()
    {
        $this->dates_submitted = \DB::table('entries')
            ->select('date')
            ->where('user_id', \Auth::user()->id)
            ->orderBy('date', 'desc')
            ->take($this->date_limit)
            ->get();
    }

    /**
     * Public access method used by the site
     * @return object    LogDates
     */
    public function get()
    {
        $this->_query_db();
        return $this;
    }

    /**
     * Public access method used for unit tests
     * @return object    LogDates
     */
    public function mock($data)
    {
        $this->dates_submitted = $data;
        return $this;
    }
}
