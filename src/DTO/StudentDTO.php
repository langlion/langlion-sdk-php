<?php

declare(strict_types=1);

namespace LangLion\SDK\DTO;

class StudentDTO extends DTO implements DTOInterface
{
    private ?int $id = null;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $mobile;
    private ?int $userId;
    private mixed $schoolId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): StudentDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): StudentDTO
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): StudentDTO
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): StudentDTO
    {
        $this->email = $email;
        return $this;
    }

    public function getMobile(): string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): StudentDTO
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): StudentDTO
    {
        $this->userId = $userId;
        return $this;
    }

    public function getSchoolId(): ?int
    {
        return $this->schoolId;
    }

    public function setSchoolId(mixed $schoolId): StudentDTO
    {
        $this->schoolId = $schoolId ? intval($schoolId) : null;

        return $this;
    }
}