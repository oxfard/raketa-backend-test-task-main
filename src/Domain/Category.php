<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Domain;

final readonly class Category
{
    public function __construct(
        private int $id,
        private string $name,
        private ?string $description = null,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}

