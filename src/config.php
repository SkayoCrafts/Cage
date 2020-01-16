<?php
/**
 * Cage plugin for Craft CMS 3.x
 *
 * An Age-Verification-Gate Plugin for Craft CMS
 *
 * @link      https://skayocrafts.github.io/Cage
 * @copyright Copyright (c) 2019 Skayo
 */

/**
 * Cage config.php
 *
 * This file exists only as a template for the Cage settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'cage.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [
	//
	// GENERAL
	//

	/**
	 * Plugin Name if someone wants to override it
	 *
	 * @var string A string
	 */
	'pluginName' => 'Cage',

	/**
	 * The default minimum age required to view content
	 *
	 * @var int An integer
	 */
	'defaultAge' => 18,

	/**
	 * The URL path where the age verification should happen and where the user get's redirected to
	 *
	 * @var string A string without any slashes ('/')
	 */
	'ageVerificationPath' => 'age-verification',

	/**
	 * The age verification method used to verify the users age. See the $ageVerificationMethods in src/Cage.php for all allowed
	 * verification methods.
	 *
	 * @var string An age verification method (must be one of the ones available)
	 */
	'ageVerificationMethod' => 'INPUT_AGE',

	/**
	 * Link to redirect to if user fails the age verification
	 *
	 * @var string An url
	 */
	'failureRedirectLink' => '',

	/**
	 * Whether to display a "Try Again" button on the failure page
	 *
	 * @var bool True or False
	 */
	'showTryAgain' => true,

	/**
	 * Whether to ignore logged in users and let them pass without age verification
	 *
	 * @var bool True or False
	 */
	'ignoreLoggedIn' => false,

	/**
	 * How long to remember the visitor's age (in days)
	 *
	 * @var string An integer
	 */
	'daysRememberVisitor' => 30,


	//
	// CONTENT
	//


	/**
	 * The "Message" or "Headline" of the age verification box
	 *
	 * @var string A string
	 */
	'message' => "Welcome to our website",

	/**
	 * The "Caption" or "Sub-Headline" of the age verification box
	 *
	 * @var string A string
	 */
	'caption' => "Please, verify your age to enter:",

	/**
	 * The text of the Day Field
	 *
	 * @var string A string
	 */
	'dayPlaceholder' => 'DD',

	/**
	 * The text of the Month Field
	 *
	 * @var string A string
	 */
	'monthPlaceholder' => 'MM',

	/**
	 * The text of the Year Field
	 *
	 * @var string A string
	 */
	'yearPlaceholder' => 'YYYY',

	/**
	 * The text of the Age Field
	 *
	 * @var string A string
	 */
	'agePlaceholder' => 'Age',

	/**
	 * The text of the "Enter" button
	 *
	 * @var string A string
	 */
	'enterButtonText' => 'Enter',

	/**
	 * The text of the "Leave" button
	 *
	 * @var string A string
	 */
	'leaveButtonText' => 'Leave',

	/**
	 * Some additional info that is displayed below the age verification form. (for terms of use, privacy policy, etc.)
	 *
	 * @var string A string
	 */
	'additionalInfo' => 'By entering this site you are agreeing to the <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.',

	/**
	 * The "Message" or "Headline" of the failure page
	 *
	 * @var string A string
	 */
	'failureMessage' => "You are not old enough to view this content!",

	/**
	 * The "Caption" or "Sub-Headline" of the failure page
	 *
	 * @var string A string
	 */
	'failureCaption' => "The minimum age required to view this page is <b>{age}</b>.",

	/**
	 * The text of the "Try Again" button
	 *
	 * @var string A string
	 */
	'tryAgainButtonText' => 'Try Again',


	//
	// APPEARANCE
	//


	/**
	 * The background color of the age verification page
	 *
	 * @var string An RGB color
	 */
	'backgroundColor' => "rgba(0, 0, 0, 0.6)",

	/**
	 * The background image of the age verification page
	 *
	 * @var array An array of IDs (actually always just one ID)
	 */
	'backgroundImage' => [],

	/**
	 * The shape of the age verification box and it's contents
	 *
	 * @var string Either "rounded" or "rectangle"
	 */
	'verificationBoxShape' => 'rounded',

	/**
	 * The Background Color of the age verification Box
	 *
	 * @var string An RGB color
	 */
	'verificationBoxBackgroundColor' => "rgb(255, 255, 255)",

	/**
	 * The image next to the age verification box
	 *
	 * @var array An array of image IDs (actually always just one ID)
	 */
	'verificationBoxImage' => [],

	/**
	 * The position of the image next to the age verification box
	 *
	 * @var string Either "right" or "left"
	 */
	'verificationBoxImagePosition' => 'right',

	/**
	 * The logo used in the age verification box
	 *
	 * @var array An array of image IDs (actually always just one ID)
	 */
	'logo' => [],

	/**
	 * Maximum Width of the logo in percent (%)
	 *
	 * @var int An integer between 0 and 100
	 */
	'logoMaxWidth' => 60,

	/**
	 * The alignment of the text and logo in the age verification box
	 *
	 * @var string Either "right", "center" or "left"
	 */
	'textAlign' => 'center',

	/**
	 * The text color used for all text in the age verification box
	 *
	 * @var string An RGB color
	 */
	'textColor' => 'rgb(0, 0, 0)',

	/**
	 * The background color of the enter button
	 *
	 * @var string An RGB color
	 */
	'enterButtonBackgroundColor' => 'rgb(221, 151, 0)',

	/**
	 * The text color of the enter button
	 *
	 * @var string An RGB color
	 */
	'enterButtonTextColor' => 'rgb(255, 255, 255)',

	/**
	 * The border color of the enter button
	 *
	 * @var string An RGB color
	 */
	'enterButtonBorderColor' => 'rgba(0, 0, 0, 0)',

	/**
	 * The background color of the leave button
	 *
	 * @var string An RGB color
	 */
	'leaveButtonBackgroundColor' => 'rgba(0, 0, 0, 0)',

	/**
	 * The text color of the leave button
	 *
	 * @var string An RGB color
	 */
	'leaveButtonTextColor' => 'rgb(0, 0, 0)',

	/**
	 * The border color of the leave button
	 *
	 * @var string An RGB color
	 */
	'leaveButtonBorderColor' => 'rgba(0, 0, 0, 0.4)',

	/**
	 * The background color of drop-downs/input fields
	 *
	 * @var string An RGB color
	 */
	'formElementBackgroundColor' => 'rgba(0, 0, 0, 0.05)',

	/**
	 * The color of the text entered/written in drop-downs/input fields
	 *
	 * @var string An RGB color
	 */
	'formElementTextColor' => 'rgb(0, 0, 0)',

	/**
	 * The border color of drop-downs/input fields
	 *
	 * @var string An RGB color
	 */
	'formElementBorderColor' => 'rgba(0, 0, 0, 0.4)',

	/**
	 * The color of the placeholder in drop-downs/input fields
	 *
	 * @var string An RGB color
	 */
	'formElementPlaceholderColor' => 'rgba(0, 0, 0, 0.4)',

	/**
	 * Font Size of the "Message" or "Headline" of the age verification box (in px)
	 *
	 * @var int An integer
	 */
	'messageFontSize' => 29,

	/**
	 * Font Size of the "Caption" or "Sub-Headline" of the age verification box (in px)
	 *
	 * @var int An integer
	 */
	'captionFontSize' => 16,

	/**
	 * Font Size of the additional info displayed below the age verification form (in px)
	 *
	 * @var int An integer
	 */
	'additionalInfoFontSize' => 12,

	/**
	 * Path to your CSS file, if you want to use some custom CSS rules on the age verification page
	 *
	 * @var string A path (aliases and environment variables are allowed here)
	 */
	'customCssFile' => '',
];
