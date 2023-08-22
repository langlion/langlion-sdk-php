<?php

declare(strict_types=1);

namespace LangLion\SDK\Mapper;

use LangLion\SDK\DTO\DTOInterface;

abstract class Mapper implements MapperInterface
{
    abstract public function apiToDto(array $apiResponse): DTOInterface;
}