<?php
namespace Craft;

class NumberConvertService extends BaseApplicationComponent
{
        // Public Methods
	// =========================================================================

        /**
	 * Converts a decimal number to a representation of that number in another numeral system.
	 *
	 * @param float $float Number to convert
	 * @param string $system Sets the numeral system the number gets converted to
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
				return $prefix.$this->roman($int);
			}
			case 'lowerRoman':
			{
				return $prefix.$this->roman($int, 'lower');
			}
                        case 'alpha':
			case 'upperAlpha':
			{
				return $prefix.$this->alpha($int);
			}
			case 'lowerAlpha':
			{
				return $prefix.$this->alpha($int, 'lower');
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
	 * @param string $fraction The number to convert
         * @param integer $precision The precision the returned number gets rounded to
	 * @return float The converted number
	 */
	public function fractionToFloat($fraction, $precision = 4)
	{
                if ($this->isFloat($fraction))
                {
                        return $fraction;
                }

                if ($this->isFraction($fraction))
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
	 * @param float $float The number to convert
	 * @param float $tolerance The allowed tolerance for the fraction calculation
	 * @return string The converted number
	 */
	public function floatToFraction($float, $tolerance = 1.e-6)
	{
                if (!$this->isFloat($float))
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

        // Protected Methods
	// =========================================================================

        /**
	 * Converts a decimal number to its roman numberal equivalent.
	 *
	 * @param integer $int Number to convert
	 * @param string $case Sets whether the roman numeral is returned in upper or lower case
	 * @return string The roman numeral equivalent to the input number
	 */
	protected function roman($int, $case = 'upper')
	{

		$map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
		$roman = '';

		foreach ($map as $r => $d)
		{
			$roman .= str_repeat($r, (int)($int / $d));
			$int %= $d;
		}

		return ($case == 'lower') ? strtolower($roman) : $roman;
	}

        /**
	 * Converts a decimal number to its alphabetic equivalent.
	 *
	 * @param integer $int Number to convert
	 * @param string $case Sets whether the letter(s) is returned in upper or lower case
	 * @return string The alphabetic equivalent to the input number
	 */
	protected function alpha($int, $case = 'upper')
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
	 * @return boolean
	 */
        protected function isFraction($fraction)
        {
                return preg_match('/^[-+]?[0-9]*\.?[0-9]+[ ]?\/[ ]?[-+]?[0-9]*\.?[0-9]+$/', $fraction);
        }

        /**
	 * Checks if a number is a rational number.
	 *
	 * @param float $float Number to test
	 * @return boolean
	 */
        protected function isFloat($float)
        {
                return preg_match('/^[-+]?[0-9]*\.?[0-9]+$/', $float);
        }
}
