<?php namespace Refactoring\Turnstile\FSM;

use Refactoring\Turnstile\Double\Turnstile;
use Refactoring\Turnstile\Event;
use Refactoring\Turnstile\FSM;
use Refactoring\Turnstile\States;

/**
 * Would have named this Switch but it is a reserved word
 * Class SwitchImplementation
 * @package Refactoring\Turnstile\FSM
 */
class SwitchImplementation implements FSM
{

    private $state = States::LOCKED;

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
            case States::LOCKED:
                switch ($event) {
                    case Event::COIN:
                        $this->state = States::UNLOCKED;
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
            case States::UNLOCKED:
                switch ($event) {
                    case Event::COIN:
                        $this->turnstile->thanks();
                        break;
                    case Event::PASS:
                        $this->state = States::LOCKED;
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