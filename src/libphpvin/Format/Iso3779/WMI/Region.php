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
 * @subpackage	Format\Iso3779\WMI
 * @copyright	Copyright (c) 2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 * @version		
 */
namespace libphpvin\Format\Iso3779\WMI;

/**
 * @package		libphp-vin
 * @subpackage	Format\Iso3779\WMI
 * @copyright	Copyright (c) 2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Region extends \libphpvin\Vin\Component\Base
{
	static protected $_regions = array(
		'A'	=> self::AFRICA,
		'B'	=> self::AFRICA,
		'C'	=> self::AFRICA,
		'D'	=> self::AFRICA,
		'E'	=> self::AFRICA,
		'F'	=> self::AFRICA,
		'G'	=> self::AFRICA,
		'H'	=> self::AFRICA,
		'J'	=> self::ASIA,
		'K'	=> self::ASIA,
		'L'	=> self::ASIA,
		'M'	=> self::ASIA,
		'N'	=> self::ASIA,
		'P'	=> self::ASIA,
		'R'	=> self::ASIA,
		'S'	=> self::EUROPE,
		'T'	=> self::EUROPE,
		'U'	=> self::EUROPE,
		'V'	=> self::EUROPE,
		'W'	=> self::EUROPE,
		'X'	=> self::EUROPE,
		'Y'	=> self::EUROPE,
		'Z'	=> self::EUROPE,
		'1'	=> self::NORTH_AMERICA,
		'2'	=> self::NORTH_AMERICA,
		'3'	=> self::NORTH_AMERICA,
		'4'	=> self::NORTH_AMERICA,
		'5'	=> self::NORTH_AMERICA,
		'6'	=> self::OCEANIA,
		'7'	=> self::OCEANIA,
		'8'	=> self::SOUTH_AMERICA,
		'9'	=> self::SOUTH_AMERICA,
	);

	const AFRICA		= 'Africa';
	const ASIA			= 'Asia';
	const EUROPE		= 'Europe';
	const NORTH_AMERICA	= 'North America';
	const OCEANIA		= 'Oceania';
	const SOUTH_AMERICA	= 'South America';

	public function getName()
	{
		return self::$_regions[$this->getValue()];
	}
}
