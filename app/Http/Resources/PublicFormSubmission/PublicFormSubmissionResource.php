<?php

namespace App\Http\Resources\PublicFormSubmission;

use App\Traits\UserTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicFormSubmissionResource extends JsonResource {
    use UserTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        // return [
        //     'id'                 => $this->id,
        //     'client_id'          => $this->client_id,
        //     'client_phone'       => $this->client_phone,
        //     'ref_name'           => $this->ref_name,
        //     'ref_email'          => $this->ref_email,
        //     'ref_mobile_number'  => $this->ref_mobile_number,
        //     'ref_code'           => $this->ref_code,
        //     'ref_status'         => $this->ref_status,
        //     'reward_point'       => $this->reward_point,
        //     'additional_message' => $this->additional_message,
        //     'address'            => $this->address,
        //     'updated_by'         => $this->updated_by,
        //     'created_at'         => $this->created_at,
        //     'updated_at'         => $this->updated_at,
        // ];

        return parent::toArray($request);
    }
}
