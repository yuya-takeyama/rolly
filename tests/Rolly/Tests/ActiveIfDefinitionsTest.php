<?php
/**
 * This file is part of Rolly.
 *
 * (c) Yuya Takeyama <sign.of.the.wolf.pentagram@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once 'Rolly/ActiveIf.php';
require_once 'Rolly/ActiveIfDefinitions.php';

class Rolly_Tests_ActiveIfDefinitionsTest extends PHPUnit_Framework_TestCase
{
    private $definitions;

    public function setUp()
    {
        $this->definitions = new Rolly_ActiveIfDefinitions;
    }

    /**
     * @test
     */
    public function offsetSet_store_callback_as_an_ActiveIf_Object()
    {
        $this->definitions['foo'] = create_function('', 'return true;');
        $this->assertInstanceOf('Rolly_ActiveIf', $this->definitions['foo']);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function offsetSet_should_throw_InvalidArgumentException_if_callback_is_not_callable()
    {
        $this->definitions['foo'] = 'not a callable';
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function offsetSet_should_throw_RuntimeException_if_the_name_is_used_already()
    {
        $this->definitions['foo'] = create_function('', 'return true;');
        $this->definitions['foo'] = create_function('', 'return true;');
    }
}
