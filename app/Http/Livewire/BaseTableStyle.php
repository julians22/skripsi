<?php

namespace App\Http\Livewire;

trait BaseTableStyle{

    /**
     * settableclass
     *
     */
    public function setTableClass(){
        return 'table table-striped table-bordered table-hover table-sm';
    }
}
