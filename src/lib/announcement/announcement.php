<?php

declare(strict_types=1);

namespace Announcement;

class Announcement {
    public string $title;
    public string $date;
    public string $content;

    function __construct(string $title = '', string $date = '', string $content = '')
    {
        $this->title   = $title;
        $this->date    = $date;
        $this->content = $content;
    }

    // function convert_to_json():array{
        
    // }
}