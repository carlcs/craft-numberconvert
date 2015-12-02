<?php
namespace Craft;

class NumberConvertService extends BaseApplicationComponent
{
        // Public Methods
	// =========================================================================

        /**
	 * Converts a decimal number to a representation of that number in another numeral system.
	 *
	 * @param float  $float  Number to convert
	 * @param string $system Sets the numeral system the number gets converted to
	 *
	 * @return string The converted number
	 */
        public function numeralSystem($float, $system, $zero)
	{
                $int = (int)$float;

                switch ($zero)
                {
                        case -1:
                        {
                                // Start negative numerals with 0 (i.e. -1 => -B, 0 => -A, 1 => A)
                                $int = ($int < 1) ? $int - 1 : $int;

                                break;
                        }
                        case 1:
                        {
                                // Start positive numerals with 0 (i.e. -1 => -A, 0 => A, 1 => B)
                                $int = ($int > -1) ? $int + 1 : $int;

                                break;
                        }
                        default:
                        {
                                $zeroChar = $zero;
                        }
                }

                if ($int == 0)
                {
                        return $zeroChar;
                }
                elseif ($int < 0)
                {
                        $int = abs($int);
                        $prefix = '-';
                }
                else
                {
                        $prefix = '';
                }

		switch ($system)
		{
                        case 'roman':
			case 'upperRoman':
			{
				return $prefix.$this->_roman($int);
			}
			case 'lowerRoman':
			{
				return $prefix.$this->_roman($int, 'lower');
			}
                        case 'alpha':
			case 'upperAlpha':
			{
				return $prefix.$this->_alpha($int);
			}
			case 'lowerAlpha':
			{
				return $prefix.$this->_alpha($int, 'lower');
			}
			default:
			{
				return $int;
			}
		}
	}

        /**
	 * Converts a fraction to a decimal number.
	 *
	 * @param string  $fraction  The number to convert
         * @param integer $precision The precision the returned number gets rounded to
	 *
	 * @return float The converted number
	 */
	public function fractionToFloat($fraction, $precision = 4)
	{
                if ($this->_isFloat($fraction))
                {
                        return $fraction;
                }

                if ($this->_isFraction($fraction))
                {
                        list($numerator, $denominator) = explode('/', $fraction);

        	        $float = $numerator / ($denominator ? $denominator : 1);

                        return round($float, $precision);
                }

                return 0;
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
	public function floatToFraction($float, $tolerance = 1.e-6)
	{
                if (!$this->_isFloat($float))
                {
                        return 0;
                }

		$h1 = 1; $h2 = 0;
		$k1 = 0; $k2 = 1;
		$b = 1 / $float;

		do
		{
			$b = 1 / $b;
			$a = floor($b);
			$aux = $h1; $h1 = $a * $h1 + $h2; $h2 = $aux;
			$aux = $k1; $k1 = $a * $k1 + $k2; $k2 = $aux;
			$b = $b - $a;
		}
		while (abs($float - $h1 / $k1) > $float * $tolerance);

                if (true && ($h1 == $k1))
                {
                        return $h1;
                }

		return $h1.'/'.$k1;
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
        public function unitPrefix($float, $system = 'decimal', $decimals = 1, $trailingZeros = false, $decPoint = '.', $thousandsSep = '', $unitSep = ' ')
        {
                if (is_string($system))
                {
                        $system = $this->_getUnitPrefixSettings($system);
                }

                if (!array_key_exists('map', $system))
                {
                        return $float;
                }

                $base = array_key_exists('base', $system) ? $system['base'] : 10;
                $map = $system['map'];

                foreach ($map as $exp => $prefix)
                {
                        if ($float >= pow($base, $exp))
                        {
                                $number = $float / pow($base, $exp);

                                $number = number_format($number, $decimals, $decPoint, $thousandsSep);

                                if (!$trailingZeros)
                                {
                                        $number = $this->_trimTrailingZeroes($number, $decPoint);
                                }

                                return $number.$unitSep.Craft::t($prefix);
                        }
                }

                return $float;
        }

        // Private Methods
	// =========================================================================

        /**
	 * Converts a decimal number to its roman numberal equivalent.
	 *
	 * @param integer $int  Number to convert
	 * @param string  $case Sets whether the roman numeral is returned in upper or lower case
         *
	 * @return string The roman numeral equivalent to the input number
	 */
	private function _roman($int, $case = 'upper')
	{
                $map = array(1000 => 'M', 900 => 'CM', 500 => 'D', 400 => 'CD', 100 => 'C', 90 => 'XC', 50 => 'L', 40 => 'XL', 10 => 'X', 9 => 'IX', 5 => 'V', 4 => 'IV', 1 => 'I');
		$roman = '';

		foreach ($map as $d => $r)
		{
			$roman .= str_repeat($r, (int)($int / $d));
			$int %= $d;
		}

		return ($case == 'lower') ? strtolower($roman) : $roman;
	}

        /**
	 * Converts a decimal number to its alphabetic equivalent.
	 *
	 * @param integer $int  Number to convert
	 * @param string  $case Sets whether the letter(s) is returned in upper or lower case
         *
	 * @return string The alphabetic equivalent to the input number
	 */
	private function _alpha($int, $case = 'upper')
	{
		$counter = 1;
		for ($alpha = 'A'; $alpha <= 'ZZ'; $alpha++)
		{
			if ($counter == $int)
			{
				return ($case == 'lower') ? strtolower($alpha) : $alpha;
			}
			$counter++;
		}
	}

        /**
	 * Checks if a number is a fraction.
	 *
	 * @param string $fraction Number to test
         *
	 * @return boolean
	 */
        private function _isFraction($fraction)
        {
                return preg_match('/^[-+]?[0-9]*\.?[0-9]+[ ]?\/[ ]?[-+]?[0-9]*\.?[0-9]+$/', $fraction);
        }

        /**
	 * Checks if a number is a rational number.
	 *
	 * @param float $float Number to test
         *
	 * @return boolean
	 */
        private function _isFloat($float)
        {
                return preg_match('/^[-+]?[0-9]*\.?[0-9]+$/', $float);
        }

        /**
	 * Returns configuration settings for unit prefixes.
	 *
	 * @param string $preset The configuration preset's name
         *
	 * @return array The configuration settings
	 */
        private function _getUnitPrefixSettings($preset)
        {
                $settings = array();

                switch ($preset)
                {
                        case 'names':
                        {
                                $settings['map'] = array(12 => 'trillion', 9 => 'billion', 6 => 'million', 3 => 'thousand', 2 => 'hundred', 0 => '');
                                break;
                        }
                        case 'decimal':
                        case 'decimalSymbol':
                        {
                                $settings['map'] = array(15 => 'P', 12 => 'T', 9 => 'G', 6 => 'M', 3 => 'k', 0 => '', -2 => 'c', -3 => 'm', -6 => 'µ', -9 => 'n');
                                break;
                        }
                        case 'decimalNames':
                        {
                                $settings['map'] = array(15 => 'peta', 12 => 'tera', 9 => 'giga', 6 => 'mega', 3 => 'kilo', 0 => '', -2 => 'centi', -3 => 'milli', -6 => 'micro', -9 => 'nano');
                                break;
                        }
                        case 'binary':
                        case 'binarySymbol':
                        {
                                $settings['base'] = 2;
                                $settings['map'] = array(50 => 'Pi', 40 => 'Ti', 30 => 'Gi', 20 => 'Mi', 10 => 'Ki', 0 => '');
                                break;
                        }
                        case 'binaryNames':
                        {
                                $settings['base'] = 2;
                                $settings['map'] = array(50 => 'pebi', 40 => 'tebi', 30 => 'gibi', 20 => 'mebi', 10 => 'kibi', 0 => '');
                                break;
                        }
                }

                return $settings;
        }

        /**
	 * Trims trailing zeroes.
	 *
	 * @param integer $float
	 * @param string  $decPoint
         *
	 * @return string
	 */
        private function _trimTrailingZeroes($float, $decPoint = '.')
        {
                return strpos($float, $decPoint) !== false ? rtrim(rtrim($float, '0'), $decPoint) : $float;
        }
}
