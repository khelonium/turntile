<?php namespace Refactoring\Turnstile;

interface Turnstile
{

    public function lock();

    public function unlock();

    public function alert();

    public function thanks();
}