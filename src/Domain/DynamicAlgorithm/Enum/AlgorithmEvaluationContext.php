<?php
declare(strict_types=1);

namespace App\Domain\DynamicAlgorithm\Enum;

enum AlgorithmEvaluationContext: string
{
    case Question = 'question';
    case FeatureFlag = 'featureFlag';
}
