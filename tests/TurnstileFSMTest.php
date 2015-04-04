<?php
namespace Refactoring\Turnstile;

use Refactoring\Turnstile\Double\Turnstile;

class TurnstileFSMTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Turnstile
     */
    public $turnstile;
    /**
     * @var FSMSwitch
     */
    private $fsm;

    /**
    * @before
    */
    public function construct()
    {
        $this->turnstile = new Turnstile();
        $this->fsm = new FSMSwitch($this->turnstile);
    }

    /**
     * @test
     * @expectedException \DomainException
     */
    public function unknownEventsAreNotHandled()
    {
        $this->fsm->handle("WHAT");
    }

    /**
     * @test
     */
    public function theDefaultStateIsLocked()
    {
        $this->fsm->handle('PASS');
        $this->assertEquals('A', $this->turnstile->history);
    }

    /**
     * @test
     */
    public function aCoinWillUnlock()
    {
        $this->fsm->handle('COIN');
        $this->assertEquals('U', $this->turnstile->history);
    }

    /**
     * @test
     */
    public function ACounAFterACoinWillBeThanked()
    {
        $this->fsm->handle('COIN');
        $this->fsm->handle('COIN');
        $this->assertEquals('UT', $this->turnstile->history);

    }

    /**
     * @test
     */
    public function afterWePassWeLock()
    {
        $this->fsm->handle(Event::COIN);
        $this->fsm->handle(Event::PASS);
        $this->assertEquals('UL', $this->turnstile->history);

    }

    /**
     * @test
     */
    public function integrationTest()
    {
        $this->fsm->handle(Event::PASS);
        $this->fsm->handle(Event::PASS);
        $this->fsm->handle(Event::PASS);
        $this->fsm->handle(Event::COIN);
        $this->fsm->handle(Event::COIN);
        $this->fsm->handle(Event::COIN);
        $this->fsm->handle(Event::PASS);
        $this->fsm->handle(Event::PASS);
        $this->fsm->handle(Event::PASS);
        $this->fsm->handle(Event::COIN);
        $this->assertEquals('AAAUTTLAAU', $this->turnstile->history);

    }
}

