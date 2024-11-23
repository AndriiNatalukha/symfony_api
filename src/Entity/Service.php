<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $internet = null;

    #[ORM\Column(length: 255)]
    private ?string $tv = null;

    #[ORM\Column(length: 255)]
    private ?string $ip = null;

    // Геттери та сеттери
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInternet(): ?string
    {
        return $this->internet;
    }

    public function setInternet(string $internet): static
    {
        $this->internet = $internet;
        return $this;
    }

    public function getTv(): ?string
    {
        return $this->tv;
    }

    public function setTv(string $tv): static
    {
        $this->tv = $tv;
        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): static
    {
        $this->ip = $ip;
        return $this;
    }
}