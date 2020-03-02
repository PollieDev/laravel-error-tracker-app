<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Report extends Model
{

    protected $guarded = ['id'];

    protected $casts = [
        'vars' => 'array',
    ];
    protected $dates = [
        'resolved_at'
    ];

    protected static function boot() {
        static::creating(function($item) {
            $item->uuid = (string)Str::orderedUuid();
        });

        parent::boot();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName() {
        return "uuid";
    }

    public static function GetList($where = []) {
        return Report::with('user')
            ->where($where)
            ->get()
            ->map(function(Report $report) {
                return [
                    "uuid" => $report->uuid,
                    "website" => $report->website,
                    "message" => $report->vars["message"],
                    "resolved_at" => $report->resolved_at,
                    "created_at" => $report->created_at,
                    "user" => $report->user ? [
                        "name" => $report->user->name
                    ] : null
                ];
            });
    }

}
