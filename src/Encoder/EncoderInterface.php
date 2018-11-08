<?php

declare(strict_types=1);

namespace bkrukowski\Challenges\Encoder;

interface EncoderInterface
{
    public function encode(string $message): string;

    public function decode(string $encrypted): string;
}
