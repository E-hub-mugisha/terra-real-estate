<?php

namespace App\Observers;

class AgentObserver extends BaseObserver
{
    public function __construct()
    {
        parent::__construct('Agents', 'name');
    }
}
