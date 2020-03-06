<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "uuid" => $this->uuid,
            "website" => $this->website,
            "message" => $this->vars["message"],
            "resolved_at" => $this->resolved_at,
            "created_at" => $this->created_at,
            "user" => $this->user ? [
                "name" => $this->user->name
            ] : null,
            "occurrences" => $this->occurrences
        ];
    }
}
