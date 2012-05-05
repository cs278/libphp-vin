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
 * @copyright	Copyright (c) 2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 * @version
 */
namespace libphpvin\Manufacturer\Lotus;

use libphpvin\Format\Iso3779\EuUsa\Small;

/**
 * @package		libphp-vin
 * @copyright	Copyright (c) 2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Lotus extends Small
{
	public static $wmi = array(
		'SCC'	=> 'Lotus Cars',
	);

	public static function factory($vin)
	{
		if (!self::is($vin))
		{
			throw new Vin_Exception;
		}

		foreach (array('M100') as $model)
		{
			$class = __NAMESPACE__ . '\\' . $model;

			try
			{
				return call_user_func(array($class, 'factory'), $vin);
			}
			catch (Exception\InvalidArgumentException $e) {}
		}
		throw new Exception\InvalidArgumentException;
	}

	public static function is($vin)
	{
		foreach (self::$wmi as $wmi => $name)
		{
			if (strpos($vin, $wmi) === 0)
			{
				return true;
			}
		}
		return false;
	}

	public function getFactory()
	{
		switch ($this->_value[10])
		{
			case 'H':
				return 'Hethel, Norfolk, United Kingdom';
		}
		throw new Vin_Exception;
	}
}