<?php
namespace App\Services\Tempo;

class Tempo
{
    public $data;
    public $dateLimit;
    private $rawData;

    /**
     * Construct
     * @param integer $dateLimit    Number of days back to fetch
     */
    public function __construct($dateLimit)
    {
        $this->dateLimit = $dateLimit;
    }

    /**
     * Fetch data from the DB
     */
    private function queryDb()
    {
        $this->rawData = \DB::table('entries')
            ->select('tempo')
            ->where('user_id', \Auth::user()->id)
            ->orderBy('date', 'desc')
            ->take($this->dateLimit)
            ->get();
    }

    /**
     * Make the data easier to consume
     */
    private function unpack()
    {
        $this->data = [];

        foreach ($this->rawData as $data) {
            $this->data[] = $data->tempo;
        }
    }

    /**
     * Public access method used by the site
     * @return object    Tempo
     */
    public function get()
    {
        $this->queryDb();
        $this->unpack();

        return $this;
    }

    /**
     * Public access method used for unit tests
     * @return object    Tempo
     */
    public function mock($data)
    {
        $this->rawData = $data;
        $this->unpack();

        return $this;
    }
}
