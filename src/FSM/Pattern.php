<?php
namespace Refactoring\Turnstile\FSM;

use Refactoring\Turnstile\Double\Turnstile;
use Refactoring\Turnstile\Exception\InvalidState;
use Refactoring\Turnstile\FSM\State\Locked;
use Refactoring\Turnstile\FSM\State\Unlocked;
use Refactoring\Turnstile\States;

class Pattern
{

    /**
     * @var State
     */
    private $state = null;

    /**
     * @var
     */
    private $turnstile;


    public function __construct(Turnstile $turnstile)
    {

        $this->turnstile = $turnstile;
        $this->setState(States::LOCKED);
    }

    public function setState($state)
    {

        switch ($state) {
            case States::LOCKED:
                $this->state = new Locked($this->turnstile);
                break;
            case States::UNLOCKED:
                $this->state = new Unlocked($this->turnstile);
                break;
            default:
                throw new InvalidState($state);
                break;
        }
    }

    public function pass()
    {
        $this->state->pass($this);
    }

    public function coin()
    {
        $this->state->coin($this);
    }
}