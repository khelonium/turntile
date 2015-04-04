<?php
namespace Refactoring\Turnstile;

use Refactoring\Turnstile\Double\Turnstile;
use Refactoring\Turnstile\FSM\Table;

require_once 'AbstractTurnstileTest.php';

class TurnstileStatePatternTest extends AbstractTurnstileTest
{
    protected function buildStateMachine()
    {
        return new FSM\TestablePattern($this->turnstile);
    }

}

