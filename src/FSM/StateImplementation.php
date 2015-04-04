<?php namespace Refactoring\Turnstile\FSM;

use Refactoring\Turnstile\Double\Turnstile;
use Refactoring\Turnstile\Event;
use Refactoring\Turnstile\Exception\InvalidState;
use Refactoring\Turnstile\Exception\UnknownEvent;
use Refactoring\Turnstile\FSM;
use Refactoring\Turnstile\FSM\State\Locked;
use Refactoring\Turnstile\FSM\State\Unlocked;
use Refactoring\Turnstile\States;

class StateImplementation implements FSM
{

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

    public function handle($event)
    {
        switch ($event) {
            case Event::PASS:
                $this->state->pass($this);
                break;

            case Event::COIN:
                $this->state->coin($this);
                break;
            default:
                throw new UnknownEvent($event);
                break;
        }
    }
}