<?php
/**
 * Cage plugin for Craft CMS 3.x
 *
 * An Age-Verification-Gate Plugin for Craft CMS
 *
 * @link      https://skayocrafts.github.io/Cage
 * @copyright Copyright (c) 2019 Skayo
 */

namespace skayocrafts\cage\models;

use Craft;
use craft\base\Model;
use skayocrafts\cage\Cage;

/**
 * Cage Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Skayo
 * @package   Cage
 * @since     1.0.0
 */
class Settings extends Model {
	// Public Properties
	// =========================================================================


	//
	// GENERAL
	//

	/**
	 * Plugin Name if someone wants to override it
	 *
	 * @var string A string
	 */
	public $pluginName = 'Cage';

	/**
	 * The default minimum age required to view content
	 *
	 * @var int An integer
	 */
	public $defaultAge = 18;

	/**
	 * The URL path where the age verification should happen and where the user get's redirected to
	 *
	 * @var string A string without any slashes ('/')
	 */
	public $ageVerificationPath = 'age-verification';

	/**
	 * The age verification method used to verify the users age. See the $ageVerificationMethods in src/Cage.php for all allowed
	 * verification methods.
	 *
	 * @var string An age verification method (must be one of the ones available)
	 */
	public $ageVerificationMethod = 'INPUT_AGE';

	/**
	 * Link to redirect to if user fails the age verification
	 *
	 * @var string An url
	 */
	public $failureRedirectLink = '';

	/**
	 * Whether to display a "Try Again" button on the failure page
	 *
	 * @var bool True or False
	 */
	public $showTryAgain = true;

	/**
	 * Whether to ignore logged in users and let them pass without age verification
	 *
	 * @var bool True or False
	 */
	public $ignoreLoggedIn = false;

	/**
	 * How long to remember the visitor's age (in days)
	 *
	 * @var string An integer
	 */
	public $daysRememberVisitor = 30;


	//
	// CONTENT
	//


	/**
	 * The "Message" or "Headline" of the age verification box
	 *
	 * @var string A string
	 */
	public $message = "Welcome to our website";

	/**
	 * The "Caption" or "Sub-Headline" of the age verification box
	 *
	 * @var string A string
	 */
	public $caption = "Please, verify your age to enter:";

	/**
	 * The text of the Day Field
	 *
	 * @var string A string
	 */
	public $dayPlaceholder = 'DD';

	/**
	 * The text of the Month Field
	 *
	 * @var string A string
	 */
	public $monthPlaceholder = 'MM';

	/**
	 * The text of the Year Field
	 *
	 * @var string A string
	 */
	public $yearPlaceholder = 'YYYY';

	/**
	 * The text of the Age Field
	 *
	 * @var string A string
	 */
	public $agePlaceholder = 'Age';

	/**
	 * The text of the "Enter" button
	 *
	 * @var string A string
	 */
	public $enterButtonText = 'Enter';

	/**
	 * The text of the "Leave" button
	 *
	 * @var string A string
	 */
	public $leaveButtonText = 'Leave';

	/**
	 * Some additional info that is displayed below the age verification form. (for terms of use, privacy policy, etc.)
	 *
	 * @var string A string
	 */
	public $additionalInfo = 'By entering this site you are agreeing to the <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.';

	/**
	 * The "Message" or "Headline" of the failure page
	 *
	 * @var string A string
	 */
	public $failureMessage = "You are not old enough to view this content!";

	/**
	 * The "Caption" or "Sub-Headline" of the failure page
	 *
	 * @var string A string
	 */
	public $failureCaption = "The minimum age required to view this page is <b>{age}</b>.";

	/**
	 * The text of the "Try Again" button
	 *
	 * @var string A string
	 */
	public $tryAgainButtonText = 'Try Again';


	//
	// APPEARANCE
	//


	/**
	 * The background color of the age verification page
	 *
	 * @var string An RGB color
	 */
	public $backgroundColor = "rgba(0, 0, 0, 0.6)";

	/**
	 * The background image of the age verification page
	 *
	 * @var array An array of IDs (actually always just one ID)
	 */
	public $backgroundImage = [];

	/**
	 * The shape of the age verification box and it's contents
	 *
	 * @var string Either "rounded" or "rectangle"
	 */
	public $verificationBoxShape = 'rounded';

	/**
	 * The Background Color of the age verification Box
	 *
	 * @var string An RGB color
	 */
	public $verificationBoxBackgroundColor = "rgb(255, 255, 255)";

	/**
	 * The image next to the age verification box
	 *
	 * @var array An array of image IDs (actually always just one ID)
	 */
	public $verificationBoxImage = [];

	/**
	 * The position of the image next to the age verification box
	 *
	 * @var string Either "right" or "left"
	 */
	public $verificationBoxImagePosition = 'right';

	/**
	 * The logo used in the age verification box
	 *
	 * @var array An array of image IDs (actually always just one ID)
	 */
	public $logo = [];

	/**
	 * Maximum Width of the logo in percent (%)
	 *
	 * @var int An integer between 0 and 100
	 */
	public $logoMaxWidth = 60;

	/**
	 * The alignment of the text and logo in the age verification box
	 *
	 * @var string Either "right", "center" or "left"
	 */
	public $textAlign = 'center';

	/**
	 * The text color used for all text in the age verification box
	 *
	 * @var string An RGB color
	 */
	public $textColor = 'rgb(0, 0, 0)';

	/**
	 * The background color of the enter button
	 *
	 * @var string An RGB color
	 */
	public $enterButtonBackgroundColor = 'rgb(221, 151, 0)';

	/**
	 * The text color of the enter button
	 *
	 * @var string An RGB color
	 */
	public $enterButtonTextColor = 'rgb(255, 255, 255)';

	/**
	 * The border color of the enter button
	 *
	 * @var string An RGB color
	 */
	public $enterButtonBorderColor = 'rgba(0, 0, 0, 0)';

	/**
	 * The background color of the leave button
	 *
	 * @var string An RGB color
	 */
	public $leaveButtonBackgroundColor = 'rgba(0, 0, 0, 0)';

	/**
	 * The text color of the leave button
	 *
	 * @var string An RGB color
	 */
	public $leaveButtonTextColor = 'rgb(0, 0, 0)';

	/**
	 * The border color of the leave button
	 *
	 * @var string An RGB color
	 */
	public $leaveButtonBorderColor = 'rgba(0, 0, 0, 0.4)';

	/**
	 * The background color of drop-downs/input fields
	 *
	 * @var string An RGB color
	 */
	public $formElementBackgroundColor = 'rgba(0, 0, 0, 0.05)';

	/**
	 * The color of the text entered/written in drop-downs/input fields
	 *
	 * @var string An RGB color
	 */
	public $formElementTextColor = 'rgb(0, 0, 0)';

	/**
	 * The border color of drop-downs/input fields
	 *
	 * @var string An RGB color
	 */
	public $formElementBorderColor = 'rgba(0, 0, 0, 0.4)';

	/**
	 * The color of the placeholder in drop-downs/input fields
	 *
	 * @var string An RGB color
	 */
	public $formElementPlaceholderColor = 'rgba(0, 0, 0, 0.4)';

	/**
	 * Font Size of the "Message" or "Headline" of the age verification box (in px)
	 *
	 * @var int An integer
	 */
	public $messageFontSize = 29;

	/**
	 * Font Size of the "Caption" or "Sub-Headline" of the age verification box (in px)
	 *
	 * @var int An integer
	 */
	public $captionFontSize = 16;

	/**
	 * Font Size of the additional info displayed below the age verification form (in px)
	 *
	 * @var int An integer
	 */
	public $additionalInfoFontSize = 12;

	/**
	 * Path to your CSS file, if you want to use some custom CSS rules on the age verification page
	 *
	 * @var string A path (aliases and environment variables are allowed here)
	 */
	public $customCssFile = '';

	// Public Methods
	// =========================================================================

	/**
	 * @inheritDoc
	 */
	public function init () {
		parent::init();
	}

	/**
	 * Returns the validation rules for attributes.
	 *
	 * Validation rules are used by [[validate()]] to check if attribute values are valid.
	 * Child classes may override this method to declare different validation rules.
	 *
	 * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
	 *
	 * @return array
	 */
	public function rules () {
		return [
			// Required fields
			[
				[
					'pluginName',
					'ageVerificationMethod',
					'defaultAge',
					'ageVerificationPath',
					'daysRememberVisitor',
					'backgroundColor',
					'verificationBoxShape',
					'verificationBoxBackgroundColor',
					'textAlign',
					'textColor',
					'enterButtonBackgroundColor',
					'enterButtonTextColor',
					'enterButtonBorderColor',
					'leaveButtonBackgroundColor',
					'leaveButtonTextColor',
					'leaveButtonBorderColor',
					'formElementBackgroundColor',
					'formElementTextColor',
					'formElementBorderColor',
					'formElementPlaceholderColor',
					'messageFontSize',
					'captionFontSize',
					'additionalInfoFontSize',
				],
				'required',
			],

			// Type Rules
			[
				[
					'pluginName',
					'ageVerificationMethod',
					'ageVerificationPath',
					'failureRedirectLink',
					'message',
					'caption',
					'dayPlaceholder',
					'monthPlaceholder',
					'yearPlaceholder',
					'agePlaceholder',
					'enterButtonText',
					'leaveButtonText',
					'additionalInfo',
					'failureMessage',
					'failureCaption',
					'tryAgainButtonText',
					'backgroundColor',
					'verificationBoxShape',
					'verificationBoxBackgroundColor',
					'verificationBoxImagePosition',
					'textAlign',
					'textColor',
					'enterButtonBackgroundColor',
					'enterButtonTextColor',
					'enterButtonBorderColor',
					'leaveButtonBackgroundColor',
					'leaveButtonTextColor',
					'leaveButtonBorderColor',
					'formElementBackgroundColor',
					'formElementTextColor',
					'formElementBorderColor',
					'formElementPlaceholderColor',
					'customCssFile',
				],
				'string',
			],
			[
				[
					'defaultAge',
					'daysRememberVisitor',
					'messageFontSize',
					'captionFontSize',
					'additionalInfoFontSize',
				],
				'integer',
				'min' => 0,
			],
			[['ignoreLoggedIn', 'showTryAgain'], 'boolean'],

			// Misc Rules
			['failureRedirectLink', 'url', 'defaultScheme' => 'http'],
			['ageVerificationMethod', 'in', 'range' => array_keys(Cage::$ageVerificationMethods), 'strict' => true],
			['verificationBoxShape', 'in', 'range' => ['rectangle', 'rounded'], 'strict' => true],
			[['verificationBoxImagePosition', 'textAlign'], 'in', 'range' => ['left', 'center', 'right'], 'strict' => true],
			[
				[
					'backgroundColor',
					'verificationBoxBackgroundColor',
					'textColor',
					'enterButtonBackgroundColor',
					'enterButtonTextColor',
					'enterButtonBorderColor',
					'leaveButtonBackgroundColor',
					'leaveButtonTextColor',
					'leaveButtonBorderColor',
					'formElementBackgroundColor',
					'formElementTextColor',
					'formElementBorderColor',
					'formElementPlaceholderColor',
				],
				'match',
				'pattern' => '/(#(?:[0-9a-f]{2}){2,4}|#[0-9a-f]{3}|(?:rgba?|hsla?)\((?:\d+%?(?:deg|rad|grad|turn)?(?:,|\s)+){2,3}[\s\/]*[\d\.]+%?\))/i',
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function attributeLabels () {
		return [
			'pluginName'            => Craft::t('cage', 'Plugin Name'),
			'ageVerificationMethod' => Craft::t('cage', 'Age Verification Method'),
			'defaultAge'            => Craft::t('cage', 'Default Age'),
			'ageVerificationPath'   => Craft::t('cage', 'Age Verification URL Path'),
			'failureRedirectLink'   => Craft::t('cage', 'Failure Redirect Link'),
			'showTryAgain'          => Craft::t('cage', 'Show "Try Again" button'),
			'daysRememberVisitor'   => Craft::t('cage', 'Days To Remember Visitor'),
			'ignoreLoggedIn'        => Craft::t('cage', 'Ignore Logged In'),

			'message'            => Craft::t('cage', 'Message'),
			'caption'            => Craft::t('cage', 'Caption'),
			'additionalInfo'     => Craft::t('cage', 'Additional Info'),
			'dayPlaceholder'     => Craft::t('cage', 'Day Field Placeholder'),
			'monthPlaceholder'   => Craft::t('cage', 'Month Field Placeholder'),
			'yearPlaceholder'    => Craft::t('cage', 'Year Field Placeholder'),
			'agePlaceholder'     => Craft::t('cage', 'Age Field Placeholder'),
			'enterButtonText'    => Craft::t('cage', 'Enter Button Text'),
			'leaveButtonText'    => Craft::t('cage', 'Leave Button Text'),
			'failureMessage'     => Craft::t('cage', 'Failure Page Message'),
			'failureCaption'     => Craft::t('cage', 'Failure Page Caption'),
			'tryAgainButtonText' => Craft::t('cage', '"Try Again" Button Text'),

			'backgroundColor'                => Craft::t('cage', 'Background Color'),
			'backgroundImage'                => Craft::t('cage', 'Background Image'),
			'verificationBoxShape'           => Craft::t('cage', 'Verification Box Shape'),
			'verificationBoxBackgroundColor' => Craft::t('cage', 'Verification Box Background Color'),
			'verificationBoxImage'           => Craft::t('cage', 'Verification Box Image'),
			'verificationBoxImagePosition'   => Craft::t('cage', 'Verification Box Image Position'),
			'logo'                           => Craft::t('cage', 'Logo'),
			'logoMaxWidth'                   => Craft::t('cage', 'Logo Max-Width'),
			'textAlign'                      => Craft::t('cage', 'Text Align'),
			'textColor'                      => Craft::t('cage', 'Text Color'),
			'enterButtonBackgroundColor'     => Craft::t('cage', 'Enter Button Background Color'),
			'enterButtonTextColor'           => Craft::t('cage', 'Enter Button Text Color'),
			'enterButtonBorderColor'         => Craft::t('cage', 'Enter Button Border Color'),
			'leaveButtonBackgroundColor'     => Craft::t('cage', 'Leave Button Background Color'),
			'leaveButtonBorderColor'         => Craft::t('cage', 'Leave Button Text Color'),
			'leaveButtonTextColor'           => Craft::t('cage', 'Leave Button Border Color'),
			'formElementBackgroundColor'     => Craft::t('cage', 'Form Element Background Color'),
			'formElementBorderColor'         => Craft::t('cage', 'Form Element Text Color'),
			'formElementTextColor'           => Craft::t('cage', 'Form Element Border Color'),
			'formElementPlaceholderColor'    => Craft::t('cage', 'Form Element Placeholder Color'),
			'messageFontSize'                => Craft::t('cage', 'Message Font Size'),
			'captionFontSize'                => Craft::t('cage', 'Caption Font Size'),
			'additionalInfoFontSize'         => Craft::t('cage', 'Additional Info Font Size'),
			'customCssFile'                  => Craft::t('cage', 'Custom CSS File'),
		];
	}
}
