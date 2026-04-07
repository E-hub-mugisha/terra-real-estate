<?php

namespace App\Observers;

class AdvertisementObserver extends BaseObserver
{
    public function __construct()
    {
        parent::__construct('Advertisements');
    }
}
