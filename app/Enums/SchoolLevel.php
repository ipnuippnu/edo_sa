<?php

namespace App\Enums;

enum SchoolLevel : int
{
    case SD = 1;
    case SLTP = 2;
    case SLTA = 3;
    case DI = 4;
    case DII = 5;
    case DIII = 6;
    case DIV = 7;
    case S1 = 8;
    case S2 = 9;
    case S3 = 10;

    public function fullName(): string
    {
        return match($this)
        {
            SchoolLevel::SD => 'SD / MI Sederajat',
            SchoolLevel::SLTP => 'SMP / MTs Sederajat',
            SchoolLevel::SLTA => 'SMA / SMK / MA Sederajat',
            SchoolLevel::DI => '(DI) Diploma I',
            SchoolLevel::DII => '(DII) Diploma II',
            SchoolLevel::DIII => '(DIII) Diploma III',
            SchoolLevel::DIV => '(DIV) Diploma IV',
            SchoolLevel::S1 => '(S1) Sarjana 1',
            SchoolLevel::S2 => '(S2) Sarjana 2',
            SchoolLevel::S3 => '(S3) Sarjana 3',
        };
    }
}
