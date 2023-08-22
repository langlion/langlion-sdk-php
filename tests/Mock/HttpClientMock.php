<?php

namespace LangLion\SDK\Tests\Mock;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpClientMock implements ClientInterface
{
    const CORRECT_HOST = 'test.langlion.com';

    public function __construct()
    {

    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri();

        if ($uri->getHost() !== self::CORRECT_HOST) {
            throw new \Exception("Incorrect host: {$uri->getHost()}");
        }

        switch ($uri->getPath()) {
            case '/api/v2/authorize':
                return $this->getAuthorizeResponse($request);
            case '/api/v2/student':
                return $this->getStudentResponse($request);
            default:
                throw new \Exception("Request {$uri->getPath()} not supported");
        }
    }

    private function getStudentResponse(RequestInterface $request): ResponseInterface
    {
        switch ($request->getMethod()) {
            case 'GET':
                return new GetStudentResponseMock($request);
            case 'POST':
                return new CreateStudentResponseMock($request);
            case 'PATCH':
                return new UpdateStudentResponseMock($request);
            default:
                throw new \Exception("Method {$request->getMethod()} not supported");
        }
    }

    private function getAuthorizeResponse(RequestInterface $request): ResponseInterface
    {
        return new AuthorizeResponseMock($request);
    }
}