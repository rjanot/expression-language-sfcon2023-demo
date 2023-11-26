<?php declare(strict_types=1);
namespace App\Domain\Kyc\Entity;

use App\Domain\Kyc\Repository\QuestionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping as ORM;

#[Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::BIGINT)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $question;

    #[ORM\Column(type: Types::STRING)]
    private ?string $conditionAlgorithm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): self
    {
        $this->question = $question;

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
