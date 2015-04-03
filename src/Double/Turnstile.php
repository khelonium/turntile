<?php
namespace Refactoring\Turnstile\Double;

class Turnstile
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