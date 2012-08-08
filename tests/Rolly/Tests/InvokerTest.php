<?php
/**
 * This file is part of Rolly.
 *
 * (c) Yuya Takeyama <sign.of.the.wolf.pentagram@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once 'Rolly/Invoker.php';
require_once 'Rolly/ActiveIfDefinitions.php';
require_once 'Rolly/ActiveIf.php';
require_once 'Rolly/UnitAbstract.php';

class Rolly_Tests_Units_Foo extends Rolly_UnitAbstract
{
    public function configure()
    {
        $this->activeIf('foo');
    }

    public function getFoo()
    {
        return 'foo';
    }
}

class Rolly_Tests_InvokerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function isActive_should_be_true_if_the_unit_is_active()
    {
        $unit    = $this->createActiveUnit();
        $invoker = new Rolly_Invoker($unit);
        $this->assertTrue($invoker->isActive());
    }

    /**
     * @test
     */
    public function isActive_should_be_false_if_the_unit_is_inactive()
    {
        $unit    = $this->createInactiveUnit();
        $invoker = new Rolly_Invoker($unit);
        $this->assertFalse($invoker->isActive());
    }

    /**
     * @test
     */
    public function called_method_should_be_invoked_if_the_unit_is_active()
    {
        $unit    = $this->createActiveUnit();
        $invoker = new Rolly_Invoker($unit);
        $this->assertEquals('foo', $invoker->getFoo());
    }

    /**
     * @test
     */
    public function called_method_should_NULL_if_the_unit_is_inactive()
    {
        $unit    = $this->createInactiveUnit();
        $invoker = new Rolly_Invoker($unit);
        $this->assertNull($invoker->getFoo());
    }

    private function createActiveUnit()
    {
        $definitions = new Rolly_ActiveIfDefinitions;
        $definitions['foo'] = create_function('', 'return true;');
        return new Rolly_Tests_Units_Foo(array(
            'definitions' => $definitions,
        ));
    }

    private function createInactiveUnit()
    {
        $definitions = new Rolly_ActiveIfDefinitions;
        $definitions['foo'] = create_function('', 'return false;');
        return new Rolly_Tests_Units_Foo(array(
            'definitions' => $definitions,
        ));
    }
}
