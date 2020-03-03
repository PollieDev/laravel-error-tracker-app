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
        $title = "";
        $reports = Report::GetList(function(Builder $q) use ($request, &$title) {
            if ($request->get('all') === "true") {
                $title = "All";
            } else {
                $title = "Unhandeled";
                $q->whereNull('resolved_at');
            }

            $title .= " reports";

            if ($website = $request->get('website')) {
                $title .= " from {$website}";
                $q->where('website', "LIKE", "%$website%");
            }
        });
        return Inertia::render('Reports/Index', [
            "meta"    => [
                "title" => $title
            ],
            "reports" => $reports,
            "filters" => [
                "all" => $request->get('all') === "true",
                "website" => $request->get('website')
            ]
        ]);
    }

    public function show(Request $request, Report $report) {
        $report->load('user');
        $reports_count = Report::query()
            ->where('website', $report->website)
            ->where('id', '!=', $report->id)
            ->count();

        return Inertia::render('Reports/Show', [
            "meta"    => [
                "title" => "Report detail of " . $report->website
            ],
            "reports_count" => $reports_count,
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
