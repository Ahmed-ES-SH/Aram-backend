<?php

namespace App\Modules\Organization\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SelectedOrganizationDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'logo'        => $this->logo,
            'description' => $this->description,
            'title'       => $this->title,
            'email'       => $this->email,
            'categories'  => $this->categories->pluck('id')->values(),
        ];
    }
}
