<?php
/**
 * This file is part of Rolly.
 *
 * (c) Yuya Takeyama <sign.of.the.wolf.pentagram@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Acts as proxy of Rolly_Unit and invoke its method if it is active.
 *
 * @author Yuya Takeyama
 */
class Rolly_Invoker
{
    /**
     * @var Rolly_UnitInterface
     */
    private $unit;

    public function __construct(Rolly_UnitInterface $unit)
    {
        $this->unit = $unit;
    }

    public function isActive()
    {
        return $this->unit->isActive();
    }

    public function __call($method, $args)
    {
        if ($this->isActive()) {
            return call_user_func_array(array($this->unit, $method), $args);
        }
    }
}
