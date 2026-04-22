<?php

namespace App\Observers;

class ConsultantObserver extends BaseObserver
{
    public function __construct()
    {
        parent::__construct('Consultants', 'name');
    }
}
