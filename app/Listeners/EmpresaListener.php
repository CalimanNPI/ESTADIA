<?php

namespace App\Listeners;

use App\Models\s_Empresa;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmpresaListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(s_Empresa $event)
    {
        session(['idEmpresa' =>  $event->idempresa]);
    }
}
