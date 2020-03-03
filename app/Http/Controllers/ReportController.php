<?php

namespace App\Http\Controllers;

use App\Report;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function __construct() {
        $this
            ->middleware('powerlevel:50')
            ->only('update');
    }

    public function webhook(Request $request) {
        $rawPostData = file_get_contents("php://input");
        Report::create([
            "website" => $request->get("website"),
            "vars"    => json_decode($rawPostData, true)
        ]);

        // TODO: Send warnings to Slack, mail, etc...?
    }

    public function index(Request $request) {
        $reports = Report::GetList(function(Builder $q) {
            $q->whereNull('resolved_at');
        });
        return Inertia::render('Reports/Index', [
            "meta"    => [
                "title" => "Unhandeled reports"
            ],
            "reports" => $reports
        ]);
    }

    public function show(Request $request, Report $report) {
        $reports = Report::GetList(function(Builder $q) use ($report) {
            $q->where('website', $report->website);
            $q->where('id', '!=', $report->id);
        });
        $report->load('user');
        return Inertia::render('Reports/Show', [
            "meta"    => [
                "title" => "Report detail of " . $report->website
            ],
            "reports" => $reports,
            "report"  => $report
        ]);
    }

    public function update(Request $request, Report $report) {
        $data = $request->validate([
            "resolved" => "required|boolean"
        ]);

        $data["resolved_at"] = $data["resolved"] ? Carbon::now() : null;
        $data["user_id"] = $data["resolved"] ? Auth::id() : null;
        unset($data["resolved"]);
        $report->update($data);

        return back()->with('message', $data["resolved_at"] ?
            'Error has been marked as resolved' :
            'Error has been marked as unresolved'
        );
    }

    public function destroy(Report $report) {
        $report->delete();
        return redirect()->route('reports.index')->with('message', 'Error has been deleted.');
    }

}
