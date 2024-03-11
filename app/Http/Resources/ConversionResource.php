<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversionResource extends JsonResource
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
//            "day" => Carbon::create($this->day)->format('d-m-Y'),
            "day" => $this->day,
            "income" => $this->income,
            "pt" => $this->pt,
            "s1" => $this->s1,
            "s2" => $this->s2,
            "s3" => $this->s3,
            "s4" => $this->s4,
            "s5" => $this->s5,
        ];
    }
}
