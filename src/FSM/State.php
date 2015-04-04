<?php
namespace Refactoring\Turnstile\FSM;


interface State
{
    public function pass(Pattern $fsm);

    public function coin(Pattern $fsm);
}