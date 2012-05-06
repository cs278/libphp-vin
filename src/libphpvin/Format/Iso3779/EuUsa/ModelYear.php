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
 * @subpackage	Format\Iso3779\EuUsa
 * @copyright	Copyright (c) 2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 * @version		
 */
namespace libphpvin\Format\Iso3779\EuUsa;

/**
 * @package		libphp-vin
 * @subpackage	Format\Iso3779\EuUsa
 * @copyright	Copyright (c) 2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ModelYear extends \libphpvin\Vin\Component\Base
{
	const START = 1980;
	const END = 2019;

	private static $yearAlpha = array(
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K',
		'L', 'M', 'N', 'P', 'R', 'S', 'T', 'V', 'W', 'X',
		'Y', '1', '2', '3', '4', '5', '6', '7', '8', '9',
	);

	/**
	 * Obtain possible years for a year identifier
	 *
	 * http://en.wikipedia.org/wiki/Vehicle_Identification_Number#Model_year_encoding
	 *
	 * @return int
	 */
	public function getYear($start = self::START, $limit = self::END)
	{
		$alpha = array_flip(self::$yearAlpha);
		$year = $this->_value;

		if (!isset($alpha[$year]))
		{
			throw new Vin_Exception;
		}

		$start = max(self::START, $start);
		$offset = $start - self::START;
		$singular = (($limit - $start) < sizeof(self::$yearAlpha));

		// Shift the array around
		$alpha = ($offset) ? array_merge(array_slice(self::$yearAlpha, $offset, null, true), array_slice(self::$yearAlpha, 0, $offset, true)) : self::$yearAlpha;

		if (!$singular)
		{
			$_alpha = $alpha;

			// Repeat the array so we can loop until the limit
			foreach (range(1, (int) ceil(($limit - $start) / sizeof($_alpha))) as $i)
			{
				$alpha = array_merge($alpha, $_alpha);
			}

			unset($_alpha);
		}
		$years = array();

		foreach (array_keys(array_intersect($alpha, array($year))) as $value)
		{
			if ($start + $value > $limit)
			{
				// Year is greater than the limit, bail
				break;
			}
			$years[] = $start + $value;
		}

		return $singular ? array_shift($years) : $years;
	}
}
