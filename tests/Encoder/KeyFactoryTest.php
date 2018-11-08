<?php

declare(strict_types=1);

namespace bkrukowski\Challenges\Encoder;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class KeyFactoryTest extends TestCase
{
    /**
     * @dataProvider providerCreate
     *
     * @param string $input
     * @param string $result
     */
    public function testCreate(string $input, string $result)
    {
        $key = (new KeyFactory())->create($input);
        $generated = '';
        for ($i = 0; $i < $key->length(); $i++) {
            $generated .= $key->encodeNumber($i) + 1;
        }

        static::assertSame($result, $generated);
    }

    public function providerCreate(): array
    {
        return [
            ['2e1Ca', '45231'],
            ['Bartek', '125634'],
            ['bArTeK', '264153'],
        ];
    }

    public function testCreateFromEmptyString()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Empty string is not allowed');
        (new KeyFactory())->create('');
    }

    /**
     * @dataProvider providerNotOnlyUniques
     *
     * @param string $input
     */
    public function testNotOnlyUniques(string $input)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Key must contain only unique characters');
        (new KeyFactory())->create($input);
    }

    public function providerNotOnlyUniques(): array
    {
        return [
            ['Hello'],
            ['Johnny'],
        ];
    }

    /**
     * @dataProvider providerInvalidCharacters
     *
     * @param string $input
     */
    public function testInvalidCharacters(string $input)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/^Expected characters/');
        (new KeyFactory())->create($input);
    }

    public function providerInvalidCharacters(): iterable
    {
        yield ['Bartłomiej'];
        yield ['Fo Bar'];
        foreach (['a', 'A', '0'] as $char) {
            yield [\chr(\ord($char) - 1)];
        }
        foreach (['z', 'Z', '9'] as $char) {
            yield [\chr(\ord($char) + 1)];
        }
    }
}
