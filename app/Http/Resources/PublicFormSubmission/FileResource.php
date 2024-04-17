<?php

namespace App\Http\Resources\PublicFormSubmission;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'id'            => $this->id,
            'file_name'     => $this->file_name,
            'mime_type'     => $this->mime_type,
            'size'          => $this->size,
            'file_url'       => $this->getUrl(),
        ];
    }
}
