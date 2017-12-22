<?php
namespace App\Http\Controllers;

use App\Custom\Annotation\Handler;
use App\Custom\LogDates;
use App\Custom\LogDatesDropdown;
use App\Custom\Tempo;
use App\Custom\TempoAverage;
use App\Entry;
use App\Http\Requests\EntryRequest;
use App\Http\Requests\EntryUploadRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    private $dateLimit = 28;
    private $average = 0;
    private $csvRows = [];
    private $csvCounter = 0;

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
        $logDates = new LogDates($this->dateLimit);
        $logDatesDropdown = new LogDatesDropdown($logDates->get());
        $dates = $logDatesDropdown->create();

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
    private function calculateTempo()
    {
        // calculate tempo
        $tempo = new Tempo($this->dateLimit);
        $averageTempo = new TempoAverage($tempo->get());

        return $averageTempo->calculate();
    }

    /**
     * Redirect and flash recent activity
     *
     * @return Response
     */
    private function redirect($average)
    {
        // redirect and flash calculated tempo
        return redirect('')->with([
            'flash_message' => $average,
        ]);
    }

    /**
     * Save a journal entry and it's annotations
     *
     * @return Response
     */
    public function store(EntryRequest $request, Handler $annotationHandler)
    {
        // get authenticated user
        $user = Auth::user();

        // save entry
        // $entry = new Entry($request->all());
        // $persistedEntry = $user->entry()->save($entry);

        // save annotations
        $annotationHandler->setUserId($user->getAttribute('id'));
        // $annotationHandler->setEntryId($persistedEntry->getAttribute('id'));
        // $annotationHandler->setEntryText($persistedEntry->getAttribute('entry'));

        $annotationHandler->setEntryId(5);
        $annotationHandler->setEntryText($request->input('entry'));

        $annotationHandler->extract();
        $annotationHandler->save();
        die;

        // flash tempo
        if (is_null($request->bulk)) {
            $average = $this->calculateTempo();
            return $this->redirect($average);
        }
    }

    /**
     * Collect CSV upload rows
     * ...maatwebsite/excel package is over-encapsulated
     * @param  array $row    CSV row
     */
    private function collectCsvRow($row)
    {
        $this->csvRows[$this->csvCounter]['date'] = $row['date'];
        $this->csvRows[$this->csvCounter]['tempo'] = $row['tempo'];
        $this->csvRows[$this->csvCounter]['entry'] = $row['entry'];

        $this->csvCounter++;
    }

    /**
     * Use maatwebsite/excel package to extract CSV data
     * @param  object $csvUpload    File upload
     */
    private function extractCsvData($csvUpload)
    {
        $file = \Excel::load($csvUpload, function ($reader) {
            $reader->each(function ($row) {
                $this->collectCsvRow($row);
            });
        });
    }

    /**
     * Save several journal entries
     *
     * @return Response
     */
    public function bulkStore(EntryUploadRequest $request)
    {
        $csv = $request->input('csv');
        $csvUpload = $request->file('csv')->move(base_path() . '/public/', $csv);
        $this->extractCsvData($csvUpload);

        foreach ($this->csvRows as $row) {
            // pass through entry request validation/save methods
            $entryRequest = new EntryRequest;

            $entryRequest->replace([
                'user'  => Auth::user(),
                'date'  => Carbon::createFromFormat('m.d.y', $row['date'])->toDateTimeString(),
                'tempo' => $row['tempo'],
                'entry' => $row['entry'],
                'bulk'  => true,
            ]);

            $entryRequest->setContainer(app());
            $entryRequest->validate();

            $this->store($entryRequest);
        }

        $this->calculateTempo();
        return $this->redirect();
    }
}
