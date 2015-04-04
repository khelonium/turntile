<?php namespace Refactoring\Turnstile\FSM;

use Refactoring\Turnstile\Event;
use Refactoring\Turnstile\FSM;
use Refactoring\Turnstile\States;
use Refactoring\Turnstile\FSM\Table\Transition;
use Refactoring\Turnstile\Turnstile;

class Table implements FSM
{
    /**
     * @var Turnstile
     */
    private $turnstile = null;

    protected $transitions = [];
    private $state = States::LOCKED;

    public function __construct($turnstile)
    {
        $this->turnstile = $turnstile;

        $this->transitions[] = new Transition(States::LOCKED, Event::PASS, States::LOCKED, function () {
            $this->alert();
        });
        $this->transitions[] = new Transition(States::LOCKED, Event::COIN, States::UNLOCKED, function () {
            $this->unlock();
        });
        $this->transitions[] = new Transition(States::UNLOCKED, Event::COIN, States::UNLOCKED, function () {
            $this->thanks();
        });

        $this->transitions[] = new Transition(States::UNLOCKED, Event::PASS, States::LOCKED, function () {
            $this->lock();
        });

    }


    public function handle($event)
    {

        $this->checkEvent($event);

        /** @var \Refactoring\Turnstile\FSM\Table\Transition $transition */
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