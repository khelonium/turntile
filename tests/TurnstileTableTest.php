<?php
namespace Refactoring\Turnstile;

use Refactoring\Turnstile\Table\Transition;

require_once 'AbstractTurnstileTest.php';

class TurnstileTableTest extends AbstractTurnstileTest
{
    protected function buildStateMachine()
    {
        return new FsmTable($this->turnstile);
    }


}
