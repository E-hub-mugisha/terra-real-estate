<?php

namespace App\Observers;

class TenderObserver extends BaseObserver
{
    public function __construct()
    {
        parent::__construct('Tenders');
    }
}
