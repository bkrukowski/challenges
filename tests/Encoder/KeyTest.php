<?php

declare(strict_types=1);

namespace bkrukowski\Challenges\Encoder;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class KeyTest extends TestCase
{
    /**
     * @dataProvider providerAll
     *
     * @param int[] ...$input
     */
    public function testAll(int ...$input)
    {
        $key = new Key(...$input);

        foreach ($input as $decoded => $encoded) {
            static::assertSame($encoded, $key->encodeNumber($decoded));
            static::assertSame($decoded, $key->decodeNumber($encoded));
        }

        static::assertSame(\count($input), $key->length());
    }

    public function providerAll(): array
    {
        return [
            [4, 5, 2, 3, 1],
            [1, 2, 3, 4, 5],
        ];
    }

    /**
     * @dataProvider providerEncodeNumberInvalidArg
     *
     * @param array $numbers
     * @param int   $input
     */
    public function testEncodeNumberInvalidArg(array $numbers, int $input)
    {
        $this->expectException(\InvalidArgumentException::class);
        $key = new Key(...$numbers);
        $key->encodeNumber($input);
    }

    public function providerEncodeNumberInvalidArg(): array
    {
        return [
            [[0, 1, 2], -1],
            [[0, 1, 2], 3],
        ];
    }

    /**
     * @dataProvider providerDecodeNumberInvalidArg
     *
     * @param array $numbers
     * @param int   $input
     */
    public function testDecodeNumberInvalidArg(array $numbers, int $input)
    {
        $this->expectException(\InvalidArgumentException::class);
        $key = new Key(...$numbers);
        $key->decodeNumber($input);
    }

    public function providerDecodeNumberInvalidArg(): array
    {
        return [
            [[0, 1, 2], -1],
            [[0, 1, 2], 3],
        ];
    }
}
