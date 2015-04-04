<?php namespace Refactoring\Turnstile\FSM;

use Refactoring\Turnstile\Double\Turnstile;
use Refactoring\Turnstile\Event;
use Refactoring\Turnstile\FSM;
use Refactoring\Turnstile\State;

/**
 * Would have named this Switch but it is a reserved word
 * Class SwitchImplementation
 * @package Refactoring\Turnstile\FSM
 */
class SwitchImplementation implements FSM
{

    private $state = State::LOCKED;

    /**
     * @var Turnstile
     */
    private $turnstile = null;

    public function __construct(Turnstile $turnstile)
    {
        $this->turnstile = $turnstile;
    }


    public function handle($event)
    {


        switch ($this->state) {
            case State::LOCKED:
                switch ($event) {
                    case Event::COIN:
                        $this->state = State::UNLOCKED;
                        $this->turnstile->unlock();
                        break;
                    case Event::PASS:
                        $this->turnstile->alert();
                        break;
                    default:
                        $this->raiseUnknown($event);
                        break;
                }
                break;
            case State::UNLOCKED:
                switch ($event) {
                    case Event::COIN:
                        $this->turnstile->thanks();
                        break;
                    case Event::PASS:
                        $this->state = State::LOCKED;
                        $this->turnstile->lock();
                        break;
                    default:
                        $this->raiseUnknown($event);
                        break;
                }
                break;
        }


    }

    /**
     * @param $event
     */
    private function raiseUnknown($event)
    {
        throw new \DomainException("Unknown event " . $event);
    }
}