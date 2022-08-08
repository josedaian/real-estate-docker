<?php
namespace App\Enums;

enum PriceTypes: string
{
    case MIN = 'min';
    case MAX = 'max';
    case AVG = 'avg';
}
