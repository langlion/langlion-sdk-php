<?php

namespace LangLion\SDK\Tests\Mock;

use GetStudentTest;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GetStudentResponseMock extends ResponseMock implements ResponseInterface
{
    private int $id;

    public function __construct(RequestInterface $request)
    {
        parent::__construct($request);

        $uri = $request->getUri();
        $query = $uri->getQuery();
        parse_str($query, $queryArray);

        $this->id = intval($queryArray['id']);
    }

    public function getBody(): StreamInterface
    {
        if ($this->isAuthorized) {
            $this->setAuthorizedBody();
        } else {
            $this->setUnauthorizedBody();
        }

        return parent::getBody();
    }

    private function setAuthorizedBody(): void
    {
        if ($this->id === GetStudentTest::CORRECT_ID) {
            $this->setStudentBody();
        } else {
            $this->setWrongIdBody();
        }
    }

    private function setStudentBody(): void
    {
        $this->reasonPhrase = 'OK';

        $this->streamMock->write(
            <<<EOF
            {
                "data": {
                    "student": {
                        "id": 1,
                        "isAdult": 0,
                        "isActive": 1,
                        "createdAt": "2017-12-18 16:10:04",
                        "updatedAt": "2018-03-23 12:33:43",
                        "user": {
                            "id": 1,
                            "login": "student",
                            "name": "Maciej",
                            "firstName": "Maciej",
                            "lastName": "Kursant",
                            "fullname": "Maciej Kursant",
                            "systemRole": "student",
                            "isArchived": 0,
                            "photo": null,
                            "language": "pl_PL",
                            "tosAccepted": 1,
                            "type": 0,
                            "typeName": null,
                            "createdAt": "2017-12-18 16:10:04",
                            "updatedAt": "2023-07-29 13:42:29",
                            "additionalData": {
                                "id": 2,
                                "phone": null,
                                "mobile": "+48799010338",
                                "email": "test@langlion.com",
                                "skype": null,
                                "street": "Kwiatowa 4/5 ",
                                "zipCode": "01-123 ",
                                "city": "Warszawa",
                                "country": null,
                                "post": null,
                                "province": null,
                                "pesel": null,
                                "nipNumber": null,
                                "birthDate": null,
                                "birthPlace": null,
                                "description": null,
                                "billingName": null,
                                "billingStreet": "Kwiatowa 4/5 ",
                                "billingCity": "Warszawa",
                                "billingZipCode": "01-123 ",
                                "billingNipNumber": null,
                                "billingPesel": null,
                                "billingEmail": null,
                                "createdAt": "2017-12-18 16:10:04",
                                "updatedAt": "2023-08-04 09:14:05"
                            },
                            "parentUser": {
                                "id": 4,
                                "login": "studentr",
                                "name": null,
                                "firstName": null,
                                "lastName": null,
                                "fullname": null,
                                "systemRole": "parent",
                                "isArchived": 0,
                                "photo": null,
                                "language": "pl_PL",
                                "tosAccepted": 0,
                                "type": null,
                                "typeName": null,
                                "createdAt": "2017-12-18 16:10:04",
                                "updatedAt": "2020-09-21 16:18:11",
                                "additionalData": {
                                    "id": 3,
                                    "phone": null,
                                    "mobile": "+48799010338",
                                    "email": "test@langlion.com",
                                    "skype": null,
                                    "street": null,
                                    "zipCode": null,
                                    "city": null,
                                    "country": null,
                                    "post": null,
                                    "province": null,
                                    "pesel": null,
                                    "nipNumber": null,
                                    "birthDate": null,
                                    "birthPlace": null,
                                    "description": null,
                                    "billingName": null,
                                    "billingStreet": null,
                                    "billingCity": null,
                                    "billingZipCode": null,
                                    "billingNipNumber": null,
                                    "billingPesel": null,
                                    "billingEmail": null,
                                    "createdAt": "2017-12-18 16:10:04",
                                    "updatedAt": "2017-12-18 16:10:04"
                                },
                                "parentUser": null
                            }
                        }
                    }
                }
            }
            EOF
        );
    }

    private function setUnauthorizedBody(): void
    {
        $this->reasonPhrase = 'Forbidden';

        $this->streamMock->write(
            <<<EOF
            {
                "error": "invalid_client",
                "error_description": "The client credentials are invalid"
            }
            EOF
        );
    }

    private function setWrongIdBody(): void
    {
        $this->reasonPhrase = 'Not Found';

        $this->streamMock->write(
            <<<EOF
            {
                "error": {
                    "code": "notFound",
                    "message": "Student was not found"
                }
            }
            EOF
        );
    }
}