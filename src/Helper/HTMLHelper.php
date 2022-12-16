<?php

declare(strict_types=1);

namespace App\Helper;

class HTMLHelper
{
    public static function getHTMLTemplate(array $contentReplace): string
    {
        $html = file_get_contents(__DIR__.'/rent-receipt-template.html');

        return strtr($html, $contentReplace);
    }
}
