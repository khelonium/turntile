<?php namespace Refactoring\Turnstile;

use Refactoring\Turnstile\Double\Turnstile;

class FSM
{

    const PASS = 'PASS';
    const COIN = 'COIN';

    private $state = STATE::LOCKED;

    private $events = [
        self::PASS,
        self::COIN
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

        if (false === array_search($event, $this->events)) {
            throw new \DomainException("Unknown event " . $event);
        }

        switch ($this->state) {
            case State::LOCKED:
                switch ($event) {
                    case self::COIN:
                        $this->state = State::UNLOCKED;
                        $this->turnstile->unlock();
                        break;
                    case self::PASS:
                        $this->turnstile->alert();
                        break;
                }
                break;
            case State::UNLOCKED:
                switch ($event) {
                    case self::COIN:
                        $this->turnstile->thanks();
                        break;
                    case self::PASS:
                        $this->state = State::LOCKED;
                        $this->turnstile->lock();
                        break;
                }
                break;
        }


    }
}