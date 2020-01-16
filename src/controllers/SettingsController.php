<?php
/**
 * Cage plugin for Craft CMS 3.x
 *
 * An Age-Verification-Gate Plugin for Craft CMS
 *
 * @link      https://skayocrafts.github.io/Cage
 * @copyright Copyright (c) 2019 Skayo
 */

namespace skayocrafts\cage\controllers;

use Craft;
use craft\helpers\UrlHelper;
use craft\web\Controller;
use skayocrafts\cage\Cage;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Settings Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    Skayo
 * @package   Cage
 * @since     1.0.0
 */
class SettingsController extends Controller {

	// Constants
	// =========================================================================

	public const SETTINGS_SECTIONS = [
		'general'    => 'General',
		'content'    => 'Content',
		'appearance' => 'Appearance',
	];

	// Public Methods
	// =========================================================================

	/**
	 * View and edit the plugin settings
	 * actions/cage/settings/edit-settings
	 *
	 * @param string $settingsSection
	 *
	 * @return Response
	 * @throws \yii\web\NotFoundHttpException
	 * @throws \yii\web\ForbiddenHttpException
	 * @throws \yii\web\BadRequestHttpException
	 */
	public function actionEditSettings (string $settingsSection = 'general') : Response {
		$this->requireAdmin(false);
		$this->requireCpRequest();

		$variables = [];

		if (!array_key_exists($settingsSection, self::SETTINGS_SECTIONS))
			throw new NotFoundHttpException();

		$settings = Cage::$settings;

		$pluginName = $settings->pluginName;
		$templateTitle = Craft::t('app', 'Settings');

		/* document stuff */
		$variables['docTitle'] = "{$pluginName} - {$templateTitle}";
		$variables['title'] = $pluginName;
		$variables['pluginName'] = $pluginName;
		$variables['fullPageForm'] = true;
		$variables['settings'] = $settings;
		$variables['crumbs'] = [
			[
				'label' => Craft::t('app', 'Settings'),
				'url'   => UrlHelper::cpUrl('settings'),
			],
			[
				'label' => Craft::t('app', 'Plugins'),
				'url'   => UrlHelper::cpUrl('settings/plugins'),
			],
		];
		/*  */


		/* tabs */
		$tabs = [];
		foreach (self::SETTINGS_SECTIONS as $section => $sectionLabel) {
			$tabs[$section] = [
				'label' => $sectionLabel,
				'url'   => UrlHelper::cpUrl("cage/settings/$section"),
			];
		}
		$variables['tabs'] = $tabs;
		$variables['selectedTab'] = $settingsSection;
		/*  */


		/* ageVerificationMethods */
		$variables['ageVerificationMethods'] = Cage::$ageVerificationMethods;
		/*  */


		/* overrides */
		// Get and pre-validate the settings
		$settings->validate();

		// Get the settings that are being defined by the config file
		$overrides = Craft::$app->getConfig()
		                        ->getConfigFromFile(strtolower(Cage::$plugin->handle));

		$variables['overrides'] = array_keys($overrides);
		/*  */

		return $this->renderTemplate("cage/settings/$settingsSection", $variables);
	}

	/**
	 * Save the plugin settings changes
	 * actions/cage/settings/save-settings
	 *
	 * @return null|Response
	 * @throws \yii\web\BadRequestHttpException
	 * @throws \craft\errors\MissingComponentException
	 * @throws \yii\web\ForbiddenHttpException
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionSaveSettings () {
		$this->requireAdmin(true);
		$this->requirePostRequest();
		$this->requireCpRequest();

		$settings = Craft::$app->getRequest()
		                       ->getBodyParam('settings', []);
		$plugin = Craft::$app->getPlugins()
		                     ->getPlugin('cage');

		if ($plugin === null) {
			throw new NotFoundHttpException('Plugin not found');
		}

		if (!Craft::$app->getPlugins()
		                ->savePluginSettings($plugin, $settings)) {
			Craft::$app->getSession()
			           ->setError(Craft::t('app', 'Couldn’t save plugin settings.'));

			// Send the plugin back to the template
			Craft::$app->getUrlManager()
			           ->setRouteParams([
				           'plugin' => $plugin,
			           ]);

			return null;
		}

		Craft::$app->getSession()
		           ->setNotice(Craft::t('app', 'Plugin settings saved.'));

		return $this->redirectToPostedUrl();
	}
}
