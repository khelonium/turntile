<?php
namespace Refactoring\Turnstile\Exception;

class InvalidState extends \DomainException
{

    public function __construct($state)
    {
        parent::__construct("No such state $state");
    }
}