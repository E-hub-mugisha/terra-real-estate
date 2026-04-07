<?php

namespace App\Observers;

class LandObserver extends BaseObserver
{
    public function __construct()
    {
        parent::__construct('Lands');
    }
}
