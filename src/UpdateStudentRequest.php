<?php

declare(strict_types=1);

namespace LangLion\SDK;

use LangLion\SDK\DTO\StudentDTO;
use LangLion\SDK\DTO\StudentMapper;
use LangLion\SDK\Exception\RequestException;
use LangLion\SDK\Exception\UnauthorizedException;

class UpdateStudentRequest extends Request
{
    protected string $method = 'PATCH';
    protected string $endpoint = '/api/v2/student';

    static public function create(int $id, StudentDTO $student)
    {
        $request = new self(
            params: [
                'id' => $id
            ],
            data: $student->toArray()
        );

        return $request;
    }
}