<?php
declare(strict_types=1);

namespace App\Infrastructure\Symfony;

use App\Infrastructure\Symfony\ExpressionFunctionProviders\StringExpressionLanguageProvider;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;

class FeatureFlagExpressionLanguage extends BaseExpressionLanguage
{
    public function __construct(CacheItemPoolInterface $cache = null, array $providers = [])
    {
        // prepends the default provider to let users override it
        array_unshift(
            $providers,
            new StringExpressionLanguageProvider()
        );

        parent::__construct($cache, $providers);
    }
}
