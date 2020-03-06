<?php

namespace App;

use App\Http\Resources\ReportResource;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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

    public function scopeOccurrences(Builder $q) {
        $q
            ->selectRaw('*, JSON_EXTRACT(vars, "$.message") as message, JSON_EXTRACT(vars, "$.frames[0].file") as file, COUNT(*) as occurrences')
            ->groupBy('website', 'message', 'file');
    }

    public static function GetList($where = []): AnonymousResourceCollection {
        return ReportResource::collection(
            Report::with('user')
                ->occurrences()
                ->where($where)
                ->with('user')
                ->orderBy('created_at', 'DESC')
                ->get()
        );
    }

    public function getRelated(?Closure $closure = null): Collection {
        $query = self::query()
            ->where('website', $this->website)
            ->where('vars->message', $this->vars['message'])
            ->orderBy('created_at', 'DESC')
            ->whereJsonContains('vars', [
                'frames' => [
                    0 => [
                        'file' => $this->vars['frames'][0]['file']
                    ]
                ]
            ]);

        if ($closure)
            $closure($query);

        return $query->get();
    }

    public function getUnrelated(?Closure $closure = null): Collection {
        $query = self::query()
            ->where('website', $this->website)
            ->orderBy('created_at', 'DESC')
            ->whereNotExists(function($q) {
                $q
                    ->where('vars->message', $this->vars['message'])
                    ->whereJsonContains('vars', [
                        'frames' => [
                            0 => [
                                'file' => $this->vars['frames'][0]['file']
                            ]
                        ]
                    ]);
            })
            ->occurrences();

        if ($closure)
            $closure($query);

        return $query->get();
    }

}
