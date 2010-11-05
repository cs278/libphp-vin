<?php
/**
 * PHP VIN Utility Library
 *
 * LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package		libphp-vin
 * @subpackage	CheckDigit\Calculator
 * @copyright	Copyright (c) 2008-2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 * @version		
 */
namespace libphpvin\CheckDigit\Calculator;

/**
 * Standard VIN check digit calculator
 *
 * @package		libphp-vin
 * @subpackage	CheckDigit\Calculator
 * @copyright	Copyright (c) 2008-2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 * @link		http://en.wikipedia.org/wiki/VIN#Check_digit_calculation
 */
class Standard extends Abstract
{
	/**
	 * Calculate the check digit of a VIN number
	 *
	 * @return	string	VIN check digit
	 */
	public function getCheckDigit()
	{
		$CheckDigit = $this->getChecksum() % 11;

		return ($CheckDigit === 10) ? 'X' : (string) $CheckDigit;
	}

	public function getChecksum()
	{
		$vin = str_split($this->getVin());
		$vin = array_map(array($this, 'transliterate'), $vin);
		$vin = array_map(function($pos, $value)
		{
			switch ($pos)
			{
				case 8:
					$value *= 10;
				break;

				// CheckDigit digit
				case 9:
					$value *= 0;
				break;

				case 10:
					$value *= 9;
				break;

				case 1:
				case 11:
					$value *= 8;
				break;

				case 2:
				case 12:
					$value *= 7;
				break;

				case 3:
				case 13:
					$value *= 6;
				break;

				case 4:
				case 14:
					$value *= 5;
				break;

				case 5:
				case 15:
					$value *= 4;
				break;

				case 6:
				case 16:
					$value *= 3;
				break;

				case 7:
				case 17:
					$value *= 2;
				break;
			}

			return $value;
		}, range(1, 17), $vin);

		return array_sum($vin);
	}

	public function transliterate($character)
	{
		if (strlen($character) !== 1)
		{
			throw new \InvalidArgumentException('Expecting single character argument.');
		}

		switch ($character)
		{
			case 'A':
			case 'J':
				return 1;
			break;

			case 'B':
			case 'K':
			case 'S':
				return 2;
			break;

			case 'C':
			case 'L':
			case 'T':
				return 3;
			break;

			case 'D':
			case 'M':
			case 'U':
				return 4;
			break;

			case 'E':
			case 'N':
			case 'V':
				return 5;
			break;

			case 'F':
			case 'W':
				return 6;
			break;

			case 'G':
			case 'P':
			case 'X':
				return 7;
			break;

			case 'H':
			case 'Y':
				return 8;
			break;

			case 'R':
			case 'Z':
				return 9;
			break;

			// These 3 letters are not allowed in a valid VIN
			case 'I':
			case 'O':
			case 'Q':
				throw new \Exception;
			break;

			case '0':
			case '1':
			case '2':
			case '3':
			case '4':
			case '5':
			case '6':
			case '7':
			case '8':
			case '9':
				return (int) $character;
			break;

			default:
				throw new \Exception;
		}
	}
}
