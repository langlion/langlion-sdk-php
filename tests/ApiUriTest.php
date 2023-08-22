<?php

namespace LangLion\SDK\Tests;

use LangLion\SDK\ApiUri;
use PHPUnit\Framework\TestCase;

class ApiUriTest extends TestCase
{
    public function testApiUri()
    {
        $apiUri = new ApiUri();

        $apiUri
            ->withScheme('https')
            ->withHost('test.langlion.com')
            ->withFragment('fragment')
            ->withPath('path')
            ->withPort(12345)
            ->withQuery('id=1')
            ->withUserInfo('user', 'password');

        $this->assertSame('https://user:password@test.langlion.com:12345/path?id=1#fragment', $apiUri->__toString());
    }
}