<?php

declare(strict_types=1);

namespace LangLion\SDK;

use Psr\Http\Message\UriInterface;

class ApiUri implements UriInterface
{
    private string $instanceId;

    private string $scheme = 'https';
    private string $host = '';
    private int $port = 443;
    private string $user;
    private string $password;
    private string $path = '';
    private string $query;
    private string $fragment;

    public function __construct()
    {
    }

    public function getScheme(): string
    {
        return 'https';
    }

    public function getAuthority(): string
    {
        return '';
    }

    public function getUserInfo(): string
    {
        return sprintf("%s:%s", $this->user, $this->password);
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getFragment(): string
    {
        return $this->fragment;
    }

    public function withScheme($scheme): UriInterface
    {
        $this->scheme = $scheme;

        return $this;
    }

    public function withUserInfo($user, $password = null): UriInterface
    {
        $this->user = $user;
        $this->password = $password;

        return $this;
    }

    public function withHost($host): UriInterface
    {
        $this->host = $host;

        return $this;
    }

    public function withPort($port): UriInterface
    {
        $this->port = $port;

        return $this;
    }

    public function withPath($path): UriInterface
    {
        $this->path = $path;

        return $this;
    }

    public function withQuery($query): UriInterface
    {
        $this->query = $query;

        return $this;
    }

    public function withFragment($fragment): UriInterface
    {
        $this->fragment = $fragment;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf("%s://%s@%s:%d/%s?%s#%s", $this->getScheme(), $this->getUserInfo(), $this->getHost(), $this->getPort(), $this->getPath(), $this->getQuery(), $this->getFragment());
    }

}