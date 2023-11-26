<?php
declare(strict_types=1);

namespace App\Domain\DynamicAlgorithm;

use App\Domain\AlgorithmEvaluator\Exception\CastingException;

readonly class Result
{
    public function __construct(public mixed $evaluationResult)
    {
    }

    /**
     * @throws CastingException
     */
    public function asInt(): int
    {
        $filtered = filter_var($this->evaluationResult, FILTER_VALIDATE_INT);
        if ($filtered !== false) {
            return $filtered;
        }

        throw new CastingException(
            'Should return an integer, but the result of algorithm seems not to be one',
            $this->evaluationResult
        );
    }

    /**
     * Returns the parameter value converted to boolean.
     */
    public function asBoolean(): bool
    {
        $filtered = filter_var($this->evaluationResult, FILTER_VALIDATE_BOOL, FILTER_REQUIRE_SCALAR);
        if (is_bool($filtered)) {
            return $filtered;
        }

        throw new \App\Infrastructure\DynamicAlgorithm\Exception\CastingException(
            'Should return a boolean, but the result of algorithm seems not to be one',
            $this->evaluationResult
        );
    }
}
