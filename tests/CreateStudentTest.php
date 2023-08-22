<?php

use LangLion\SDK\AccessToken;
use LangLion\SDK\DTO\StudentDTO;
use LangLion\SDK\Exception\AuthorizeException;
use LangLion\SDK\Exception\RequestException;
use LangLion\SDK\Exception\UnauthorizedException;
use LangLion\SDK\LLSDK;
use LangLion\SDK\Tests\Mock\HttpClientMock;
use LangLion\SDK\Tests\TestRequestFactory;
use Psr\Http\Client\ClientInterface;
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/bootstrap.php';

final class CreateStudentTest extends TestCase
{
    private ClientInterface $httpClient;
    private LLSDK $llSdk;

    public function setUp(): void
    {
        $this->httpClient = new HttpClientMock();
        //$this->httpClient = new \GuzzleHttp\Client();
        $this->llSdk = new \LangLion\SDK\LLSDK(
            instanceId: 'test',
            httpClient: $this->httpClient
        );
    }

    public function testCreateStudentAuthorized(): void
    {
        $llSdk = $this->llSdk;
        $llSdk->authorize('administrator', 'secret');

        $student = new StudentDTO();
        $student->setFirstName('John');
        $student->setLastName('Student');
        $student->setEmail('test@langlion.com');
        $student->setMobile('+48799010338');
        $student->setSchoolId(1);
        $student = $llSdk->createStudent($student);

        $this->assertInstanceOf(StudentDTO::class, $student);
        $this->assertSame(1, $student->getId());
        $this->assertSame('John', $student->getFirstName());
        $this->assertSame('Student', $student->getLastName());
        $this->assertSame('test@langlion.com', $student->getEmail());
        $this->assertSame('+48799010338', $student->getMobile());
    }

    public function testCreateStudentMissingParameters(): void
    {
        $llSdk = $this->llSdk;
        $llSdk->authorize('administrator', 'secret');

        $student = new StudentDTO();
        $student->setFirstName('John');

        $this->expectException(RequestException::class);
        $student = $llSdk->createStudent($student);
    }

    public function testCreateStudentUnauthorized(): void
    {
        $llSdk = $this->llSdk;

        $student = new StudentDTO();
        $student->setFirstName('John');
        $student->setLastName('Student');

        $this->expectException(UnauthorizedException::class);
        $student = $llSdk->createStudent($student);
    }
}