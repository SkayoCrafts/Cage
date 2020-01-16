<?php
/**
 * Cage plugin for Craft CMS 3.x
 *
 * An Age-Verification-Gate Plugin for Craft CMS
 *
 * @link      https://skayocrafts.github.io/Cage
 * @copyright Copyright (c) 2019 Skayo
 */

namespace skayocrafts\cage\twigextensions\tokenparsers;

use skayocrafts\cage\Cage;
use skayocrafts\cage\twigextensions\nodes\RequireAgeNode;
use Twig\Node\Expression\ConstantExpression;
use Twig\Parser;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * Used to verify that a user has the required age to view a page.
 * Usage: {% requireAge %} or {% requireAge(18) %}
 *
 * @author    Skayo
 * @package   Cage
 * @since     1.0.0
 */
class RequireAgeTokenParser extends AbstractTokenParser {

	// Public Methods
	// =========================================================================

	/**
	 * @inheritdoc
	 */
	public function parse (Token $token) {
		$lineno = $token->getLine();

		/** @var Parser $parser */
		$parser = $this->parser;

		$stream = $parser->getStream();

		$nodes = [];

		if ($stream->test(Token::NUMBER_TYPE)) {
			$nodes['age'] = $parser->getExpressionParser()->parseExpression();
		} else {
			$nodes['age'] = new ConstantExpression(Cage::$settings->defaultAge, 1);
		}

		$stream->expect(Token::BLOCK_END_TYPE);

		return new RequireAgeNode($nodes, [], $lineno, $this->getTag());
	}

	/**
	 * @inheritdoc
	 */
	public function getTag () {
		return 'requireAge';
	}
}