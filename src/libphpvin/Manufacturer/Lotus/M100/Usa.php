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
namespace libphpvin\Manufacturer\Lotus\M100;

use libphpvin\Manufacturer\Lotus\Lotus;
use libphpvin\Exception;

/**
 * VIN Class for the Lotus Elan M100
 *
 * @package		libphp-vin
 * @copyright	Copyright (c) 2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 * @see         http://wikilec.9600.org/index.php/VIN
 */
class Usa extends M100
{
	public static function factory($vin)
	{
		if (!self::is($vin))
		{
			throw new Exception\InvalidArgumentException;
		}

		return new self($vin);
	}

	public static function is($vin)
	{
		return (strpos('GA', $vin) === 3);
	}

	public function hasCheckDigit()
	{
		return true;
	}

	public function getEngine()
	{
		switch ($this->vin[6])
		{
			case '5':
				return '1.6L (4XE1-M)';
			case '6':
				return '1.6L Turbo (4XE1-MT)';
		}
		throw Vin_Exception;
	}

	public function getPowerSteering()
	{
		switch ($this->vin[5])
		{
			case '3':
			case '5':
				return true;
			case '1':
			case '2':
				return false;
		}
		throw Vin_Exception;
	}

	public function getAirConditioning()
	{
		switch ($this->vin[5])
		{
			case '2':
			case '3':
				return true;
			case '1':
			case '5':
				return false;
		}
		throw Vin_Exception;
	}

	public function getSafetyEquipment()
	{
		switch ($this->vin[7])
		{
			case 'A':
				return 'Active Belts';
			case 'B':
				return 'Active Belts and Airbags';
			case 'P':
				return 'Passive Belts';
		}
		throw Vin_Exception;
	}
}