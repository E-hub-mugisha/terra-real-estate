<?php

namespace App\Observers;

class AnnouncementObserver extends BaseObserver
{
    public function __construct()
    {
        parent::__construct('Announcements');
    }
}
