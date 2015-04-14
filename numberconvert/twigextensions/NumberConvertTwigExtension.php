<?php
namespace Craft;

class NumberConvertTwigExtension extends \Twig_Extension
{
	/**
	 * Returns the name of the extension.
	 *
	 * @return string The extension name
	 */
	public function getName()
	{
		return 'Number Convert';
	}

	/**
	 * Returns a list of filters to add to the existing list.
	 *
	 * @return array An array of filters
	 */
	public function getFilters()
	{
		return array(
			new \Twig_SimpleFilter('numeralSystem', array($this, 'numeralSystemFilter')),
			new \Twig_SimpleFilter('fractionToFloat', array($this, 'fractionToFloatFilter')),
			new \Twig_SimpleFilter('floatToFraction', array($this, 'floatToFractionFilter')),
		);
	}

	/**
	 * Twig filter to convert a decimal number to a representation of that number in another numeral system.
	 *
	 * @param float $float Number to convert
	 * @param string $system Sets the numeral system the number gets converted to
	 * @return string The converted number
	 */
	public function numeralSystemFilter($float, $system, $zero = -1)
	{
		return craft()->numberConvert->numeralSystem($float, $system, $zero);
	}

	/**
	 * Twig filter to convert a fraction to a decimal number.
	 *
	 * @param string $fraction The number to convert
         * @param integer $precision The precision the returned number gets rounded to
	 * @return float The converted number
	 */
	public function fractionToFloatFilter($fraction, $precision = 4)
	{
		return craft()->numberConvert->fractionToFloat($fraction, $precision);
	}

	/**
	 * Twig filter to convert a decimal number to a fraction.
	 *
	 * @param float $float The number to convert
	 * @param float $tolerance The allowed tolerance for the fraction calculation
	 * @return string The converted number
	 */
	public function floatToFractionFilter($float, $tolerance = 0.001)
	{
		return craft()->numberConvert->floatToFraction($float, $tolerance);
	}
}
