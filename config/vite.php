<?php

use craft\helpers\App;

$port = 3000;
$host = Craft::$app->getRequest()->getIsConsoleRequest()
    ? App::env('PRIMARY_SITE_URL')
    : Craft::$app->getRequest()->getHostInfo();

return [
    /**
     * @var bool Should the dev server be used?
     */
    'useDevServer' =>
        App::env('ENVIRONMENT') === 'dev' ||
        App::env('CRAFT_ENVIRONMENT') === 'dev',

    /**
     * @var string File system path (or URL) to the Vite-built manifest.json
     */
    'manifestPath' => Craft::getAlias('@webroot') . '/dist/.vite/manifest.json',

    /**
     * @var string The public URL to the dev server (what appears in `<script src="">` tags
     */
    'devServerPublic' => preg_replace('/:\d+$/', '', $host) . ':3000',

    /**
     * @var string The public URL to use when not using the dev server
     */
    'serverPublic' => $host . '/dist/',

    /**
     * @var string The JavaScript entry from the manifest.json to inject on Twig error pages
     *              This can be a string or an array of strings
     */
    'errorEntry' => 'src/js/frontend/' . Craft::$app->sites->currentSite->handle . '.js',

    /**
     * @var string String to be appended to the cache key
     */
    'cacheKeySuffix' => '',

    /**
     * @var string The internal URL to the dev server, when accessed from the environment in which PHP is executing
     *              This can be the same as `$devServerPublic`, but may be different in containerized or VM setups.
     *              ONLY used if $checkDevServer = true
     */
    'devServerInternal' => 'http://localhost:3000',

    /**
     * @var bool Should we check for the presence of the dev server by pinging $devServerInternal to make sure it's running?
     */
    'checkDevServer' => true,

    /**
     * @var bool Whether the react-refresh-shim should be included
     */
    'includeReactRefreshShim' => false,

    /**
     * @var bool Whether the modulepreload-polyfill shim should be included
     */
    'includeModulePreloadShim' => true,

    /**
     * @var string File system path (or URL) to where the Critical CSS files are stored
     */
    'criticalPath' => '@webroot/dist/criticalcss',

    /**
     * @var string the suffix added to the name of the currently rendering template for the critical css file name
     */
    'criticalSuffix' => '_critical.min.css',
];