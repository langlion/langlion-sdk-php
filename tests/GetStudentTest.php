<?php

use LangLion\SDK\DTO\StudentDTO;
use LangLion\SDK\Exception\RequestException;
use LangLion\SDK\Exception\UnauthorizedException;
use LangLion\SDK\LLSDK;
use LangLion\SDK\Tests\Mock\HttpClientMock;
use Psr\Http\Client\ClientInterface;
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/bootstrap.php';

final class GetStudentTest extends TestCase
{
    const CORRECT_ID = 1;
    const WRONG_ID = -1;

    private ?ClientInterface $httpClient;
    private LLSDK $llSdk;

    public function setUp(): void
    {
        //$this->httpClient = null;
        $this->httpClient = new HttpClientMock();
        $this->llSdk = new \LangLion\SDK\LLSDK(
            instanceId: 'test',
            httpClient: $this->httpClient
        );
    }

    public function testGetStudentAuthorized(): void
    {
        $llSdk = $this->llSdk;
        $llSdk->authorize('administrator', 'secret');
        $student = $llSdk->getStudent(self::CORRECT_ID);

        $this->assertInstanceOf(StudentDTO::class, $student);
        $this->assertSame(self::CORRECT_ID, $student->getId());
        $this->assertSame('Maciej', $student->getFirstName());
        $this->assertSame('Kursant', $student->getLastName());
        $this->assertSame('+48799010338', $student->getMobile(), 'mobile');
        $this->assertSame('test@langlion.com', $student->getEmail(), 'email');
    }

    public function testGetStudentUnauthorized()
    {
        $llSdk = $this->llSdk;
        $this->expectException(UnauthorizedException::class);
        $llSdk->getStudent(self::CORRECT_ID);
    }

    public function testGetStudentWrongId()
    {
        $llSdk = $this->llSdk;
        $llSdk->authorize('administrator', 'secret');

        $this->expectException(RequestException::class);
        $llSdk->getStudent(self::WRONG_ID);
    }
}