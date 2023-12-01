<?php
declare(strict_types=1);

namespace App\Infrastructure\DynamicAlgorithm\Evaluator;

use App\Domain\DynamicAlgorithm\Exception\EvaluationException;
use App\Domain\DynamicAlgorithm\Result;
use App\Infrastructure\Symfony\ExpressionLanguage;
use Symfony\Component\Stopwatch\Stopwatch;

readonly class SimpleAlgorithmEvaluator
{
    public function __construct(private ExpressionLanguage $expressionLanguage, private Stopwatch $stopwatch)
    {
    }

    /**
     * @throws EvaluationException
     */
    public function evaluate(string $algorithm, array $context): Result
    {
        try {
            $this->stopwatch?->start($algorithm, 'expression-language');
            $result = $this->expressionLanguage->evaluate($algorithm, $context);
            $this->stopwatch?->stop($algorithm);

            return new Result($result);
        } catch (\Exception $exception) {
            throw new EvaluationException("Can not evaluate", 0, $exception);
        }
    }
}
