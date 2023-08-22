<?php

declare(strict_types=1);

namespace LangLion\SDK;

class GetStudentRequest extends Request
{
    protected string $method = 'GET';
    protected string $endpoint = '/api/v2/student';

    static public function create(int $id)
    {
        $request = new self([
            'id' => $id
        ]);

        return $request;
    }
}