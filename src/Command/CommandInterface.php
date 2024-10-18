<?php

namespace App\Command;
interface CommandInterface
{


    public function execute(array $args): void;

    public function getName(): string;

    public function getShortcut(): string;

    public function displayCommandInfo(): void;
    public function displayOptionInfo(): void;
}