<?php
/**
 * Cage plugin for Craft CMS 3.x
 *
 * An Age-Verification-Gate Plugin for Craft CMS
 *
 * @link      https://skayocrafts.github.io/Cage
 * @copyright Copyright (c) 2019 Skayo
 */

namespace skayocrafts\cage\services;

use Craft;
use craft\base\Component;
use craft\helpers\UrlHelper;
use skayocrafts\cage\Cage;

/**
 * AgeVerification Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Skayo
 * @package   Cage
 * @since     1.0.0
 */
class AgeVerificationService extends Component {

	// Public Methods
	// =========================================================================

	/**
	 * @param int|null $age
	 *
	 * @throws \craft\errors\MissingComponentException
	 * @throws \yii\base\Exception
	 * @throws \yii\base\InvalidConfigException
	 */
	public function requireAge ($age = null) {
		Craft::info(
			Craft::t(
				'cage',
				'require Age {age}',
				['age' => $age]
			),
			__METHOD__
		);

		$request = Craft::$app->getRequest();
		$response = Craft::$app->getResponse();
		$session = Craft::$app->getSession();
		$settings = Cage::$settings;

		if ($age === null)
			$age = $settings->defaultAge;

		// Only do this for real site requests
		if ($request->getIsConsoleRequest() || $request->getIsLivePreview()) {
			return;
		}

		// Check logged in setting
		if ($settings->ignoreLoggedIn && Craft::$app->getUser()
		                                            ->getIdentity() !== null) {
			return;
		}

		// Check if already did age verification and if stored age is high enough
		$ageCookieValue = $request->getCookies()
		                     ->getValue('cage_age');
		if ($ageCookieValue !== null && $ageCookieValue >= $age) {
			return;
		}

		$session->set('cage_requiredAge', $age);

		$response->redirect(UrlHelper::siteUrl('/' . $settings->ageVerificationPath, ['from' => urlencode($request->getUrl())]));
		Craft::$app->end();
	}
}