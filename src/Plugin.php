<?php

namespace paxxion\craftcountryload;

use Craft;
use craft\base\Model;
use yii\base\Event;
use craft\base\Plugin as BasePlugin;
use craft\web\twig\variables\CraftVariable;

use paxxion\craftcountryload\models\Settings;
use paxxion\craftcountryload\services\GeoService;
use paxxion\craftcountryload\variables\ProxyVariable;

/**
 * Country Load plugin
 *
 * @method static Plugin getInstance()
 * @method Settings getSettings()
 * @author Paxxion <web@paxxion.com>
 * @copyright Paxxion
 * @license MIT
 * @property-read GeoService $geoService
 */
class Plugin extends BasePlugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = true;

    public static function config(): array
    {
        return [
            'components' => ['geoService' => GeoService::class],
        ];
    }

    public function init(): void
    {
        parent::init();

        $this->attachEventHandlers();

        Craft::$app->onInit(function() {
            // ...
        });
    }

    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('country-load/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    private function attachEventHandlers(): void
    {
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                $variable = $event->sender;
                $variable->set('countryLoad', ProxyVariable::class);
            }
        );
    }
}
