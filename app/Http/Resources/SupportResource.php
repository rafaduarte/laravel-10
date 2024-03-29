<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'identify' => $this->id,
             'subject' => $this->subject,
            //'subject' => strtoupper($this->subject),
            'content' => $this->body,
            //'dt_created' => $this->created_at
            'dt_created' => Carbon::make($this->created_at)->format('Y-m-d')
        ];
    }
}
