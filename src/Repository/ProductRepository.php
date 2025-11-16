<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Repository;

use Brick\Math\BigDecimal;
use Doctrine\DBAL\Connection;
use Raketa\BackendTestTask\Domain\Category;
use Raketa\BackendTestTask\Domain\Product;
use Raketa\BackendTestTask\Domain\Exception\EntityNotFoundException;

class ProductRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getByUuid(string $uuid): Product
    {
        $row = $this->connection->fetchAssociative(
            "SELECT p.*, c.id as category_id, c.name as category_name, c.description as category_description
             FROM products p
             INNER JOIN categories c ON p.category_id = c.id
             WHERE p.uuid = ?",
            [$uuid]
        );

        if (empty($row)) {
            throw new EntityNotFoundException('Product not found');
        }

        return $this->map($row);
    }

    public function getByCategory(string $categoryName): array
    {
        $rows = $this->connection->fetchAllAssociative(
            "SELECT p.*, c.id as category_id, c.name as category_name, c.description as category_description
             FROM products p
             INNER JOIN categories c ON p.category_id = c.id
             WHERE p.is_active = 1 AND c.name = ?",
            [$categoryName]
        );

        return array_map(
            fn (array $row): Product => $this->map($row),
            $rows
        );
    }

    private function map(array $row): Product
    {
        $category = new Category(
            (int) $row['category_id'],
            $row['category_name'],
            $row['category_description'] ?? null
        );

        return new Product(
            (int) $row['id'],
            $row['uuid'],
            (bool) $row['is_active'],
            $category,
            $row['name'],
            $row['description'] ?? '',
            $row['thumbnail'] ?? '',
            BigDecimal::of($row['price']),
        );
    }
}
