<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReportResource;
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
        $report = Report::create([
            "website" => $request->get("website"),
            "vars"    => json_decode($rawPostData, true)
        ]);

        $report->getRelated()->each->update([
            "resolved_at" => null,
            "user_id" => null
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

        if ($sort = $request->get('sort')) {
            if ($sort === "occurrences")
                $reports = collect($reports)->sortByDesc('occurrences')->values();
        }

        return Inertia::render('Reports/Index', [
            "meta"    => [
                "title" => $title
            ],
            "reports" => $reports,
            "filters" => [
                "all" => $request->get('all') === "true",
                "website" => $request->get('website'),
                "sort" => $request->get('sort', 'date')
            ]
        ]);
    }

    public function show(Request $request, Report $report) {
        $report->load('user');
        $occurrences = $report->getRelated(fn($q) => $q->with('user'));
        $reports_count = $report->getUnrelated()->count();

        return Inertia::render('Reports/Show', [
            "meta"    => [
                "title" => "Report detail of " . $report->website
            ],
            "reports_count" => $reports_count,
            "report"  => $report,
            "occurrences" => ReportResource::collection($occurrences)
        ]);
    }

    public function update(Request $request, Report $report) {
        $data = $request->validate([
            "resolved" => "required|boolean"
        ]);

        $report->getRelated()->each->update([
            "resolved_at" => $data["resolved"] ? Carbon::now() : null,
            "user_id" => $data["resolved"] ? Auth::id() : null
        ]);

        return back()->with('message', $data["resolved"] ?
            'Error has been marked as resolved' :
            'Error has been marked as unresolved'
        );
    }

    public function destroy(Report $report) {
        $report->getRelated()->each->delete();
        return redirect()->route('reports.index')->with('message', 'Error has been deleted.');
    }

}
