<?php

namespace libphpvin\tests\Format;

class Iso3779 extends \PHPUnit_Framework_TestCase
{
	private $vin;

	public function setUp()
	{
		$this->vin = new \libphpvin\Format\Iso3779('HFC8263LK927HD920');
	}

	/**
	 * @test
	 */
	public function getValidator()
	{
		$this->assertInstanceOf('\libphpvin\Format\Iso3779\Validator', $this->vin->getValidator());
	}

	/**
	 * @test
	 */
	public function setValidator()
	{
		$original = '\libphpvin\Format\Iso3779\Validator';
		$mock = $this->getMock($original);

		$this->assertInstanceOf($original, $this->vin->getValidator());
		$this->assertSame($this->vin, $this->vin->setValidator($mock));
		$this->assertInstanceOf(get_class($mock), $this->vin->getValidator());
	}

	/**
	 * @test
	 */
	public function resetValidator()
	{
		$original = '\libphpvin\Format\Iso3779\Validator';
		$mock = $this->getMock($original);

		$this->assertInstanceOf($original, $this->vin->getValidator());
		$this->assertSame($this->vin, $this->vin->setValidator($mock));
		$this->assertInstanceOf(get_class($mock), $this->vin->getValidator());
		$this->assertSame($this->vin, $this->vin->resetValidator());
		$this->assertInstanceOf($original, $this->vin->getValidator());
	}

	/**
	 * @test
	 * @dataProvider providerGetWMI
	 */
	public function getWMI($vin, $expecting)
	{
		$this->assertSame($expecting, $vin->getWMI()->getValue());
	}

	/**
	 * @test
	 * @dataProvider providerGetVDS
	 */
	public function getVDS($vin, $expecting)
	{
		$this->assertSame($expecting, $vin->getVDS()->getValue());
	}

	/**
	 * @test
	 * @dataProvider providerGetVIS
	 */
	public function getVIS($vin, $expecting)
	{
		$this->assertSame($expecting, $vin->getVIS()->getValue());
	}

	public function providerGetWMI()
	{
		return array(
			array(new \libphpvin\Format\Iso3779('SCCGH09D73027497D'), 'SCC'),
			array(new \libphpvin\Format\Iso3779('HFC8263LK927HD920'), 'HFC'),
		);
	}

	public function providerGetVDS()
	{
		return array(
			array(new \libphpvin\Format\Iso3779('SCCGH09D73027497D'), 'GH09D7'),
			array(new \libphpvin\Format\Iso3779('HFC8263LK927HD920'), '8263LK'),
		);
	}

	public function providerGetVIS()
	{
		return array(
			array(new \libphpvin\Format\Iso3779('SCCGH09D73027497D'), '3027497D'),
			array(new \libphpvin\Format\Iso3779('HFC8263LK927HD920'), '927HD920'),
		);
	}
}
