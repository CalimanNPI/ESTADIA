<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaResource extends JsonResource
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
            'idempresa'=>$this->idempresa,
            'nombre' => $this->nombre,
            'razonsocial' => $this->razonsocial,
            'claveciec' => $this->claveciec,
            'rfc' => $this->rfc,
            'clavefiel' => $this->clavefiel,            
        ];
    }
}
