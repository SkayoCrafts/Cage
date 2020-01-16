<?php
/**
 * Cage plugin for Craft CMS 3.x
 *
 * An Age-Verification-Gate Plugin for Craft CMS
 *
 * @link      https://skayocrafts.github.io/Cage
 * @copyright Copyright (c) 2019 Skayo
 */

namespace skayocrafts\cage;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\UrlHelper;
use craft\web\UrlManager;
use skayocrafts\cage\models\Settings;
use skayocrafts\cage\services\AgeVerificationService;
use skayocrafts\cage\twigextensions\CageTwigExtension;
use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Skayo
 * @package   Cage
 * @since     1.0.0
 *
 * @property void      $settingsResponse
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class Cage extends Plugin {

	// Static Properties
	// =========================================================================

	/**
	 * Static property that is an instance of this plugin class so that it can be accessed via
	 * Cage::$plugin
	 *
	 * @var Cage
	 */
	public static $plugin;

	/**
	 * An array with all the possible age verification methods
	 * Key is a unique identifier
	 * Value is an array with some info
	 *
	 * @var array
	 */
	public static $ageVerificationMethods = [
		['optgroup' => 'Buttons'],
		'BUTTONS_ENTER_LEAVE' => 'Enter/Leave Buttons (Order: Enter | Leave)',
		'BUTTONS_LEAVE_ENTER' => 'Enter/Leave Buttons (Order: Leave | Enter)',
		'BUTTON_ENTER'        => 'Enter Button',
		['optgroup' => 'Drop-Downs'],
		'DROPDOWNS_DAY'       => 'Date of Birth Drop-Downs (Order: DD | MM | YYYY)',
		'DROPDOWNS_MONTH'     => 'Date of Birth Drop-Downs (Order: MM | DD | YYYY)',
		'DROPDOWN_YEAR'       => 'Year Drop-Down',
		['optgroup' => 'Input Fields'],
		'INPUTS_DAY'          => 'Date of Birth Input Fields (Order: DD | MM | YYYY)',
		'INPUTS_MONTH'        => 'Date of Birth Input Fields (Order: MM | DD | YYYY)',
		'INPUT_YEAR'          => 'Year Input Field',
		'INPUT_AGE'           => 'Age Input Field',
	];

	/**
	 * Static property that is an instance of the settings model so that it can be accessed via
	 * Cage::$settings
	 *
	 * @var Settings
	 */
	public static $settings;

	// Public Properties
	// =========================================================================

	/**
	 * @inheritDoc
	 */
	public $hasCpSettings = true;

	/**
	 * To execute your plugin’s migrations, you’ll need to increase its schema version.
	 *
	 * @var string
	 */
	public $schemaVersion = '1.0.0';

	// Public Methods
	// =========================================================================

	/**
	 * Set our $plugin static property to this class so that it can be accessed via
	 * Cage::$plugin
	 *
	 * Called after the plugin class is instantiated; do any one-time initialization
	 * here such as hooks and events.
	 *
	 * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
	 * you do not need to load it in your init() method.
	 *
	 */
	public function init () {
		parent::init();

		self::$plugin = $this;

		self::$settings = $this->getSettings();

		$this->name = self::$settings->pluginName;

		Craft::setAlias('@cage', $this->getBasePath());

		$this->setComponents([
			'ageVerification' => AgeVerificationService::class,
		]);

		// Add in our Twig extensions
		Craft::$app->getView()
		           ->registerTwigExtension(new CageTwigExtension());

		$this->registerEventListeners();

		Craft::info(
			Craft::t(
				'cage',
				'{name} plugin loaded',
				['name' => $this->name]
			),
			__METHOD__
		);
	}

	// Protected Methods
	// =========================================================================

	protected function registerEventListeners () {
		Event::on(
			UrlManager::class,
			UrlManager::EVENT_REGISTER_CP_URL_RULES,
			function (RegisterUrlRulesEvent $event) {
				Craft::debug(
					'UrlManager::EVENT_REGISTER_CP_URL_RULES',
					__METHOD__
				);

				$event->rules['cage/settings'] = 'cage/settings/edit-settings';
				$event->rules['cage/settings/<settingsSection:\w*>'] = 'cage/settings/edit-settings';
			}
		);

		Event::on(
			UrlManager::class,
			UrlManager::EVENT_REGISTER_SITE_URL_RULES,
			function (RegisterUrlRulesEvent $event) {
				Craft::debug(
					'UrlManager::EVENT_REGISTER_SITE_URL_RULES',
					__METHOD__
				);

				$event->rules[self::$settings->ageVerificationPath] = [
					'route' => 'cage/age-verification/index',
				];

				$event->rules[self::$settings->ageVerificationPath . '/fail'] = [
					'route' => 'cage/age-verification/fail',
				];
			}
		);
	}

	/**
	 * Creates and returns the model used to store the plugin’s settings.
	 *
	 * @return \craft\base\Model|null
	 */
	protected function createSettingsModel () {
		return new Settings();
	}

	/**
	 * @inheritDoc
	 */
	public function getSettingsResponse () {
		// Just redirect to the plugin settings page
		Craft::$app->getResponse()
		           ->redirect(UrlHelper::cpUrl('cage/settings'));
	}
}
