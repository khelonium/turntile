<?php
namespace Refactoring\Turnstile;

use Refactoring\Turnstile\FSM\SwitchImplementation;

require_once 'AbstractTurnstileTest.php';

class TurnstileFSMTest extends AbstractTurnstileTest
{
    protected function buildStateMachine()
    {
        return new SwitchImplementation($this->turnstile);
    }


}

