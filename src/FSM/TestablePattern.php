<?php namespace Refactoring\Turnstile\FSM;

use Refactoring\Turnstile\Event;
use Refactoring\Turnstile\Exception\UnknownEvent;
use Refactoring\Turnstile\FSM;

class TestablePattern extends Pattern implements FSM
{

    public function handle($event)
    {
        switch ($event) {
            case Event::PASS:
                $this->pass($this);
                break;

            case Event::COIN:
                $this->coin($this);
                break;
            default:
                throw new UnknownEvent($event);
                break;
        }
    }
}