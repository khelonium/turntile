<?php
namespace Refactoring\Turnstile;

use Refactoring\Turnstile\FSM\StateImplementation;

interface State
{
    public function pass(StateImplementation $fsm);

    public function coin(StateImplementation $fsm);
}