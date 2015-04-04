<?php
namespace Refactoring\Turnstile;

require_once 'AbstractTurnstileTest.php';

class TurnstileTableTest extends AbstractTurnstileTest
{
    protected function buildStateMachine()
    {
        return new FsmTable($this->turnstile);
    }

}
