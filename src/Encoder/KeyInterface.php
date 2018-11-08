<?php

declare(strict_types=1);

namespace bkrukowski\Challenges\Encoder;

interface KeyInterface
{
    public function length(): int;

    public function encodeNumber(int $input): int;

    public function decodeNumber(int $number): int;
}
