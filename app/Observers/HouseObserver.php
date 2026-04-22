<?php

namespace App\Observers;

class HouseObserver extends BaseObserver
{
    public function __construct()
    {
        parent::__construct('Houses');
    }
}
