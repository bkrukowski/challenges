<?php

declare(strict_types=1);

namespace bkrukowski\Challenges\Encoder;

final class Key implements KeyInterface
{
    /**
     * @var int[]
     */
    private $numbers;

    public function __construct(int $number, int ...$numbers)
    {
        \array_unshift($numbers, $number);
        $this->numbers = $numbers;
    }

    public function length(): int
    {
        return \count($this->numbers);
    }

    public function encodeNumber(int $input): int
    {
        if ($input >= $this->length() || 0 > $input) {
            throw new \InvalidArgumentException(\sprintf(
                'Number should be between %d and %d, %d given',
                0,
                $this->length(),
                $input
            ));
        }
        return $this->numbers[$input];
    }

    public function decodeNumber(int $number): int
    {
        if (false === $result = \array_search($number, $this->numbers)) {
            throw new \InvalidArgumentException(\sprintf('Key does not contain number %d', $number));
        }

        return $result;
    }
}
