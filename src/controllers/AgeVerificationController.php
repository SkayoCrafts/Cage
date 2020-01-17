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
use craft\web\View;
use DateTime;
use skayocrafts\cage\Cage;
use yii\web\Cookie;

/**
 * Age Verification Controller
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
 *
 *
 */
class AgeVerificationController extends Controller {

	// Protected Properties
	// =========================================================================

	/**
	 * @inheritDoc
	 */
	protected $allowAnonymous = true;

	// Public Methods
	// =========================================================================

	/**
	 * @return string
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @throws \craft\errors\MissingComponentException
	 * @throws \yii\base\Exception
	 * @throws \yii\web\BadRequestHttpException
	 * @throws \Exception
	 */
	public function actionIndex () {
		$this->requireSiteRequest();

		$variables = [];

		$settings = Cage::$settings;
		$request = Craft::$app->getRequest();
		$response = Craft::$app->getResponse();
		$session = Craft::$app->getSession();


		$referer = urldecode($request->getQueryParam('from', '/'));

		// Check enabled setting
		if (!$settings->enabled) {
			return $response->redirect($referer);
		}

		// Redirect if required age is unset
		if (!$session->has('cage_requiredAge')) {
			return $response->redirect($referer);
		}

		$requiredAge = $session->get('cage_requiredAge', $settings->defaultAge);

		// Check logged in setting
		if ($settings->ignoreLoggedIn && Craft::$app->getUser()
		                                            ->getIdentity() !== null) {
			return $response->redirect($referer);
		}

		// Check if already did age verification and if stored age is high enough
		$ageCookieValue = $request->getCookies()
		                          ->getValue('cage_age');
		if ($ageCookieValue !== null && $ageCookieValue >= $requiredAge) {
			return $response->redirect($referer);
		}

		if ($request->getIsPost()) {
			$fail = true;
			$userAge = null;
			$errors = [];

			switch ($settings->ageVerificationMethod) {
				case 'BUTTONS_ENTER_LEAVE':
				case 'BUTTONS_LEAVE_ENTER':
				case 'BUTTON_ENTER':
				case 'INPUT_AGE':
					$age = $request->getBodyParam('age');

					$ageValid = true;

					if (empty($age)) {
						$errors[] = Craft::t('cage', 'Age is required!');
						$ageValid = false;
					} else if (!preg_match('/^\d{1,3}$/', $age)) {
						$errors[] = Craft::t('cage', 'Age is invalid!');
						$ageValid = false;
					}

					if ($ageValid && $age >= $requiredAge) {
						$userAge = $age;
						$fail = false;
					}
					break;

				case 'INPUT_YEAR':
				case 'DROPDOWN_YEAR':
					$year = $request->getBodyParam('year');

					$yearValid = true;

					if (empty($year)) {
						$errors[] = Craft::t('cage', 'Year is required!');
						$yearValid = false;
					} else if (!preg_match('/^\d{4}$/', $year) || $year > date('Y')) {
						$errors[] = Craft::t('cage', 'Year is invalid!');
						$yearValid = false;
					}

					if ($yearValid) {
						$birthDate = new DateTime($year . '-01-01');
						$today = new DateTime('today');
						$age = $birthDate->diff($today)->y;

						if ($age >= $requiredAge) {
							$userAge = $age;
							$fail = false;
						}
					}
					break;

				case 'DROPDOWNS_DAY':
				case 'DROPDOWNS_MONTH':
				case 'INPUTS_DAY':
				case 'INPUTS_MONTH':
					$day = $request->getBodyParam('day');
					$month = $request->getBodyParam('month');
					$year = $request->getBodyParam('year');

					$dateValid = true;

					if (empty($day)) {
						$errors[] = Craft::t('cage', 'Day is required!');
						$dateValid = false;
					} else if (!preg_match('/^\d{1,2}$/', $day) || $day > 31 || $day < 1) {
						$errors[] = Craft::t('cage', 'Day is invalid!');
						$dateValid = false;
					}

					if (empty($month)) {
						$errors[] = Craft::t('cage', 'Month is required!');
						$dateValid = false;
					} else if (!preg_match('/^\d{1,2}$/', $month) || $month > 12 || $month < 1) {
						$errors[] = Craft::t('cage', 'Month is invalid!');
						$dateValid = false;
					}

					if (empty($year)) {
						$errors[] = Craft::t('cage', 'Year is required!');
						$dateValid = false;
					} else if (!preg_match('/^\d{4}$/', $year) || $year > date('Y')) {
						$errors[] = Craft::t('cage', 'Year is invalid!');
						$dateValid = false;
					}

					if ($dateValid) {
						$birthDate = new DateTime($year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day));
						$today = new DateTime('today');
						$age = $birthDate->diff($today)->y;

						if ($age >= $requiredAge) {
							$userAge = $age;
							$fail = false;
						}
					}
					break;
			}

			if (empty($errors) && !$fail) {
				// Redirect to the referrer
				$ageCookie = new Cookie();
				$ageCookie->name = 'cage_age';
				$ageCookie->value = $userAge;

				if ($settings->daysRememberVisitor != 0)
					$ageCookie->expire = strtotime("+{$settings->daysRememberVisitor} days");

				$response->getCookies()
				         ->add($ageCookie);

				return $response->redirect($referer);
			}

			if (empty($errors) && $fail) {
				// Either redirect to specified url or to failed page
				if (!empty($settings->failureRedirectLink)) {
					return $response->redirect($settings->failureRedirectLink);
				} else {
					return $response->redirect(UrlHelper::siteUrl('/' . $settings->ageVerificationPath . '/fail', ['from' => urlencode($referer)]));
				}
			}

			$variables['errors'] = $errors;
		}

		$variables['settings'] = $settings;
		$variables['requiredAge'] = $requiredAge;
		$variables['failureRedirectLink'] = !empty($settings->failureRedirectLink) ?
			$settings->failureRedirectLink : UrlHelper::siteUrl('/' . $settings->ageVerificationPath .'/fail', ['from' => urlencode($referer)]);
		$variables['submitAction'] = UrlHelper::siteUrl('/' . $settings->ageVerificationPath, ['from' => urlencode($referer)]);
		$variables['customCssFile'] = $this->getCustomCssFileUrl();

		return $this->renderFrontendTemplate('cage/age-verification/index', $variables);
	}

	/**
	 * @return string
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @throws \craft\errors\MissingComponentException
	 * @throws \yii\base\Exception
	 * @throws \yii\web\BadRequestHttpException
	 */
	public function actionFail () {
		$this->requireSiteRequest();

		$variables = [];

		$settings = Cage::$settings;
		$request = Craft::$app->getRequest();

		$referer = $request->getQueryParam('from', '/');

		$variables['settings'] = $settings;
		$variables['requiredAge'] = Craft::$app->getSession()
		                                       ->get('cage_requiredAge', $settings->defaultAge);
		$variables['tryAgainLink'] = UrlHelper::siteUrl('/' . $settings->ageVerificationPath, ['from' => $referer]);
		$variables['customCssFile'] = $this->getCustomCssFileUrl();

		return $this->renderFrontendTemplate('cage/age-verification/fail', $variables);
	}

	// Private Methods
	// =========================================================================

	/**
	 * @param string $template
	 * @param array  $params
	 *
	 * @return string
	 * @throws \Twig\Error\LoaderError
	 * @throws \Twig\Error\RuntimeError
	 * @throws \Twig\Error\SyntaxError
	 * @throws \yii\base\Exception
	 */
	private function renderFrontendTemplate (string $template, array $params = []) : string {
		$view = $this->getView();

		$oldMode = $view->getTemplateMode();

		$view->setTemplateMode(View::TEMPLATE_MODE_CP);

		$rendered = $view->renderTemplate($template, $params);

		$view->setTemplateMode($oldMode);

		return $rendered;
	}

	/**
	 * @return string
	 */
	private function getCustomCssFileUrl() {
		$file = trim(Craft::parseEnv(Cage::$settings->customCssFile));

		if (!empty($file)) {
			// Cache buster
			if ($hash = @sha1_file($file)) {
				$file .= '?e=' . $hash;
			}

			// Return CSS file
			return $file;
		}

		return '';
	}
}
