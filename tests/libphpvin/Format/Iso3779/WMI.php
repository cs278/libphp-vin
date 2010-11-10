<?php

namespace libphpvin\tests\Format\Iso3779;

class WMI extends \PHPUnit_Framework_TestCase
{
	private $wmi;

	public function setUp()
	{
		$this->wmi = new \libphpvin\Format\Iso3779\WMI('HFC');
	}

	/**
	 * @test
	 */
	public function getRegion()
	{
		$this->assertInstanceOf('\libphpvin\Format\Iso3779\WMI\Region', $this->wmi->getRegion());
	}

	/**
	 * @test
	 */
	public function getCountry()
	{
		$this->assertInstanceOf('\libphpvin\Format\Iso3779\WMI\Country', $this->wmi->getCountry());
	}

	/**
	 * @test
	 */
	public function getManufacturer()
	{
		$this->assertInstanceOf('\libphpvin\Format\Iso3779\WMI\Manufacturer', $this->wmi->getManufacturer());
	}
}
