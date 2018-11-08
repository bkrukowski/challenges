<?php

declare(strict_types=1);

namespace bkrukowski\Challenges;

/**
 * Equivalent of str_replace for multi-bytes strings
 *
 * @param string $input
 *
 * @return array
 *
 * @see http://php.net/manual/en/function.str-split.php
 */
function mbStrSplit(string $input): array
{
    return \preg_split('//u', $input, -1, PREG_SPLIT_NO_EMPTY);
}

/**
 * Challenge #1
 *
 * @param string $input
 *
 * @return string
 */
function strShort(string $input): string
{
    $result = '';
    $len = \mb_strlen($input);
    $limit = 3;

    for ($i = 0; $i < $len; $i++) {
        $letter = \mb_substr($input, $i, 1);
        if (\preg_match('/^\p{L}$/u', $letter) && \mb_strtoupper($letter) === $letter) {
            $result .= $letter;
            if (\mb_strlen($result) >= $limit) {
                return $result;
            }
        }
    }

    for ($i = 0; $i < $len; $i++) {
        $letter = \mb_substr($input, $i, 1);
        if (\preg_match('/^\p{L}$/u', $letter) && $letter === \mb_strtolower($letter)) {
            $result .= \mb_strtoupper($letter);
            if (\mb_strlen($result) >= $limit) {
                return $result;
            }
        }
    }

    return $result;
}

/**
 * Challenge #2
 *
 * @param string $input
 *
 * @return string
 */
function sortWords(string $input): string
{
    if ('' === $input) {
        return '';
    }

    $words = \explode(' ', $input);
    \usort(
        $words,
        function (string $left, string $right) {
            \preg_match('/[1-9]/', $left, $leftM);
            \preg_match('/[1-9]/', $right, $rightM);

            if (\in_array([], [$leftM, $rightM], true)) {
                throw new \InvalidArgumentException('Each word should contain character [1-9]');
            }

            return $leftM[0] <=> $rightM[0];
        }
    );

    return \implode(' ', $words);
}

/**
 * Removes spaces, returns unique letters
 *
 * @param string $word
 *
 * @return string[]
 */
function getUniqueLetters(string $word): array
{
    $word = \str_replace(' ', '', $word);
    $letters = \array_unique(mbStrSplit(\mb_strtolower($word)));
    \sort($letters);

    return $letters;
}

/**
 * Challenge #3
 *
 * @param array $words
 *
 * @return string
 */
function findUnique(array $words): string
{
    $counters = [];

    foreach ($words as $word) {
        $letters = getUniqueLetters($word);
        $key = \implode('', $letters);
        $counters[$key] = $counters[$key] ?? ['count' => 0, 'word' => $word];
        ++$counters[$key]['count'];
    }

    $uniques = \array_filter(
        $counters,
        function (array $counter) {
            return 1 === $counter['count'];
        }
    );

    $count = \count($uniques);

    if (0 === $count) {
        throw new \RuntimeException('Given set does not contain unique word');
    }

    if ($count > 1) {
        throw new \RuntimeException(\sprintf('Given set contains %d unique words', $count));
    }

    return \array_shift($uniques)['word'];
}
