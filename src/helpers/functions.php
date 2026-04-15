<?php

function getInventoryStatus(int $quantity): string
{
    if ($quantity === 0) {
        return 'Out of Stock';
    } elseif ($quantity <= 5) {
        return 'Low Stock';
    }
    return 'In Stock';
}

function formatProductName(string $name): string
{
    return ucwords($name);
}

function calculateTotalStock(array $products): int
{
    return array_reduce($products, function ($sum, $product) {
        return $sum + $product['quantity'];
    }, 0);
}

function getInStockProducts(array $products): array
{
    return array_values(array_filter($products, function ($product) {
        return $product['quantity'] > 0;
    }));
}

function searchProducts(array $products, string $keyword): array
{
    return array_values(array_filter($products, function ($product) use ($keyword) {
        return stripos($product['name'], $keyword) !== false;
    }));
}
