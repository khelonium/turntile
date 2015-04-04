<?php
namespace Refactoring\Turnstile\Exception;

class UnknownEvent extends \DomainException
{

    public function __construct($event)
    {
        parent::__construct("No such event ".$event);
    }
}