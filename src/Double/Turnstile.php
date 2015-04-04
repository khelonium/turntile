<?php
namespace Refactoring\Turnstile\Double;

use Refactoring\Turnstile\Turnstile as TurnstileInterface;

class Turnstile implements TurnstileInterface
{

    public $history = '';

    public function lock()
    {
        $this->history .= 'L';
    }

    public function unlock()
    {
        $this->history .= 'U';
    }

    public function alert()
    {
        $this->history .= 'A';
    }

    public function thanks()
    {
        $this->history .= 'T';
    }
}