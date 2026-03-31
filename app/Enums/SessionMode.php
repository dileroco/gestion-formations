<?php

namespace App\Enums;

enum SessionMode: string
{
    case Presentiel = 'presentiel';
    case Online = 'online';
    case Hybride = 'hybride';
}
