<?php namespace Refactoring\Turnstile;

use Refactoring\Turnstile\Table\Transition;

class FsmTable
{
    /**
     * @var Turnstile
     */
    private $turnstile = null;

    protected $transitions = [];
    private $state = State::LOCKED;

    public function __construct($turnstile)
    {
        $this->turnstile = $turnstile;

        $unlock = function ($turnstile) {
            $turnstile->unlock();
        };

        $lock = function ($turnstile) {
            $turnstile->lock();
        };

        $alarm = function ($turnstile) {
            $turnstile->alert();
        };

        $thanks = function ($turnstile) {
            $turnstile->thanks();
        };

        $this->transitions[] = new Transition(State::LOCKED, Event::PASS, State::LOCKED, $alarm);
        $this->transitions[] = new Transition(State::LOCKED, Event::COIN, State::UNLOCKED, $unlock);
        $this->transitions[] = new Transition(State::UNLOCKED, Event::COIN, State::UNLOCKED, $thanks);
        $this->transitions[] = new Transition(State::UNLOCKED, Event::PASS, State::LOCKED, $lock);

    }


    public function handle($event)
    {

        $this->checkEvent($event);

        /** @var Transition $transition */
        foreach ($this->transitions as $transition) {
            if ($transition->match($this->state, $event)) {
                $transition->accept($this->turnstile);
                $this->state = $transition->nextState;
                break;
            }
        }


    }

    private function checkEvent($event)
    {
        if (false === array_search($event, [Event::COIN, Event::PASS])) {
            throw new \DomainException("No Such Event $event");
        }
    }
}