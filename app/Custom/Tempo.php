<?php
namespace App\Custom;

class Tempo
{
    public $data;
    public $date_limit;
    private $_raw_data;

    /**
     * Construct
     * @param integer $date_limit    Number of days back to fetch
     */
    public function __construct($date_limit)
    {
        $this->date_limit = $date_limit;
    }

    /**
     * Fetch data from the DB
     */
    private function _query_db()
    {
        $this->_raw_data = \DB::table('entries')
            ->select('tempo')
            ->where('user_id', \Auth::user()->id)
            ->orderBy('date', 'desc')
            ->take($this->date_limit)
            ->get();
    }

    /**
     * Make the data easier to consume
     */
    private function _unpack()
    {
        $this->data = [];

        foreach ($this->_raw_data as $data) {
            $this->data[] = $data->tempo;
        }
    }

    /**
     * Public access method used by the site
     * @return object    Tempo
     */
    public function get()
    {
        $this->_query_db();
        $this->_unpack();

        return $this;
    }

    /**
     * Public access method used for unit tests
     * @return object    Tempo
     */
    public function mock($data)
    {
        $this->_raw_data = $data;
        $this->_unpack();

        return $this;
    }
}
