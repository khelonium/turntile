<?php
namespace Refactoring\Turnstile;

use Refactoring\Turnstile\FSM\Table;
use Refactoring\Turnstile\FSM\Table\Transition;

require_once 'AbstractTurnstileTest.php';

class TurnstileTableTest extends AbstractTurnstileTest
{
    protected function buildStateMachine()
    {
        return new Table($this->turnstile);
    }


}
