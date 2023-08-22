<?php

declare(strict_types=1);

namespace LangLion\SDK\DTO;

use ReflectionClass;
use ReflectionProperty;

abstract class DTO
{
    static public function fromArray(array $data): static
    {
        $dto = new static();

        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($dto, $setter)) {
                $dto->$setter($value);
            }
        }

        return $dto;
    }

    public function toArray(): array
    {
        $data = [];

        $dtoReflection = new ReflectionClass($this);
        $dtoProperties = $dtoReflection->getProperties(ReflectionProperty::IS_PRIVATE);

        foreach ($dtoProperties as $property) {
            $propertyName = $property->getName();
            $getter = 'get' . ucfirst($propertyName);
            if ($property->isInitialized($this) && method_exists($this, $getter)) {
                $data[$propertyName] = $this->$getter();
            }
        }

        return $data;
    }
}