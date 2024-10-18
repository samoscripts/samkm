<?php

namespace App\Entity;

class PersonEntity
{
    public function __construct(
        public string $forename,
        public string $surname,
        public string $address
    ) {}
}