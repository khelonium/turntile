<?php namespace Refactoring\Turnstile\FSM\State;

use Refactoring\Turnstile\Double\Turnstile;
use Refactoring\Turnstile\FSM;
use Refactoring\Turnstile\FSM\Pattern;
use Refactoring\Turnstile\FSM\TestablePattern;
use Refactoring\Turnstile\FSM\State;
use Refactoring\Turnstile\States;

class Locked implements State
{

    /**
     * @var Turnstile
     */
    private $turnstile = null;

    public function __construct(Turnstile $turnstile)
    {
        $this->turnstile = $turnstile;
    }


    public function pass(Pattern $fsm)
    {
        $this->turnstile->alert();
    }

    public function coin(Pattern $fsm)
    {
        $this->turnstile->unlock();
        $fsm->setState(States::UNLOCKED);
    }
}