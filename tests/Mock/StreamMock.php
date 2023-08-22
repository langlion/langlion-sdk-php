<?php

namespace LangLion\SDK\Tests\Mock;

use Psr\Http\Message\StreamInterface;

class StreamMock implements StreamInterface
{
    private string $contents;

    public function __toString(): string
    {
        return '';
    }

    public function close(): void
    {
    }

    public function detach(): mixed
    {
        return null;
    }

    public function getSize(): ?int
    {
        return null;
    }

    public function tell(): int
    {
        return 0;
    }

    public function eof(): bool
    {
        return false;
    }

    public function isSeekable(): bool
    {
        return false;
    }

    public function seek($offset, $whence = SEEK_SET): void
    {
    }

    public function rewind(): void
    {
    }

    public function isWritable(): bool
    {
        return false;
    }

    public function write($string): int
    {
        $this->contents = $string;

        return strlen($string);
    }

    public function isReadable(): bool
    {
        return false;
    }

    public function read($length): string
    {
        return '';
    }

    public function getContents(): string
    {
        return $this->contents;
    }

    public function getMetadata($key = null): mixed
    {
        return null;
    }
}