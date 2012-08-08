<?php
/**
 * This file is part of Rolly.
 *
 * (c) Yuya Takeyama <sign.of.the.wolf.pentagram@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once 'Rolly/ActiveIfDefinitions.php';

/**
 * Facade for Rolly.
 *
 * @author Yuya Takeyama
 */
class Rolly_Facade
{
    private $definitions;

    private $config;

    /**
     * @var array
     */
    private $units;

    public function __construct()
    {
        $this->definitions = isset($params['definitions']) ?
            $params['definitions'] :
            new Rolly_ActiveIfDefinitions;
        $this->config = $params['config'];
    }

    public function getUnit($name)
    {
        if (! array_key_exists($name, $this->units)) {
            $this->loadUnit($name);
        }
        return $this->units[$name];
    }

    public function invoke($unitName, $method)
    {
        $unit = $this->getUnit($unitName);
        if ($unit->isActive()) {
            return call_user_func(array($unit, $method));
        }
    }

    private function loadUnit($name)
    {
        require_once $this->config['units_dir'] . DIRECTORY_SEPARATOR .
            $name . DIRECTORY_SEPARATOR . "Initializer.php";
        $klass = $this->config['unit_clsas_prefix'] . $this->getClassSeparator() .
            $name . $this->getClassSeparator() . 'Initializer';
        $this->units[$name] = new $klass(array(
            'definitions' => $this->definitions,
        ));
    }

    private getClassSeparator()
    {
        return isset($this->config['class_separator']) ? $this->config['class_separator'] : '\\';
    }
}
