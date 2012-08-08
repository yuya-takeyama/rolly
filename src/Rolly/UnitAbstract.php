<?php
/**
 * This file is part of Rolly.
 *
 * (c) Yuya Takeyama <sign.of.the.wolf.pentagram@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once dirname(__FILE__) . '/UnitInterface.php';

/**
 * Abstract class off Rolly's feature unit.
 *
 * @author Yuya Takeyama
 */
abstract class Rolly_UnitAbstract implements Rolly_UnitInterface
{
    /**
     * @var Rolly_ActiveIfDefinitions
     */
    private $definitions;

    /**
     * @var array
     */
    private $activeIf;

    /**
     * Constructor.
     *
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        $this->definitions = $params['definitions'];
        $this->configure();
    }

    public function activeIf()
    {
        $args = func_get_args();
        $this->activeIf = $args;
    }

    public function isActive()
    {
        foreach ($this->activeIf as $name) {
            $definition = $this->definitions[$name];
            if (! $definition->isActive()) {
                return false;
            }
        }
        return true;
    }

    abstract public function configure();
}
