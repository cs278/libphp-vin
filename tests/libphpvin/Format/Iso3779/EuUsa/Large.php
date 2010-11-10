<?php

namespace libphpvin\tests\Format;

class Large extends \PHPUnit_Framework_TestCase
{
	private $vin;

	public function setUp()
	{
		$this->vin = new \libphpvin\Format\Iso3779\EuUsa\Large('1M8GDM9AXKP042788');
	}

	/**
	 * @test
	 */
	public function getVehicleAttributes()
	{
		$this->assertEquals('GDM9A', $this->vin->getVehicleAttributes());
	}

	/**
	 * @test
	 */
	public function getCheckDigit()
	{
		$this->assertEquals('X', $this->vin->getCheckDigit());
	}

	/**
	 * @test
	 */
	public function getModelYear()
	{
		$year = $this->vin->getModelYear();

		$this->assertInstanceOf('libphpvin\Vin\Component', $year);
		$this->assertInstanceOf('libphpvin\Format\Iso3779\EuUsa\ModelYear', $year);
		$this->assertEquals('K', $year->getValue());
	}

	/**
	 * @test
	 */
	public function getPlantCode()
	{
		$this->assertEquals('P', $this->vin->getPlantCode());
	}


	/**
	 * @test
	 */
	public function getSerialNumber()
	{
		$this->assertSame('042788', $this->vin->getSerialNumber());
	}

	/**
	 * @test
	 * @dataProvider providerIsValid
	 */
	public function isValid($vin, $expected)
	{
		$vin = new \libphpvin\Format\Iso3779\EuUsa\Large($vin);

		$this->assertSame($expected, $vin->isValid());
	}

	public function providerIsValid()
	{
		return array(
			array('EFGND83734HC92743', false),
			array('1M8GDM9AXKP042788', true),
		);
	}
}
