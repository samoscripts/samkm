<?php

namespace App\Entity;

class RouteEntity
{
    public function __construct(
        public int $nextNumber,
        public \DateTime $date,
        public string $description,
        public string $destination,
        public int $distance,
        public string $comments
    ) {}
}