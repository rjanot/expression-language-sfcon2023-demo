<?php
declare(strict_types=1);

namespace App\Infrastructure\DynamicAlgorithm\Evaluator;

use App\Domain\DynamicAlgorithm\Exception\EvaluationException;
use App\Domain\DynamicAlgorithm\Result;
use App\Infrastructure\Symfony\ExpressionLanguage;

readonly class SimpleAlgorithmEvaluator
{
    public function __construct(private ExpressionLanguage $expressionLanguage)
    {
    }

    /**
     * @throws EvaluationException
     */
    public function evaluate(string $algorithm, array $context): Result
    {
        try {
            return new Result(
                $this->expressionLanguage->evaluate($algorithm, $context)
            );
        } catch (\Exception $exception) {
            throw new EvaluationException("Can not evaluate", 0, $exception);
        }
    }
}
