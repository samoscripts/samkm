<?php
namespace App\Command;

class CommandFactory
{
    public static function createCommand(?array $argv): CommandInterface
    {
        $commandObjects = self::getAllCommands();
        if ($argv === null || count($argv) <= 1) {
            throw new \Exception('No command specified');
        }
        $inputCommandName = $argv[1];
        foreach ($commandObjects as $command) {
            if($command->getName() === $inputCommandName || $command->getShortcut() === $inputCommandName) {
                return $command;
            }
        }
        throw new \Exception("Unknown command: $inputCommandName");

    }


    public static function displayAllCommandInfo(): void
    {
        $availableCommands = self::getAllCommands();
        echo "Available commands:\n";
        foreach ($availableCommands as $command) {
            $command->displayCommandInfo();
        }
    }

    /**
     * @return CommandInterface[]
     */
    private static function getAllCommands(): array
    {
        $commandDir = __DIR__;
        $commandFiles = glob($commandDir . '/*.php');
        $commands = [];

        foreach ($commandFiles as $file) {
            $className = 'App\\Command\\' . basename($file, '.php');
            if (class_exists($className)) {
                $reflection = new \ReflectionClass($className);
                if($reflection->isAbstract()) {
                    continue;
                }
                if ($reflection->implementsInterface('App\\Command\\CommandInterface')) {
                    $commands[] = new($className);
                }
            }
        }

        return $commands;
    }
}