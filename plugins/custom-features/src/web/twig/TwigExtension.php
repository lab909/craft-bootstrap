<?php

namespace josdigital\craftcustomfeatures\web\twig;

use Craft;
use Faker\Factory;
use josdigital\craftcustomfeatures\services\LoremPicsumService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

/**
 * Twig extension
 */
class TwigExtension extends AbstractExtension implements GlobalsInterface
{
    public function getGlobals(): array
    {
        return [
            'lorempicsum' => new LoremPicsumService,
            'faker' => Factory::create(),
        ];
    }

}
