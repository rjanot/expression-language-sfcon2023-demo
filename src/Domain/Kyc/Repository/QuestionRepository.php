<?php
declare(strict_types=1);

namespace App\Domain\Kyc\Repository;

use App\Domain\DynamicAlgorithm\Enum\AlgorithmEvaluationContext;
use App\Domain\Kyc\Entity\Question;
use App\Domain\User\Entity\User;
use App\Infrastructure\DynamicAlgorithm\Evaluator\SimpleAlgorithmEvaluator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly SimpleAlgorithmEvaluator $algorithmEvaluator,
        private readonly SerializerInterface $normalizer
    )
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @return Question[]
     */
    public function findQuestionsForUser(User $user): array
    {
        $toReturn = [];
        foreach($this->findAll() as $question) {
            if ($this->isRelevant($question, $user)) {
                $toReturn[] = $question;
            }
        }
        return $toReturn;
    }

    public function isRelevant(Question $question, User $user): bool
    {
        return $this->algorithmEvaluator->evaluate(
            AlgorithmEvaluationContext::Question,
            $question->getConditionAlgorithm(),
            [
                'question' => $this->normalizer->normalize($question),
                'user' => $this->normalizer->normalize($user),
            ]
        )->asBoolean();
    }
}
