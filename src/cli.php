<?php

use App\Command\CommandFactory;

require __DIR__ . '/../vendor/autoload.php';

try {
    $command = CommandFactory::createCommand($argv);
    $command->execute(array_slice($argv, 2));
} catch (\InvalidArgumentException $e) {
    echo "\033[31mOptions Error: \n" . $e->getMessage() . "\033[0m\n"; // Red color
    $command->displayCommandInfo();
    $command->displayOptionInfo();
    exit(1);
} catch (\Exception $e) {
    echo "\033[31mAn unexpected error occurred: " . $e->getMessage() . "\033[0m\n"; // Red color
    CommandFactory::displayAllCommandInfo();
    exit(1);
}
