<?php namespace Refactoring\Turnstile;

interface FSM
{
    public function handle($event);
}