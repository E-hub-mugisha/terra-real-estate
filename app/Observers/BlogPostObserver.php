<?php

namespace App\Observers;

class BlogPostObserver extends BaseObserver
{
    public function __construct()
    {
        parent::__construct('Blog');
    }
}
