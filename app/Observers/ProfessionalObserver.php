<?php

namespace App\Observers;

class ProfessionalObserver extends BaseObserver
{
    public function __construct()
    {
        parent::__construct('Professionals', 'name');
    }
}
