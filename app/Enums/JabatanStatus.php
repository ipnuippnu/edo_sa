<?php

namespace App\Enums;

enum JabatanStatus : string
{
    case PENDING = 'pending';
    case AKTIF = 'active';
    case NONAKTIF = 'inactive';
    case SELESAI = 'finished';
}
