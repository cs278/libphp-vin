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
abstract class M100 extends Lotus
{
	const YEAR_BEGIN = 1990;
	const YEAR_END = 1995;

	public static function factory($vin)
	{
		foreach (array('Usa', 'RestOfWorld') as $type)
		{
			$class = __NAMESPACE__ . '\\' . $type;

			try
			{
				return call_user_func(array($class, 'factory'), $vin);
			}
			catch (Exception\InvalidArgumentException $e) {}
		}
		throw new Exception\InvalidArgumentException;
	}

	abstract function getEngine();

	public function getYear()
	{
		return self::transliterateYear(parent::getModelYear(), self::YEAR_BEGIN, self::YEAR_END);
	}

	public function getDrive()
	{
		switch ($this->_value[11])
		{
			case 'A':
			case 'D':
				return Vin::DRIVE_RIGHT;
			case 'F':
			case 'H':
				return Vin::DRIVE_LEFT;
		}
		throw new Vin_Exception;
	}

	public function getCatalyst()
	{
		switch ($this->_value[11])
		{
			case 'A':
			case 'F':
				return true;
			case 'D':
			case 'H':
				return false;
		}
		throw new Vin_Exception;
	}

	public function getLegislation()
	{
		switch ($this->_value[12])
		{
			case 1:
				return 'ECE 15.04';
			case 2:
				return '49 States (USA)';
			case 3:
				return 'California';
			case 4:
				return '88/76/EEC';
			case 5:
				return 'Japan';
			case 6:
				return '50 States (USA)';
		}
		throw new Vin_Exception;
	}

	/**
	 * Get the limited edition series number of the car.
	 *
	 * @return type
	 */
	public function getNumber()
	{
		return substr($this->_value, 13, 4);
	}

	/**
	 * Decode a Lotus M100 Elan VIN Number
	 *
	 * @param string $vin VIN Number to decode
	 * @return array Parsed VIN Number details
	 */
	public static function decode($vin)
	{
		$vin = strtoupper(trim($vin));

		if (strlen($vin) != 17 || strpos($vin, 'SCC') !== 0)
		{
			return false;
		}

		$result = array();

		if ($vin[3] == 'G')
		{
			// American VIN
			if ($vin[4] == 'A')
			{
				$result[] = 'Series 1';
			}
			else
			{
					throw new VINParseException('Failed at 5');
			}

			switch ($vin[5])
			{
				case '1':
					$result[] = 'Manual';
				break;

				case '2':
					$result[] = 'Manual + AC';
				break;

				case '3':
					$result[] = 'Manual + AC + PAS';
				break;

				case '5':
					$result[] = 'Manual + PAS';
				break;

				default:
					throw new VINParseException('Failed at 6');
			}

			switch ($vin[6])
			{
				case '5':
					$result[] = '1.6L (4XE1-M)';
				break;

				case '6':
					$result[] = '1.6L Turbo (4XE1-MT)';
				break;

				default:
					throw new VINParseException('Failed at 7');
			}

			switch ($vin[7])
			{
				case 'A':
					$result[] = 'Active Belts';
				break;

				case 'B':
					$result[] = 'Active Belts and Airbags';
				break;

				case 'P':
					$result[] = 'Passive Belts';
				break;

				default:
					throw new VINParseException('Failed at 8');
			}

			// $vin[8] is check diget

			switch ($vin[9])
			{
				case 'S':
				case 'R':
				case 'P':
				case 'N':
				case 'M':
				case 'L':
					//print_rs(ord('S')); print_rs(ord('L'));
					// Two letters skipped so make sure to substract that too
					$result[] = (string) 1990 + (ord($vin[9]) - ord('L') - 2);
					//$result[] = '199x';
				break;

				default:
					throw new VINParseException('Failed at 10');
			}

			if ($vin[10] == 'H')
			{
				$result[] = 'Hethel, Norfolk, England';
			}
			else
			{
				throw new VINParseException('Failed at 11');
			}

			switch ($vin[11])
			{
				case 'A':
					$result[] = 'RHD with Catalyst';
				break;

				case 'F':
					$result[] = 'LHD with Catalyst';
				break;

				case 'D':
					$result[] = 'RHD without Catalyst';
				break;

				case 'H':
					$result[] = 'LHD without Catalyst';
				break;

				default:
					throw new VINParseException('Failed at 12');
			}

			switch ($vin[12])
			{
				case '1':
					$result[] = 'ECE 15.04';
				break;

				case '2':
					$result[] = '49 States (USA)';
				break;

				case '3':
					$result[] = 'California';
				break;

				case '4':
					$result[] = '88/76/EEC';
				break;

				case '5':
					$result[] = 'Japan';
				break;

				case '6':
					$result[] = '50 States (USA)';
				break;

				default:
					throw new VINParseException('Failed at 13');
			}

			$result[] = substr($vin, -4);
		}
		else if (strpos($vin, 'SCC100') === 0)
		{
			// RotW VIN
			switch (substr($vin, 6, 3))
			{
				case 'ZN1':
					$result[] = '1.6L (4XE1-M)';
				break;

				case 'ZT1':
					$result[] = '1.6L Turbo (4XE1-MT)';
				break;

				default:
					throw new VINParseException('Failed at 7-9');
			}

			switch ($vin[9])
			{
				case 'S':
				case 'R':
				case 'P':
				case 'N':
				case 'M':
				case 'L':
					//print_rs(ord('S')); print_rs(ord('L'));
					// Two letters skipped so make sure to substract that too
					$result[] = (string) 1990 + (ord($vin[9]) - ord('L') - 2);
					//$result[] = '199x';
				break;

				default:
					throw new VINParseException('Failed at 10');
			}

			if ($vin[10] == 'H')
			{
				$result[] = 'Hethel, Norfolk, England';
			}
			else
			{
				$result[] = 'Failed at 11';
				return $result;
			}

			switch ($vin[11])
			{
				case 'A':
					$result[] = 'RHD with Catalyst';
				break;

				case 'F':
					$result[] = 'LHD with Catalyst';
				break;

				case 'D':
					$result[] = 'RHD without Catalyst';
				break;

				case 'H':
					$result[] = 'LHD without Catalyst';
				break;

				default:
					$result[] = 'Failed at 12';
					return $result;
			}

			switch ($vin[12])
			{
				case '1':
					$result[] = 'ECE 15.04';
				break;

				case '2':
					$result[] = '49 States (USA)';
				break;

				case '3':
					$result[] = 'California';
				break;

				case '4':
					$result[] = '88/76/EEC';
				break;

				case '5':
					$result[] = 'Japan';
				break;

				case '6':
					$result[] = '50 States (USA) & Japan';
				break;

				default:
					throw new VINParseException('Failed at 13');
			}

			$result[] = substr($vin, -4);
		}
		else
		{
			return false;
		}

		return $result;
	}
}