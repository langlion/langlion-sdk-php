<?php

use LangLion\SDK\AccessToken;
use LangLion\SDK\Exception\AuthorizeException;
use LangLion\SDK\Tests\Mock\HttpClientMock;
use LangLion\SDK\Tests\TestRequestFactory;
use Psr\Http\Client\ClientInterface;
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/bootstrap.php';

final class AuthorizeTest extends TestCase
{
    private ClientInterface $httpClient;

    public function setUp(): void
    {
    }

    public function testAuthorized(): void
    {
        $httpClient = new HttpClientMock();
        $httpClient = null;

        $ll = new \LangLion\SDK\LLSDK(
            instanceId: 'test',
            httpClient: $httpClient
        );
        $isAuthorized = $ll->authorize('administrator', 'Uondt8yJTK8Mx3JY');
        $accessToken = $ll->getAccessToken();

        $this->assertTrue($isAuthorized);
        $this->assertIsString((string)$accessToken);
        $this->assertIsString($accessToken->getAccessToken());
        $this->assertIsString($accessToken->getTokenType());
        $this->assertIsString($accessToken->getScope());
        $this->assertIsInt($accessToken->getExpiresIn());
    }

    public function testNotAuthorized(): void
    {
        $httpClient = new HttpClientMock();
        $ll = new \LangLion\SDK\LLSDK('test', httpClient: $httpClient);
        $this->expectException(AuthorizeException::class);
        $ll->authorize('administrator', 'wrongpassword');
    }
}