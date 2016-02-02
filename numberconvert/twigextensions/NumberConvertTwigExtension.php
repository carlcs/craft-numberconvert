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
            new \Twig_SimpleFilter('unitPrefix', array($this, 'unitPrefixFilter')),
        );
    }

    /**
     * Converts a decimal number to a representation of that number in another numeral system.
     *
     * @param float  $float  Number to convert
     * @param string $system Sets the numeral system the number gets converted to
     *
     * @return string The converted number
     */
    public function numeralSystemFilter($float, $system, $zero = -1)
    {
        return craft()->numberConvert->numeralSystem($float, $system, $zero);
    }

    /**
     * Converts a fraction to a decimal number.
     *
     * @param string  $fraction  The number to convert
     * @param integer $precision The precision the returned number gets rounded to
     *
     * @return float The converted number
     */
    public function fractionToFloatFilter($fraction, $precision = 4)
    {
        return craft()->numberConvert->fractionToFloat($fraction, $precision);
    }

    /**
     * Converts a decimal number to a fraction.
     * http://jonisalonen.com/2012/converting-decimal-numbers-to-ratios/
     *
     * @param float $float     The number to convert
     * @param float $tolerance The allowed tolerance for the fraction calculation
         *
     * @return string The converted number
     */
    public function floatToFractionFilter($float, $tolerance = 0.001)
    {
        return craft()->numberConvert->floatToFraction($float, $tolerance);
    }

    /**
     * Formats a number with unit prefixes.
     *
     * @param float  $float         Number to format
     * @param mixed  $system        Either a string (e.g. "decimal") to use a predefined configuration
     *                              or an array of custom settings
     * @param int    $decimals      The number of decimal points
     * @param bool   $trailingZeros Whether to show trailing zeros
     * @param string $decPoint      The separator for the decimal point
     * @param string $thousandsSep  The thousands separator
     * @param string $unitSep       The separator between number and unit
     *
     * @return string The prefixed number
     */
    public function unitPrefixFilter($float, $system = 'decimal', $decimals = 1, $trailingZeros = false, $decPoint = '.', $thousandsSep = '', $unitSep = ' ')
    {
        return craft()->numberConvert->unitPrefix($float, $system, $decimals, $trailingZeros, $decPoint, $thousandsSep, $unitSep);
    }
}
