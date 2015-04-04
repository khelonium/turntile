<?php namespace Refactoring\Turnstile\FSM\State;

use Refactoring\Turnstile\Double\Turnstile;
use Refactoring\Turnstile\FSM\StateImplementation;
use Refactoring\Turnstile\State;
use Refactoring\Turnstile\States;

class Unlocked implements State
{

    /**
     * @var Turnstile
     */
    private $turnstile = null;

    public function __construct(Turnstile $turnstile)
    {
        $this->turnstile = $turnstile;
    }

    public function pass(StateImplementation $fsm)
    {
        $this->turnstile->lock();
        $fsm->setState(States::LOCKED);
    }

    public function coin(StateImplementation $fsm)
    {
        $this->turnstile->thanks();
    }
}