<?php

declare(strict_types=1);

namespace LangLion\SDK;

use LangLion\SDK\DTO\DTOInterface;
use LangLion\SDK\DTO\StudentDTO;
use LangLion\SDK\Exception\AuthorizeException;
use LangLion\SDK\Exception\RequestException;
use LangLion\SDK\Exception\UnauthorizedException;
use LangLion\SDK\Mapper\MapperFactory;
use LangLion\SDK\Mapper\MapperInterface;
use LangLion\SDK\Mapper\StudentMapper;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

require __DIR__ . '/../src/bootstrap.php';

final class LLSDK
{
    private string $instanceId;
    private ?AccessToken $accessToken = null;

    private ClientInterface $httpClient;
    // TODO: why type HttpFactoryInterface cannot be added?
    private $httpFactory;

    public function __construct(
        string $instanceId,
        ClientInterface $httpClient = null,
        HttpFactoryInterface $httpFactory = null
    )
    {
        if ($httpClient === null) {
            $httpClient = new \GuzzleHttp\Client();
        }

        if ($httpFactory === null) {
            $httpFactory = new \GuzzleHttp\Psr7\HttpFactory();
        }

        $this->instanceId = $instanceId;
        $this->httpClient = $httpClient;
        $this->httpFactory = $httpFactory;
    }

    public function authorize(string $clientId, string $clientSecret): bool
    {
        $request = $this->httpFactory->createRequest('POST', "https://{$this->getInstanceUrl()}/api/v2/authorize");
        $request = $request
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withHeader('Authorization', 'Basic '. base64_encode($clientId . ':' . $clientSecret))
            ->withBody($this->httpFactory->createStream('grant_type=client_credentials'));

        $response = $this->httpClient->sendRequest($request);
        $repsonseContents = $response->getBody()->getContents();
        $jsonResponse = json_decode($repsonseContents, associative: true);

        if ($response->getReasonPhrase() !== 'OK') {
            throw new AuthorizeException($jsonResponse['error_description']);
        }

        $this->accessToken = AccessToken::fromArray($jsonResponse);

        return true;
    }

    public function getAccessToken(): ?AccessToken
    {
        return $this->accessToken;
    }

    public function getStudent(int $id): StudentDTO
    {
        $studentRequest = GetStudentRequest::create($id);
        $studentDTO = $this->sendRequest($studentRequest, new StudentMapper());

        return $studentDTO;
    }

    public function createStudent(StudentDTO $student): StudentDTO
    {
        $studentRequest = CreateStudentRequest::create($student);
        $studentDTO = $this->sendRequest($studentRequest, new StudentMapper());

        return $studentDTO;
    }

    public function updateStudent(int $studentId, StudentDTO $student): StudentDTO
    {
        $studentRequest = UpdateStudentRequest::create($studentId, $student);
        $studentDTO = $this->sendRequest($studentRequest, new StudentMapper());

        return $studentDTO;
    }

    // TODO: type
    public function sendRequest(Request $apiRequest, MapperInterface $responseMapper): DTOInterface
    {
        $httpRequest = $this->apiToHttpRequest($apiRequest);
        $response = $this->httpClient->sendRequest($httpRequest);

        $responseContents = $response->getBody()->getContents();
        $responseArray = json_decode($responseContents, associative: true);

        switch ($response->getReasonPhrase()) {
            case 'OK':
                break;
            case 'Forbidden':
                if (isset($responseArray['error'])) {
                    throw new UnauthorizedException($responseArray['error_description']);
                }
            default:
                throw new RequestException($responseArray['error_description'] ?? $responseArray['error']['message'] ?? 'Unknown error');
        }

        $dto = $responseMapper->apiToDto($responseArray);

        return $dto;
    }

    private function apiToHttpRequest($apiRequest): RequestInterface
    {
        $requestUri = $apiRequest
            ->getUri()
            ->withHost("{$this->instanceId}.langlion.com");

        $httpRequest = $this->httpFactory->createRequest($apiRequest->getMethod(), $requestUri)
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded');

        if ($this->accessToken) {
            $httpRequest = $httpRequest->withHeader('Authorization', 'Bearer ' . $this->accessToken->getAccessToken());
        }

        if ($apiRequest->hasData()) {
            $dataStream = $this->httpFactory->createStream(http_build_query($apiRequest->getData()));
            $httpRequest = $httpRequest->withBody($dataStream);
        }

        return $httpRequest;
    }

    private function getInstanceUrl(): string
    {
        return $this->instanceId . '.langlion.com';
    }

    public function getInstanceId(): string
    {
        return $this->instanceId;
    }
}