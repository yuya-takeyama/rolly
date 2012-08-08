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
 * Collection of Rolly_ActiveIf
 *
 * @author Yuya Takeyama
 */
class Rolly_ActiveIfDefinitions implements ArrayAccess
{
    private $callbacks = array();

    public function offsetSet($key, $value)
    {
        if (isset($this[$key])) {
            throw new RuntimeException(
                sprintf('ActiveIf definition named "%s" is defined already', $key)
            );
        } else if (!is_callable($value)) {
            throw new InvalidArgumentException('Callback should be callable');
        }
        $this->callbacks[$key] = new Rolly_ActiveIf(array(
            'definitions' => $this,
            'callback'    => $value,
        ));
    }

    public function offsetGet($key)
    {
        if (!isset($this[$key])) {
            throw new RuntimeException(
                sprintf('ActiveIf definition named "%s" is not defined', $key)
            );
        }
        return $this->callbacks[$key];
    }

    public function offsetExists($key)
    {
        return array_key_exists($key, $this->callbacks);
    }

    public function offsetUnset($key)
    {
        throw new BadMethodCallException('Operation not allowed');
    }
}
