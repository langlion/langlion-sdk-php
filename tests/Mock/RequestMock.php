<?php

namespace LangLion\SDK\Tests\Mock;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;


class RequestMock implements RequestInterface
{
    private UriInterface $uri;

    public function __construct(UriInterface $uri)
    {
        $this->uri = $uri;
    }

    public function withMethod(string $method): RequestInterface
    {
        return $this;
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getRequestTarget(): string
    {
        return '';
    }

    public function withRequestTarget($requestTarget): static
    {
        return $this;
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    public function withUri(UriInterface $uri, $preserveHost = false): static
    {
        return $this;
    }

    public function getProtocolVersion(): string
    {
        return '1.1';
    }

    public function withProtocolVersion($version): static
    {
        return $this;
    }

    public function getHeaders(): array
    {
        return [];
    }

    public function hasHeader($name): bool
    {
        return false;
    }

    public function getHeader($name): array
    {
        return [];
    }

    public function getHeaderLine($name): string
    {
        return '';
    }

    public function withHeader($name, $value): static
    {
        return $this;
    }

    public function withAddedHeader($name, $value): static
    {
        return $this;
    }

    public function withoutHeader($name): static
    {
        return $this;
    }

    public function getBody(): StreamInterface
    {
        return new StreamMock();
    }

    public function withBody(StreamInterface $body): static
    {
        return $this;
    }

}