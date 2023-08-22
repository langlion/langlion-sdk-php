<?php

namespace LangLion\SDK\Mapper;

use LangLion\SDK\DTO\DTOInterface;

interface MapperInterface
{
    public function apiToDto(array $apiResponse): DTOInterface;
}