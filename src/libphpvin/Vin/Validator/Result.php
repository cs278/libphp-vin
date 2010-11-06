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
 * @subpackage	Vin\Validator
 * @copyright	Copyright (c) 2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 * @version		
 */
namespace libphpvin\Vin\Validator;

/**
 * @package		libphp-vin
 * @subpackage	Vin\Validator
 * @copyright	Copyright (c) 2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Result implements \IteratorAggregate, \Countable, \libphpvin\Validatable
{
	protected $_errors = array();
	protected $_vin;

	public function __construct(\libphpvin\Vin $vin)
	{
		$this->_vin = $vin;
	}

	public function isValid()
	{
		return empty($this->_errors);
	}

	public function addError($message)
	{
		$this->_errors[] = $message;

		return $this;
	}

	public function getErrors()
	{
		return $this->_errors;
	}

	public function count()
	{
		return count($this->_errors);
	}

	public function getIterator()
	{
		return new ArrayIterator($this->getErrors());
	}
}
