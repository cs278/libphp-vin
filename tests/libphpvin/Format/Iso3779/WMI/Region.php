<?php

namespace libphpvin\tests\Format\Iso3779\WMI;

use \libphpvin\Format\Iso3779\WMI;
use \libphpvin\Format\Iso3779\WMI\Region as RegionClass;

class Region extends \PHPUnit_Framework_TestCase
{
	public function providerRegions()
	{
		return array(
			array(new WMI('A12'), RegionClass::AFRICA, 'A'),
			array(new WMI('B12'), RegionClass::AFRICA, 'B'),
			array(new WMI('C12'), RegionClass::AFRICA, 'C'),
			array(new WMI('D12'), RegionClass::AFRICA, 'D'),
			array(new WMI('E12'), RegionClass::AFRICA, 'E'),
			array(new WMI('F12'), RegionClass::AFRICA, 'F'),
			array(new WMI('G12'), RegionClass::AFRICA, 'G'),
			array(new WMI('H12'), RegionClass::AFRICA, 'H'),

			array(new WMI('J12'), RegionClass::ASIA, 'J'),
			array(new WMI('K12'), RegionClass::ASIA, 'K'),
			array(new WMI('L12'), RegionClass::ASIA, 'L'),
			array(new WMI('M12'), RegionClass::ASIA, 'M'),
			array(new WMI('N12'), RegionClass::ASIA, 'N'),
			array(new WMI('P12'), RegionClass::ASIA, 'P'),
			array(new WMI('R12'), RegionClass::ASIA, 'R'),

			array(new WMI('S12'), RegionClass::EUROPE, 'S'),
			array(new WMI('T12'), RegionClass::EUROPE, 'T'),
			array(new WMI('U12'), RegionClass::EUROPE, 'U'),
			array(new WMI('V12'), RegionClass::EUROPE, 'V'),
			array(new WMI('W12'), RegionClass::EUROPE, 'W'),
			array(new WMI('X12'), RegionClass::EUROPE, 'X'),
			array(new WMI('Y12'), RegionClass::EUROPE, 'Y'),
			array(new WMI('Z12'), RegionClass::EUROPE, 'Z'),

			array(new WMI('112'), RegionClass::NORTH_AMERICA, '1'),
			array(new WMI('212'), RegionClass::NORTH_AMERICA, '2'),
			array(new WMI('312'), RegionClass::NORTH_AMERICA, '3'),
			array(new WMI('412'), RegionClass::NORTH_AMERICA, '4'),
			array(new WMI('512'), RegionClass::NORTH_AMERICA, '5'),

			array(new WMI('612'), RegionClass::OCEANIA, '6'),
			array(new WMI('712'), RegionClass::OCEANIA, '7'),

			array(new WMI('812'), RegionClass::SOUTH_AMERICA, '8'),
			array(new WMI('912'), RegionClass::SOUTH_AMERICA, '9'),
		);
	}

	/**
	 * @test
	 * @dataProvider providerRegions
	 */
	public function getValue(WMI $wmi, $name, $value)
	{
		$this->assertSame($value, $wmi->getRegion()->getValue());
	}

	/**
	 * @test
	 * @dataProvider providerInvalidSetValue
	 * @expectedException \InvalidArgumentException
	 */
	public function invalidSetValue($value)
	{
		new RegionClass($value);
	}

	public function providerInvalidSetValue()
	{
		return array(
			array($this),
			array(''),
			array(new \libphpvin\Format\Iso3779('ABCDEFG1234567890')),
		);
	}

	/**
	 * @test
	 * @dataProvider providerRegions
	 */
	public function testGetName($wmi, $name, $value)
	{
		$this->assertSame($name, $wmi->getRegion()->getName());
	}
}
