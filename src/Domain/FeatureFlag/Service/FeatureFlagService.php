<?php
declare(strict_types=1);

namespace App\Domain\FeatureFlag\Service;

use App\Domain\DynamicAlgorithm\Enum\AlgorithmEvaluationContext;
use App\Domain\FeatureFlag\Entity\FeatureFlag;
use App\Domain\User\Entity\User;
use App\Infrastructure\DynamicAlgorithm\Evaluator\SimpleAlgorithmEvaluator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class FeatureFlagService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SimpleAlgorithmEvaluator $algorithmEvaluator,
        private SerializerInterface $normalizer
    ) {
    }

    public function isEnabledForUser(string $code, ?User $user): ?bool
    {
        /** @var FeatureFlag $featureFlag */
        $featureFlag = $this->entityManager->getRepository(FeatureFlag::class)->findOneBy(['code' => $code]);
        if (null === $featureFlag) {
            return null;
        }

        return $this->algorithmEvaluator->evaluate(
            AlgorithmEvaluationContext::FeatureFlag,
            $featureFlag->getConditionAlgorithm(),
            ['user' => $this->normalizer->normalize($user)]
        )->asBoolean();
    }
}
