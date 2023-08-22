<?php

declare(strict_types=1);

namespace LangLion\SDK;

use LangLion\SDK\DTO\StudentDTO;

class CreateStudentRequest extends Request
{
    protected string $method = 'POST';
    protected string $endpoint = '/api/v2/student';

    static public function create(StudentDTO $student)
    {
        $request = new self(data: $student->toArray());

        return $request;
    }
}