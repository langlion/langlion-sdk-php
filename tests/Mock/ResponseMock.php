<?php

namespace LangLion\SDK\Tests\Mock;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

abstract class ResponseMock implements ResponseInterface
{
    const TOKEN = 'authorized';

    protected bool $isAuthorized = false;
    protected StreamInterface $streamMock;
    protected string $reasonPhrase;

    public function __construct(RequestInterface $request)
    {
        $this->isAuthorized = $this->checkAuthorization($request);
        $this->streamMock = new StreamMock();
    }

    protected function checkAuthorization(RequestInterface $request): bool
    {
        $authorizationLine = $request->getHeaderLine('Authorization');
        preg_match('/Bearer (?<token>.*)/', $authorizationLine, $matches);
        $token = $matches['token'];

        return $token == self::TOKEN;
    }

    public function getStatusCode(): int
    {
        return 200;
    }

    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
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
        return $this->streamMock;
    }

    public function withBody(StreamInterface $body): static
    {
        return $this;
    }

    public function withStatus($code, $reasonPhrase = ''): static
    {
        return $this;
    }
}