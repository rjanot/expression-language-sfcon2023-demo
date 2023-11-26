<?php
declare(strict_types=1);
namespace App\Domain\User\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[Entity]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::BIGINT)]
    private ?int $id;
    #[ORM\Column(type: Types::STRING)]
    private ?string $email;
    #[ORM\Column(type: Types::STRING)]
    private ?string $password;
    #[ORM\Column(type: Types::STRING)]
    private ?string $gender;
    #[ORM\Column(type: Types::STRING)]
    private ?string $type;
    #[ORM\Column(type: Types::STRING)]
    private ?string $country;
    #[ORM\Column(type: Types::STRING)]
    private ?string $iban;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): User
    {
        $this->gender = $gender;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): User
    {
        $this->type = $type;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): User
    {
        $this->country = $country;
        return $this;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(?string $iban): User
    {
        $this->iban = $iban;
        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void {
        return;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
