<?php namespace App\Http\Controllers;

use App\Logger;
use App\Custom\Tempo;
use App\Custom\WeightedAverageTempo;
use App\Http\Requests\LoggerRequest;


class LoggerController extends Controller {


    private $_date_limit = 28;
    private $_dates_submitted;


    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');

    }


    private function _get_recent_dates() {

        $this->_dates_submitted = \DB::table( 'loggers' )
            ->select( 'date' )
            ->orderBy('date', 'desc')
            ->take( $this->_date_limit )
            ->get();

    }

    /**
     * Compare recent dates to those already logged to the DB
     * @param  integer $index    Number of days previous to current date
     * @return integer           Valid unlogged dates
     */
    private function _populate_unlogged_dates( $index ) {

        $is_logged_date = strtotime( date( 'Y-m-d', time() - (24 * 60 * 60) * $index ) );
        foreach ( $this->_dates_submitted as $obj_date ) {
            if ( $is_logged_date == strtotime( $obj_date->date ) ) return;
        }

        // date is not logged, so return it to include in the dropdown
        return $is_logged_date;

    }


    /**
     * Gather valid unlogged date options for the dropdown
     * @return string    Select field options
     */
    private function _create_date_dropdown() {

        $options = '<option value="NULL"></option>';

        for ( $i=1 ; $i<=$this->_date_limit ; $i++ ) {

            // is valid unlogged date?
            $value = $this->_populate_unlogged_dates( $i );
            if ( ! is_null( $value ) ) {

                // if so, add it as an option to the bootstrap dropdown
                $option_value = date( 'Y-m-d', $value );
                $option_display = date( 'm.d.y (D)', $value );

                $options .= '<option value="' . $option_value . '">' . $option_display . '</option>';

            }

        }

        return $options;

    }


    /**
     * Show the journal logging form to the user
     *
     * @return Response
     */
    public function index() {

        $this->_get_recent_dates();
        $dates = $this->_create_date_dropdown( $this->_date_limit );

        return view('logger', compact( 'dates' ) );

    }


    /**
     * Store a journal entry
     *
     * @return Response
     */
    public function store( LoggerRequest $request ) {

        // save
        $logger = new Logger( $request->all() );
        \Auth::user()->logger()->save( $logger );

        // calculate tempo
        $tempo = new Tempo( $this->_date_limit );
        $average_tempo = new WeightedAverageTempo( $tempo->get() );
        $average = $average_tempo->calculate();

        // redirect
        return redirect( '' )->with([
            'flash_message' => 'Entry Logged: ' . $average,
        ]);

    }

}
