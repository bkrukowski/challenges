<?php

declare(strict_types=1);

namespace bkrukowski\Challenges\Encoder;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class EncoderTest extends TestCase
{
    /**
     * @dataProvider providerEncode
     *
     * @param string $key
     * @param string $input
     * @param string $output
     */
    public function testEncode(string $key, string $input, string $output)
    {
        $encoder = $this->createEncoder($key);

        static::assertSame($output, $encoded = $encoder->encode($input));
        static::assertSame(\rtrim($input, ' '), $encoder->decode($encoded));
    }

    public function providerEncode(): array
    {
        return [
            ['2e1Ca', 'secretinformation', 'ecrseonftiiatrm   on'],
            ['5Ra7q', 'Fibbonaci', 'bFiobina c'],
            ['1', 'Foo ', 'Foo '],
        ];
    }

    /**
     * @dataProvider providerDecode
     *
     * @param string $key
     * @param string $input
     * @param string $output
     */
    public function testDecode(string $key, string $input, string $output)
    {
        static::assertSame($output, $this->createEncoder($key)->decode($input));
    }

    public function providerDecode(): array
    {
        return [
            ['2e1Ca', 'ollHelor W   d', 'Hello World'],
            ['1', 'Foo ', 'Foo'],
        ];
    }

    private function createEncoder(string $key): Encoder
    {
        return new Encoder((new KeyFactory())->create($key));
    }
}
