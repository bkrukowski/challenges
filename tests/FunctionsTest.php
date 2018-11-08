<?php

declare(strict_types=1);

namespace bkrukowski\Challenges;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class FunctionsTest extends TestCase
{
    /**
     * @dataProvider providerMbStrSplit
     *
     * @param string $input
     * @param array  $output
     */
    public function testMbStrSplit(string $input, array $output)
    {
        static::assertSame($output, mbStrSplit($input));
    }

    public function providerMbStrSplit(): array
    {
        return [
            ['©', ['©']],
            ['←↑→↓', ['←', '↑', '→', '↓']],
        ];
    }

    /**
     * @dataProvider providerStrShort
     *
     * @param string $input
     * @param string $output
     */
    public function testStrShort(string $input, string $output)
    {
        static::assertSame($output, strShort($input));
    }

    public function providerStrShort(): array
    {
        return [
            ['Hello Bartłomiej Krukowski', 'HBK'],
            ['Hello BartŁomiej Krukowski', 'HBŁ'],
            ['Hello BartŁomiej Krukowski', 'HBŁ'],
            ['BartŁomiej Krukowski', 'BŁK'],
            ['Bartłomiej Krukowski', 'BKA'],
            ['bartłomiej krukowski', 'BAR'],
            ['ba', 'BA'],
        ];
    }

    /**
     * @dataProvider providerTestSortWords
     *
     * @param string $input
     * @param string $output
     */
    public function testSortWords(string $input, string $output)
    {
        static::assertSame($output, sortWords($input));
    }

    public function providerTestSortWords(): array
    {
        return [
            ['is2 Thi1s T7est 4a', 'Thi1s is2 4a T7est'],
            ['i3s My1 B4rtłomiej 2name', 'My1 2name i3s B4rtłomiej'],
            ['0case2 edge1', 'edge1 0case2'],
            ['', ''],
        ];
    }

    /**
     * @dataProvider providerSortWordsInvalidWord
     *
     * @param string $input
     */
    public function testSortWordsInvalidWord(string $input)
    {
        $this->expectException(\InvalidArgumentException::class);
        sortWords($input);
    }

    public function providerSortWordsInvalidWord()
    {
        return [
            ['Al Capone'],
            ['   '],
        ];
    }

    /**
     * @dataProvider providerFindUnique
     *
     * @param array  $input
     * @param string $output
     */
    public function testFindUnique(array $input, string $output)
    {
        static::assertSame($output, findUnique($input));
    }

    public function providerFindUnique(): array
    {
        return [
            [['Aa', 'aaa', 'aaaaa', 'BbBb', 'Aaaa', 'AaAaAa', 'a'], 'BbBb'],
            [['abc', 'acb', 'bac', 'foo', 'bca', 'cab', 'cba'], 'foo'],
            [['silvia', 'vasili', 'victor'], 'victor'],
            [['Tom Marvolo Riddle', 'I am Lord Voldemort', 'Harry Potter'], 'Harry Potter'],
            [['     ', 'a', ' '], 'a'],
            [['a', 'a ', 'b'], 'b'],
        ];
    }

    /**
     * @dataProvider providerNoUniqueWords
     *
     * @param array $words
     */
    public function testNoUniqueWords(array $words)
    {
        $this->expectException(\RuntimeException::class);
        findUnique($words);
    }

    public function providerNoUniqueWords(): array
    {
        return [
            [['aaa', 'aaa']],
            [['Tom Marvolo Riddle', 'I am Lord Voldemort']],
        ];
    }

    /**
     * @dataProvider providerToManyUniques
     *
     * @param array $words
     */
    public function testTooManyUniques(array $words)
    {
        $this->expectException(\RuntimeException::class);
        findUnique($words);
    }

    public function providerToManyUniques(): array
    {
        return [
            [['Jane', 'Doe']],
            [['Johnny', 'Bravo']],
        ];
    }
}
