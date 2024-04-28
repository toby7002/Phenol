<?php

namespace toby7002\Phenol;

use AttachableLogger;
use pocketmine\utils\TextFormat;

class Logger
{
    public function __construct(private readonly AttachableLogger $logger) {}

    public function success(string $message): void
    {
        $this->logger->info(TextFormat::GREEN . "[✔] $message");
    }

    public function error(string $message): void
    {
        $this->logger->info(TextFormat::RED . "[✗] $message");
    }

    public function debug(string $message): void
    {
        $this->logger->info(TextFormat::GRAY . "[!] $message");
    }

    public function warning(string $message): void
    {
        $this->logger->info(TextFormat::YELLOW . "[?] $message");
    }
}
