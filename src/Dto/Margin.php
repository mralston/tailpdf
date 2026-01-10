<?php

namespace Mralston\TailPdf\Dto;

class Margin
{
    public function __construct(
        public int $top = 0,
        public int $right = 0,
        public int $bottom = 0,
        public int $left = 0
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'top' => (string)$this->top,
            'right' => (string)$this->right,
            'bottom' => (string)$this->bottom,
            'left' => (string)$this->left,
        ];
    }
}
