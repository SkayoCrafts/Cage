<?php
/**
 * Cage plugin for Craft CMS 3.x
 *
 * An Age-Verification-Gate Plugin for Craft CMS
 *
 * @link      https://skayocrafts.github.io/Cage
 * @copyright Copyright (c) 2019 Skayo
 */

namespace skayocrafts\cage\twigextensions;

use skayocrafts\cage\twigextensions\tokenparsers\RequireAgeTokenParser;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    Skayo
 * @package   Cage
 * @since     1.0.0
 */
class CageTwigExtension extends \Twig_Extension {
	// Public Methods
	// =========================================================================

	/**
	 * Returns the name of the extension.
	 *
	 * @return string The extension name
	 */
	public function getName () {
		return 'Cage';
	}

	/**
	 * Returns an array of Twig token parsers, used in Twig templates via:
	 *
	 *      {% ... %}
	 *
	 * @return array
	 */
	public function getTokenParsers () {
		return [
			new RequireAgeTokenParser(),
		];
	}
}
