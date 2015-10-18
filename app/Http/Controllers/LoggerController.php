<?php namespace App\Http\Controllers;

use App\Logger;
use App\Custom\LogDates;
use App\Custom\LogDatesDropdown;
use App\Custom\Tempo;
use App\Custom\TempoAverage;
use App\Http\Requests\LoggerRequest;
use App\Http\Requests\UploadRequest;


class LoggerController extends Controller {


    private $_date_limit = 28;


    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');

    }


    /**
     * Render the journal logging form
     *
     * @return Response
     */
    public function index() {

        // get unlogged dates
        $log_dates = new LogDates( $this->_date_limit );
        $log_dates_dropdown = new LogDatesDropdown( $log_dates->get() );
        $dates = $log_dates_dropdown->create();

        return view( 'logger', compact( 'dates' ) );

    }


    /**
     * Render the bulk CSV upload form
     *
     * @return Response
     */
    public function upload() {

        return view( 'upload' );

    }


    /**
     * Save a journal entry
     *
     * @return Response
     */
    public function store( LoggerRequest $request ) {

        // save
        $logger = new Logger( $request->all() );
        \Auth::user()->logger()->save( $logger );

        // calculate tempo
        $tempo = new Tempo( $this->_date_limit );
        $average_tempo = new TempoAverage( $tempo->get() );
        $average = $average_tempo->calculate();

        // redirect
        return redirect( '' )->with([
            'flash_message' => $average,
        ]);

    }

    /**
     * Save several journal entries
     *
     * @return Response
     */
    public function bulk_store( UploadRequest $request ) {

        $csv = $request->input('csv');

    }

}
