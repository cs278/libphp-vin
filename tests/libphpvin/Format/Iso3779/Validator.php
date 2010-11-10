<?php

namespace libphpvin\tests\Format\Iso3779;

class Validator extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 * @dataProvider providerIsValid
	 */
	public function isValid($vin, $expecting, array $errors = array())
	{
		$validator = new \libphpvin\Format\Iso3779\Validator();

		$result = $validator->validate($vin);

		$this->assertSame($expecting, $result->isValid());
		$this->assertSame($errors, $result->getErrors());
		$this->assertSame(count($errors), count($result));
		$this->assertSame($errors, $result->getIterator()->getArrayCopy());
	}

	public function providerIsValid()
	{
		return array(
			array(new \libphpvin\Format\Iso3779\EuUsa\Large('SCCEK88C9GH468417'), true),
			array(new \libphpvin\Format\Iso3779\EuUsa\Large('AF1D9K80D1N836483'), true),
			array(new \libphpvin\Format\Iso3779\EuUsa\Large('ABCDEFGH123456789'), true),

			// Short
			array(new \libphpvin\Format\Iso3779\EuUsa\Large('ABCDEFGH12345678'), false, array(\libphpvin\Format\Iso3779\Validator::ERROR_TOO_SHORT)),
			array(new \libphpvin\Format\Iso3779\EuUsa\Large('A'), false, array(\libphpvin\Format\Iso3779\Validator::ERROR_TOO_SHORT)),

			// Long
			array(new \libphpvin\Format\Iso3779\EuUsa\Large('ABCDEFGH1234567890'), false, array(\libphpvin\Format\Iso3779\Validator::ERROR_TOO_LONG)),

			// Invalid character
			array(new \libphpvin\Format\Iso3779\EuUsa\Large("ABCDEFGH123456\nL2"), false, array(\libphpvin\Format\Iso3779\Validator::ERROR_NON_ALPHANUMERIC)),

			// Non permitted letters
			array(new \libphpvin\Format\Iso3779\EuUsa\Large('ABCDEFGHI23456789'), false, array(\libphpvin\Format\Iso3779\Validator::ERROR_PROHIBITED_I)),
			array(new \libphpvin\Format\Iso3779\EuUsa\Large('ABCDEFGH1234O6789'), false, array(\libphpvin\Format\Iso3779\Validator::ERROR_PROHIBITED_O)),
			array(new \libphpvin\Format\Iso3779\EuUsa\Large('ABQDEFGH123456789'), false, array(\libphpvin\Format\Iso3779\Validator::ERROR_PROHIBITED_Q)),
		);
	}
}
