<?php

namespace App\Entity;

class CompanyEntity
{
    public function __construct(
        public string $name,
        public string $nip,
        public string $address
    ) {}
}