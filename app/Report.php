<?php

namespace App;

use App\Http\Resources\ReportResource;
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
        return ReportResource::collection(
            Report::with('user')
                ->where($where)
                ->get()
        );
    }

}
