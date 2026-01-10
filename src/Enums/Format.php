<?php

namespace Mralston\Tailpdf\Enums;

enum Format: string
{
    case A4 = 'a4';
    case LETTER = 'letter';
    case LEGAL = 'legal';
    case A3 = 'a3';
    case A5 = 'a5';
    case A6 = 'a6';
    case TABLOID = 'tabloid';
    case CUSTOM = 'custom';
}
