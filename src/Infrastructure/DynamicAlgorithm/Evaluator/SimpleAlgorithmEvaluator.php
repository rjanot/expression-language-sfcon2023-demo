<?php
declare(strict_types=1);

namespace App\Infrastructure\DynamicAlgorithm\Evaluator;

use App\Domain\DynamicAlgorithm\Enum\AlgorithmEvaluationContext;
use App\Domain\DynamicAlgorithm\Exception\EvaluationException;
use App\Domain\DynamicAlgorithm\Result;
use App\Infrastructure\Symfony\FeatureFlagExpressionLanguage;
use App\Infrastructure\Symfony\QuestionExpressionLanguage;
use Psr\Container\ContainerInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

readonly class SimpleAlgorithmEvaluator implements ServiceSubscriberInterface
{
    public function __construct(
        private ContainerInterface $locator,
        private Stopwatch $stopwatch
    ) {
    }

    public static function getSubscribedServices(): array
    {
        return [
            AlgorithmEvaluationContext::Question->value => QuestionExpressionLanguage::class,
            AlgorithmEvaluationContext::FeatureFlag->value => FeatureFlagExpressionLanguage::class,
        ];
    }

    /**
     * @throws EvaluationException
     */
    public function evaluate(AlgorithmEvaluationContext $context, string $algorithm, array $variables): Result
    {
        try {
            $this->stopwatch?->start($algorithm, 'expression-language');
            $result = $this->locator->get($context->value)->evaluate($algorithm, $variables);
            $this->stopwatch?->stop($algorithm);

            return new Result($result);
        } catch (\Exception $exception) {
            throw new EvaluationException("Can not evaluate", 0, $exception);
        }
    }
}
