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
 * @subpackage	Format\Iso3779
 * @copyright	Copyright (c) 2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 * @version		
 */
namespace libphpvin\Format\Iso3779;

/**
 * @package		libphp-vin
 * @subpackage	Format\Iso3779
 * @copyright	Copyright (c) 2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Validator implements \libphpvin\Vin\Validator
{
	const ERROR_TOO_SHORT			= 'VIN is shorter than the required 17 characters.';
	const ERROR_TOO_LONG			= 'VIN is longer than the maximum 17 characters.';

	const ERROR_PROHIBITED_I		= 'VIN contains an \'I\' which is invalid.';
	const ERROR_PROHIBITED_O		= 'VIN contains a \'O\' which is invalid.';
	const ERROR_PROHIBITED_Q		= 'VIN contains a \'Q\' which is invalid.';

	const ERROR_NON_ALPHANUMERIC	= 'VIN contains non alpha-numeric characters.';

	const ERROR_CHARACTERS_OTHER	= 'VIN contains other invalid characters.';


	public function validate(\libphpvin\Vin $vin)
	{
		$result = new \libphp\Validator\Result($vin);

		$value = $vin->getValue();
		$length = strlen($value);

		if ($length < 17)
		{
			$result->addError(self::ERROR_TOO_SHORT);
		}
		else if ($length > 17)
		{
			$result->addError(self::ERROR_TOO_LONG);
		}

		if (strspn($value, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890') !== $length)
		{
			$result->addError(self::ERROR_NON_ALPHANUMERIC);
		}

		if (stripos($value, 'I') !== false)
		{
			$result->addError(self::ERROR_PROHIBITED_I);
		}

		if (stripos($value, 'O') !== false)
		{
			$result->addError(self::ERROR_PROHIBITED_O);
		}

		if (stripos($value, 'Q') !== false)
		{
			$result->addError(self::ERROR_PROHIBITED_Q);
		}

		return $result;
	}
}
