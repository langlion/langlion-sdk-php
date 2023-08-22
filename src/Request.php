<?php

namespace LangLion\SDK;

use Psr\Http\Message\UriInterface;

abstract class Request implements RequestInterface
{
    protected UriInterface $uri;

    protected string $method = 'GET';
    protected string $endpoint = '';
    protected array $params = [];
    protected mixed $data = null;

    public function __construct(array $params = [], mixed $data = null)
    {
        $this->params = $params;
        $this->data = $data;

        $uri = new ApiUri();
        $uri->withPath($this->getEndpoint());

        if ($params) {
            $uri = $uri->withQuery(http_build_query($params));
        }

        $this->uri = $uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function hasData(): bool
    {
        return $this->data !== null;
    }
}