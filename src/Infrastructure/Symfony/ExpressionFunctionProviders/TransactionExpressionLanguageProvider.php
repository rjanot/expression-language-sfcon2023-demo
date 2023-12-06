<?php
declare(strict_types=1);

namespace App\Infrastructure\Symfony\ExpressionFunctionProviders;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class TransactionExpressionLanguageProvider
    implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
    {
        return [
            new ExpressionFunction(
                'getCumulatedInvestment',
                static function() {
                    return '';
                },
                static function ($arguments, $user) {
                    return rand(850000, 1200000);
                }
            )
        ];
    }
}
