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

class Rolly_Tests_ActiveIfTest extends PHPUnit_Framework_TestCase
{
    private $definitions;

    public function setUp()
    {
        $this->definitions = new Rolly_ActiveIfDefinitions;
    }

    /**
     * @test
     */
    public function isActive_should_be_true_when_the_callback_returns_true()
    {
        $activeIf = $this->create(create_function('', 'return true;'));
        $this->assertTrue($activeIf->isActive());
    }

    /**
     * @test
     */
    public function isActive_should_be_false_when_the_callback_returns_false()
    {
        $activeIf = $this->create(create_function('', 'return false;'));
        $this->assertFalse($activeIf->isActive());
    }

    public function create($callback)
    {
        return new Rolly_ActiveIf(array(
            'definitions' => $this->definitions,
            'callback'    => $callback,
        ));
    }
}
