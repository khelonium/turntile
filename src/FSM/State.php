<?php
namespace Refactoring\Turnstile\FSM;


interface State
{
    public function pass(StateImplementation $fsm);

    public function coin(StateImplementation $fsm);
}