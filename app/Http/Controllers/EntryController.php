<?php
namespace App\Http\Controllers;

use App\Entry;
use App\Custom\LogDates;
use App\Custom\LogDatesDropdown;
use App\Custom\Tempo;
use App\Custom\TempoAverage;
use App\Http\Requests\EntryRequest;
use App\Http\Requests\EntryUploadRequest;

class EntryController extends Controller
{
    private $_date_limit = 28;
    private $_average = 0;
    private $_csv_rows = [];
    private $_csv_counter = 0;

    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Render the journal logging form
     *
     * @return Response
     */
    public function index()
    {
        // get unlogged dates
        $log_dates = new LogDates($this->_date_limit);
        $log_dates_dropdown = new LogDatesDropdown($log_dates->get());
        $dates = $log_dates_dropdown->create();

        return view('entry', compact('dates'));
    }

    /**
     * Render the bulk CSV upload form
     *
     * @return Response
     */
    public function upload()
    {
        return view('entry-upload');
    }

    /**
     * Calculate recent activity
     */
    private function _calculate_tempo()
    {
        // calculate tempo
        $tempo = new Tempo($this->_date_limit);
        $average_tempo = new TempoAverage($tempo->get());
        $this->_average = $average_tempo->calculate();
    }

    /**
     * Redirect and flash recent activity
     *
     * @return Response
     */
    private function _redirect()
    {
        // redirect and flash calculated tempo
        return redirect('')->with([
            'flash_message' => $this->_average,
        ]);
    }

    /**
     * Save a journal entry
     *
     * @return Response
     */
    public function store(EntryRequest $request)
    {
        // save
        $entry = new Entry($request->all());
        \Auth::user()->entry()->save($entry);

        if (is_null($request->bulk)) {
            $this->_calculate_tempo();
            return $this->_redirect();
        }
    }

    /**
     * Collect CSV upload rows
     * ...maatwebsite/excel package is over-encapsulated
     * @param  array $row    CSV row
     */
    private function _collect_csv_row($row)
    {
        $this->_csv_rows[$this->_csv_counter]['date'] = $row['date'];
        $this->_csv_rows[$this->_csv_counter]['tempo'] = $row['tempo'];
        $this->_csv_rows[$this->_csv_counter]['entry'] = $row['entry'];

        $this->_csv_counter++;
    }

    /**
     * Use maatwebsite/excel package to extract CSV data
     * @param  object $csv_upload    File upload
     */
    private function _extract_csv_data($csv_upload)
    {
        $file = \Excel::load($csv_upload, function($reader) {
            $reader->each(function($row) {
                $this->_collect_csv_row($row);
            });
        });
    }

    /**
     * Save several journal entries
     *
     * @return Response
     */
    public function bulk_store(EntryUploadRequest $request)
    {
        $csv = $request->input('csv');

        $csv_upload = $request->file('csv')->move(
            base_path() . '/public/', $csv
        );

        $this->_extract_csv_data($csv_upload);

        foreach ($this->_csv_rows as $row) {
            // pass through entry request validation/save methods
            $entry_request = new EntryRequest;

            $entry_request->replace([
                'user'  => \Auth::user(),
                'date'  => \Carbon\Carbon::createFromFormat('m.d.y', $row['date'])->toDateTimeString(),
                'tempo' => $row['tempo'],
                'entry' => $row['entry'],
                'bulk'  => true,
            ]);

            $entry_request->setContainer(app());
            $entry_request->validate();

            $this->store($entry_request);
        }

        $this->_calculate_tempo();
        return $this->_redirect();
    }
}
