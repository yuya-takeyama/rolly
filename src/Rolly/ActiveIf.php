<?php
/**
 * This file is part of Rolly.
 *
 * (c) Yuya Takeyama <sign.of.the.wolf.pentagram@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Rolly_ActiveIf
{
    /**
     * @var Rolly_ActiveIfDefinitions
     */
    private $definitions;

    /**
     * @var callable
     */
    private $callback;

    /**
     * Constructor.
     *
     * @param  array
     */
    public function __construct(array $params = array())
    {
        $this->definitions = $params['definitions'];
        $this->callback    = $params['callback'];
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return call_user_func($this->callback, $this->definitions);
    }
}
