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
namespace libphpvin;

/**
 * @package		libphp-vin
 * @copyright	Copyright (c) 2010 Chris Smith (http://www.cs278.org/)
 * @license		http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Autoloader
{
	protected $_namespace;
	protected $_namespaceSeparator = self::DEFAULT_NAMESPACE_SEPARATOR;

	protected $_path;

	protected $_extension = self::DEFAULT_EXTENSION;

	const DEFAULT_EXTENSION = '.php';
	const DEFAULT_NAMESPACE_SEPARATOR = '\\';

	static public function factory($namespace = null, $path = null)
	{
		return new self($namespace, $path);
	}

	public function __construct($namespace = null, $path = null)
	{
		$this->setNamespace($namespace);
		$this->setPath($path);
	}

	public function getNamespace()
	{
		return $this->_namespace;
	}

	public function setNamespace($namespace)
	{
		$this->_namespace = $namespace;

		return $this;
	}

	public function getNamespaceSeparator()
	{
		return $this->_namespaceSeparator;
	}

	public function setNamespaceSeparator($namespaceSeparator)
	{
		$this->_namespaceSeparator = (strlen($namespaceSeparator) > 0) ? $namespaceSeparator : null;

		return $this;
	}

	public function getPath()
	{
		return $this->_path;
	}

	public function setPath($path)
	{
		$this->_path = $path;

		return $this;
	}

	public function getExtension()
	{
		return $this->_extension;
	}

	public function setExtension($extension)
	{
		$this->_extension = $extension;

		return $this;
	}

	public function register($prepend = false)
	{
		return spl_autoload_register(array($this, 'loadClass'), true, $prepend);
	}

	public function unregister()
	{
		return spl_autoload_unregister(array($this, 'loadClass'));
	}

	public function loadClass($class)
	{
		if ($this->_namespace === null || strpos($class, $this->_namespace . $this->_namespaceSeparator) === 0)
		{
			$file = $namespace = '';

			if ($this->_namespace !== null)
			{
				$namespace = explode($this->_namespaceSeparator, $class);

				$class = array_pop($namespace);

				$file = implode(DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
			}

			$file .= str_replace('_', DIRECTORY_SEPARATOR, $class) . $this->_extension;

			$file = ($this->_path !== null ? $this->_path . DIRECTORY_SEPARATOR : '') . $file;

			require $file;
		}
	}
}
