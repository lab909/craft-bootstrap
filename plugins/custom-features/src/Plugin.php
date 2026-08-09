<?php

namespace josdigital\craftcustomfeatures;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\web\twig\variables\CraftVariable;
use josdigital\craftcustomfeatures\variables\Variables;
use josdigital\craftcustomfeatures\web\twig\TwigExtension;
use yii\base\Event;

/**
 * Custom Features plugin
 *
 * @method static Plugin getInstance()
 * @author JosDigital <webmaster@giuseppegallo.com>
 * @copyright JosDigital
 * @license MIT
 */
class Plugin extends BasePlugin
{
    public string $schemaVersion = '1.0.0';

    public static function config(): array
    {
        return [
            'components' => [
                // Define component configs here...
            ],
        ];
    }

    public function init(): void
    {
        parent::init();

        $this->attachEventHandlers();

        // Any code that creates an element query or loads Twig should be deferred until
        // after Craft is fully initialized, to avoid conflicts with other plugins/modules
        Craft::$app->onInit(function() {
            // ...
        });
        Craft::$app->view->registerTwigExtension(new TwigExtension());
    }

    private function attachEventHandlers(): void
    {
    }
}
