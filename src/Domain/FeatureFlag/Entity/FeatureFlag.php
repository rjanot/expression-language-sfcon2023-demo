<?php declare(strict_types=1);
namespace App\Domain\FeatureFlag\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping as ORM;

#[Entity]
class FeatureFlag
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::BIGINT)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $code;

    #[ORM\Column(type: Types::STRING)]
    private ?string $conditionAlgorithm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getConditionAlgorithm(): ?string
    {
        return $this->conditionAlgorithm;
    }

    public function setConditionAlgorithm(string $conditionAlgorithm): self
    {
        $this->conditionAlgorithm = $conditionAlgorithm;

        return $this;
    }
}
