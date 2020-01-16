<?php
/**
 * Cage plugin for Craft CMS 3.x
 *
 * An Age-Verification-Gate Plugin for Craft CMS
 *
 * @link      https://skayocrafts.github.io/Cage
 * @copyright Copyright (c) 2019 Skayo
 */

namespace skayocrafts\cage\twigextensions\nodes;

use Craft;
use skayocrafts\cage\Cage;
use Twig\Compiler;
use Twig\Node\Node;

/**
 * Class RequireAgeNode
 *
 * @author    Skayo
 * @package   Cage
 * @since     1.0.0
 */
class RequireAgeNode extends Node {

	// Public Methods
	// =========================================================================

	/**
	 * Compiles a RequireAgeNode into PHP.
	 *
	 * @param Compiler $compiler
	 */
	public function compile (Compiler $compiler) {
		$compiler
			->addDebugInfo($this)
			->write(Cage::class . '::$plugin->ageVerification->requireAge(')
			->subcompile($this->getNode('age'))
			->raw(");\n\n");
	}
}