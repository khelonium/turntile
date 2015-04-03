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
     * @var FSM
     */
    private $fsm;

    /**
    * @before
    */
    public function construct()
    {
        $this->turnstile = new Turnstile();
        $this->fsm = new FSM($this->turnstile);
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
        $this->fsm->handle(FSM::COIN);
        $this->fsm->handle(FSM::PASS);
        $this->assertEquals('UL', $this->turnstile->history);

    }

    /**
     * @test
     */
    public function integrationTest()
    {
        $this->fsm->handle(FSM::PASS);
        $this->fsm->handle(FSM::PASS);
        $this->fsm->handle(FSM::PASS);
        $this->fsm->handle(FSM::COIN);
        $this->fsm->handle(FSM::COIN);
        $this->fsm->handle(FSM::COIN);
        $this->fsm->handle(FSM::PASS);
        $this->fsm->handle(FSM::PASS);
        $this->fsm->handle(FSM::PASS);
        $this->fsm->handle(FSM::COIN);
        $this->assertEquals('AAAUTTLAAU', $this->turnstile->history);

    }
}

