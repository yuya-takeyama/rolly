<?php
/**
 * This file is part of Rolly.
 *
 * (c) Yuya Takeyama <sign.of.the.wolf.pentagram@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once 'Rolly/UnitAbstract.php';
require_once 'Rolly/ActiveIfDefinitions.php';

class Rolly_Tests_Units_Enabled extends Rolly_UnitAbstract
{
    public function configure()
    {
        $this->activeIf('enabled');
    }
}

class Rolly_Tests_Units_Disabled extends Rolly_UnitAbstract
{
    public function configure()
    {
        $this->activeIf('disabled');
    }
}

class Rolly_Tests_Units_AllEnabled extends Rolly_UnitAbstract
{
    public function configure()
    {
        $this->activeIf('enabled', 'enabled');
    }
}

class Rolly_Tests_Units_PartlyEnabled extends Rolly_UnitAbstract
{
    public function configure()
    {
        $this->activeIf('enabled', 'disabled');
    }
}

class Rolly_Tests_UnitTest extends PHPUnit_Framework_TestCase
{
    private $definitions;

    public function setUp()
    {
        $this->definitions = new Rolly_ActiveIfDefinitions;
        $this->definitions['enabled']  = create_function('', 'return true;');
        $this->definitions['disabled'] = create_function('', 'return false;');
    }

    /**
     * @test
     */
    public function isActive_should_be_true_if_the_definition_set_by_activeIf_is_active()
    {
        $unit = new Rolly_Tests_Units_Enabled(array(
            'definitions' => $this->definitions,
        ));
        $this->assertTrue($unit->isActive());
    }

    /**
     * @test
     */
    public function isActive_should_be_false_if_the_definition_set_by_activeIf_is_not_active()
    {
        $unit = new Rolly_Tests_Units_Disabled(array(
            'definitions' => $this->definitions,
        ));
        $this->assertFalse($unit->isActive());
    }

    /**
     * @test
     */
    public function isActive_should_be_true_if_the_definition_set_by_activeIf_is_all_active()
    {
        $unit = new Rolly_Tests_Units_AllEnabled(array(
            'definitions' => $this->definitions,
        ));
        $this->assertTrue($unit->isActive());
    }

    /**
     * @test
     */
    public function isActive_should_be_false_if_the_definition_set_by_activeIf_is_partly_active()
    {
        $unit = new Rolly_Tests_Units_PartlyEnabled(array(
            'definitions' => $this->definitions,
        ));
        $this->assertFalse($unit->isActive());
    }
}
