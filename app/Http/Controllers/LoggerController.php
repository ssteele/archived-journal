<?php namespace App\Http\Controllers;

use App\Logger;
use App\Http\Requests\LoggerRequest;


class LoggerController extends Controller {


    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');

    }


    /**
     * Show the journal logging form to the user
     *
     * @return Response
     */
    public function index() {

        return view('logger');

    }


    /**
     * Store a journal entry
     *
     * @return Response
     */
    public function store( LoggerRequest $request ) {

        $logger = new Logger( $request->all() );
        \Auth::user()->logger()->save( $logger );

        return redirect( '' )->with([
            'flash_message' => 'Entry Logged',
        ]);

    }

}
