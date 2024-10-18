<?php

namespace App\Command;

abstract class CommandAbstract implements CommandInterface
{

    private string $commandName;
    private string $commandShortcut;
    private string $commandDescription;
    private array $commandOptions;

    public function displayOptionInfo(): void
    {
        foreach ($this->getOptions() as $option) {
            echo "\033[32m--{$option['name']}\033[0m\t";
            echo "\033[32m-{$option['shortcut']}\033[0m\t";
            echo "\033[33mRequired:\033[0m " . ($option['required'] ? "\033[31mYes\033[0m" : "\033[32mNo\033[0m") . "\t";
            echo "\033[33mDescription:\033[0m {$option['description']}\n";
        }
    }

    public function displayCommandInfo(): void
    {
        $commandName = (strlen($this->getName()) <= 24)?str_pad($this->getName(), 24):$this->getName();
        echo "\033[32m{$commandName}\033[0m\t";
        echo "\033[32m(shortcut: {$this->getShortcut()})\033[0m\t";
        echo "\033[33mDescription:\033[0m {$this->getDescription()}\n";
    }

    protected function handleInfoOption($args): bool
    {
        if (in_array('--info', $args)) {
            $this->displayOptionInfo();
            return true;
        }
        return false;
    }

    protected function validateOptions(array $args): void
    {
        $commandOptions = $this->getOptions();
        $error = [];
        foreach ($commandOptions as $option) {
            if ($option['required'] && !isset($args[$option['name']])) {
                $error[] =  "Missing required option: {$option['name']}. Description: {$option['description']}";
            }

            if (isset($args[$option['name']]) && isset($option['validate'])) {
                $value = $args[$option['name']];
                $validation = $option['validate'];

                if ($validation === 'is_numeric' && !is_numeric($value)) {
                    $error[] = "Argument {$option['name']} must be numeric. Description: {$option['description']}";
                }

                if (strpos($validation, 'pattern:') === 0) {
                    $pattern = substr($validation, 8);
                    if (!preg_match($pattern, $value)) {
                        $error[] = "Argument {$option['name']} does not match the required pattern. Description: {$option['description']}";
                    }
                }
            }
        }
        if(!empty($error)) {
            $msg = implode("\n", $error);
            throw new \InvalidArgumentException($msg);
        }
    }

    protected function parseOptions(array $args): array
    {
        $commandArguments = $this->getOptions();
        $parsedArgs = [];
        for ($i = 0; $i < count($args); $i++) {
            $key = ltrim($args[$i], '-');
            foreach ($commandArguments as $argument) {
                if ($key === $argument['shortcut']) {
                    $key = $argument['name'];
                    break;
                }
            }
            if (array_key_exists($key, $commandArguments)) {
                $parsedArgs[$key] = $args[++$i];
            }
        }
        return $parsedArgs;
    }

    protected function setName(string $commandName): self
    {
        $this->commandName = $commandName;
        return $this;
    }

    protected function setShortcut(string $commandShortcut): self
    {
        $this->commandShortcut = $commandShortcut;
        return $this;
    }

    protected function setDescription(string $commandDescription): self
    {
        $this->commandDescription = $commandDescription;
        return $this;
    }

    protected function addOption(array $option): self
    {
        $this->commandOptions[$option['name']] = $option;
        return $this;
    }

    protected function getDescription(): string
    {
        return $this->commandDescription;
    }

    public function getName(): string
    {
        return $this->commandName;
    }

    public function getShortcut(): string
    {
        return $this->commandShortcut;
    }

    protected function getOptions(): array
    {
        return $this->commandOptions;
    }

}