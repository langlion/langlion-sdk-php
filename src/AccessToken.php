<?php

declare(strict_types=1);

namespace LangLion\SDK;

class AccessToken
{
    private string $accessToken;
    private int $expiresIn;
    private string $tokenType;
    private string $scope;

    public function __construct(string $accessToken, int $expiresIn, string $tokenType, string $scope)
    {
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
        $this->tokenType = $tokenType;
        $this->scope = $scope;

        $this->checkAccessToken();
    }

    private function checkAccessToken(): void
    {
        if (empty($this->accessToken)) {
            //throw new Exception\AccessTokenException('Access token is empty');
        }
    }

    static public function fromArray(array $data): self
    {
        $accessToken = $data['access_token'] ?? '';
        $expiresIn = $data['expires_in'] ?? 0;
        $tokenType = $data['token_type'] ?? '';
        $scope = $data['scope'] ?? '';

        return new self($accessToken, $expiresIn, $tokenType, $scope);
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function __toString(): string
    {
        return $this->getAccessToken();
    }
}
