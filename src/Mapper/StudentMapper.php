<?php

declare(strict_types=1);

namespace LangLion\SDK\Mapper;

use LangLion\SDK\DTO\DTOInterface;
use LangLion\SDK\DTO\StudentDTO;

class StudentMapper extends Mapper implements MapperInterface
{
    public function apiToDto(array $apiResponse): DTOInterface
    {
        $studentData = $apiResponse['data']['student'];
        $id = $studentData['id'] ?? null;
        $userId = $studentData['user']['id'] ?? null;
        $firstName = $studentData['user']['firstName'] ?? '';
        $lastName = $studentData['user']['lastName'] ?? '';
        $email = $studentData['user']['additionalData']['email'] ?? '';
        $mobile = $studentData['user']['additionalData']['mobile'] ?? '';


        $student = new StudentDTO();
        $student->setId($id);
        $student->setFirstName($firstName);
        $student->setLastName($lastName);
        $student->setEmail($email);
        $student->setMobile($mobile);
        $student->setUserId($userId);

        return $student;
    }
}