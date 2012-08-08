<?php
/**
 * This file is part of Rolly.
 *
 * (c) Yuya Takeyama <sign.of.the.wolf.pentagram@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once dirname(__FILE__) . '/ActiveIfDefinitions.php';
require_once dirname(__FILE__) . '/Invoker.php';

/**
 * Facade for Rolly.
 *
 * @author Yuya Takeyama
 */
class Rolly_Facade implements ArrayAccess
{
    private $definitions;

    private $config;

    /**
     * @var array
     */
    private $units;

    public function __construct(array $params = array())
    {
        $this->definitions = isset($params['definitions']) ?
            $params['definitions'] :
            new Rolly_ActiveIfDefinitions;
        $this->config = $params['config'];
        $this->units  = array();
    }

    public function offsetGet($key)
    {
        return $this->getUnit($key);
    }

    public function offsetSet($key, $value)
    {
        throw new BadMethodCallException('Operation not allowed');
    }

    public function offsetExists($key)
    {
        if (! array_key_exists($key, $this->units)) {
            $this->loadUnit($key);
        }
        return array_key_exists($key, $this->units);
    }

    public function offsetUnset($key)
    {
        throw new BadMethodCallException('Operation not allowed');
    }

    public function getUnit($name)
    {
        if (! array_key_exists($name, $this->units)) {
            $this->loadUnit($name);
        }
        return $this->units[$name];
    }

    public function isUnitActive($unitName)
    {
        return $this->getUnit($unitName)->isActive();
    }

    private function loadUnit($name)
    {
        require_once $this->config['units_dir'] . DIRECTORY_SEPARATOR .
            $name . DIRECTORY_SEPARATOR . "Initializer.php";
        $klass = $this->config['unit_class_prefix'] . $this->getClassSeparator() .
            $name . $this->getClassSeparator() . 'Initializer';
        $this->units[$name] = new Rolly_Invoker(new $klass(array(
            'definitions' => $this->definitions,
        )));
    }

    private function getClassSeparator()
    {
        return isset($this->config['class_separator']) ? $this->config['class_separator'] : '\\';
    }
}
