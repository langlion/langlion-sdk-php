<?php

namespace LangLion\SDK\Tests\Mock;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class AuthorizeResponseMock extends ResponseMock implements ResponseInterface
{
    const CLIENT_ID = 'administrator';
    const CLIENT_SECRET = 'secret';

    protected function checkAuthorization(RequestInterface $request): bool
    {
        $authorizationLine = $request->getHeaderLine('Authorization');
        preg_match('/Basic (?<authData>.*)/', $authorizationLine, $matches);
        $authData = $matches['authData'];
        $decodedAuth = base64_decode($authData);
        [$clientId, $clientSecret] = explode(':', $decodedAuth);

        return $clientId == self::CLIENT_ID && $clientSecret == self::CLIENT_SECRET;
    }

    public function getBody(): StreamInterface
    {
        $this->isAuthorized ? $this->setAuthorizedBody() : $this->setUnauthorizedBody();

        return parent::getBody();
    }

    private function setAuthorizedBody(): void
    {
        $this->reasonPhrase = 'OK';

        $this->streamMock->write(
            <<<EOF
            {
                "access_token": "authorized",
                "expires_in": 2592000,
                "token_type": "Bearer",
                "scope": "administrator"
            }
            EOF
        );
    }

    private function setUnauthorizedBody(): void
    {
        $this->reasonPhrase = 'Bad Request';

        $this->streamMock->write(
            <<<EOF
            {
                "error": "invalid_client",
                "error_description": "The client credentials are invalid"
            }
            EOF
        );
    }
}