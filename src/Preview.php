<?php

namespace MarcusGaius\Preview;

use Craft;
use craft\events\RegisterUrlRulesEvent;
use craft\web\Application as CraftWebApp;
use craft\web\UrlManager;
use MarcusGaius\Preview\Models\Settings;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Module;

class Preview extends Module implements BootstrapInterface
{
	public const ID = 'craft-preview';

	public static ?Settings $settings = null;

	public function __construct($id = self::ID, $parent = null, array $config = [])
	{
		parent::__construct($id, $parent, $config);
	}

	public function bootstrap($app): void
	{
		if (!$app instanceof CraftWebApp) {
			return;
		}

		$this->controllerNamespace = __NAMESPACE__ . '\\Controllers';

		static::setInstance($this);

		$this->configureModule();
		$this->registerComponents();

		$this->registerEventHandlers();
		Craft::info('Preview module bootstrapped', __METHOD__);
	}

	private function configureModule(): void
	{
		Craft::$app->setModule($this->id, $this);

		$config = Craft::$app->getConfig()->getConfigFromFile($this->id);
		self::$settings = new Settings($config);
	}

	private function registerComponents(): void
	{
	}

	private function registerEventHandlers(): void
	{
		Event::on(
			UrlManager::class,
			UrlManager::EVENT_REGISTER_SITE_URL_RULES,
			static function(RegisterUrlRulesEvent $event): void {
				$event->rules['<controller:(preview)>/<section:{slug}>/<slug:{slug}>'] = static::ID . '/<controller>';
			}
		);
	}
}
