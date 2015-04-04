<?php namespace Refactoring\Turnstile;

use Refactoring\Turnstile\Double\Turnstile;

class FSMSwitch
{

    private $state = STATE::LOCKED;

    private $events = [
        Event::PASS,
        Event::COIN
    ];

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