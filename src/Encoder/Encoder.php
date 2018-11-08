<?php

declare(strict_types=1);

namespace bkrukowski\Challenges\Encoder;

final class Encoder implements EncoderInterface
{
    private $key;

    public function __construct(KeyInterface $key)
    {
        $this->key = $key;
    }

    public function encode(string $message): string
    {
        $result = '';
        foreach (\array_chunk(\str_split($message), $this->key->length()) as $chunk) {
            $arr = \array_fill(0, $this->key->length(), ' ');
            foreach ($chunk as $pos => $char) {
                $arr[$this->key->encodeNumber($pos)] = $char;
            }
            $result .= \implode('', $arr);
        }

        return $result;
    }

    public function decode(string $encrypted): string
    {
        $result = '';
        foreach (\array_chunk(\str_split($encrypted), $this->key->length()) as $chunk) {
            $arr = \array_fill(0, $this->key->length(), ' ');
            foreach ($chunk as $pos => $char) {
                $arr[$this->key->decodeNumber($pos)] = $char;
            }
            $result .= \implode('', $arr);
        }

        return \rtrim($result, ' ');
    }
}
