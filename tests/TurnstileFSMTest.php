<?php
namespace Refactoring\Turnstile;

require_once 'AbstractTurnstileTest.php';

class TurnstileFSMTest extends AbstractTurnstileTest
{
    protected function buildStateMachine()
    {
        return new FSMSwitch($this->turnstile);
    }


}

