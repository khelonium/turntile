<?php
namespace Table;

use Refactoring\Turnstile\FSM\Table\Transition;

class TransitionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Transition
     */
    public $transition;
    private $actionCalled = false;

    public function setUp()
    {
        $this->transition = new \Refactoring\Turnstile\FSM\Table\Transition('current', 'event', 'next', function () {
            $this->action();
        });
    }

    /**
    * @test
    */
    public function itCanMatch()
    {

        $this->assertFalse($this->transition->match('anotherState', 'event'));
        $this->assertFalse($this->transition->match('current', 'anotherEvent'));
        $this->assertTrue($this->transition->match('current', 'event'));
    }

    /**
     * @test
     */
    public function itCanAccept()
    {
        $this->transition->accept($this);
        $this->assertTrue($this->actionCalled);
    }

    public function action()
    {
        $this->actionCalled = true;
    }



}
