<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DateFilterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            "subscribed" => $this->subscribed,
            "registered" => $this->registered,
            "total_income" => $this->total_income,
            "trx" => $this->trx,
            "cr" => $this->cr,
            "day" => Carbon::create($this->day)->format('d-m-Y'),

        ];
    }
}
