<?php

declare(strict_types=1);

namespace bkrukowski\Challenges\Encoder;

final class KeyFactory
{
    public function create(string $key): Key
    {
        if ('' === $key) {
            throw new \InvalidArgumentException('Empty string is not allowed');
        }

        if (0 === \preg_match('/^[A-Za-z0-9]+$/', $key)) {
            throw new \InvalidArgumentException('Expected characters [A-Za-z0-9]');
        }

        $chars = \str_split($key);

        if (\count($chars) !== \count(\array_unique($chars))) {
            throw new \InvalidArgumentException('Key must contain only unique characters');
        }

        $order = \array_flip($chars);

        \usort(
            $chars,
            function ($left, $right) {
                return $this->convertCharToNumber($left) <=> $this->convertCharToNumber($right);
            }
        );

        $numbers = [];

        foreach ($chars as $char) {
            $numbers[] = $order[$char];
        }

        return new Key(...$numbers);
    }

    private function convertCharToNumber(string $input): int
    {
        $num = \ord($input);

        if ($num >= 65 && $num <= 90) { // ord('A'), ord('Z')
            return $num;
        }

        if ($num >= 97 && $num <= 122) { // ord('a'), ord('z')
            return $num + 100;
        }

        return $num + 200; // 0 - 9
    }
}
