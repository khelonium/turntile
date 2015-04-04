<?php
namespace Refactoring\Turnstile\Table;

class Transition 
{

    private $currentState   = null;
    public $nextState      = null;
    private $event          = null;

    /**
     * @var \Closure
     */
    private  $action        = null;

    public function __construct($currentState, $event, $nextState, $action)
    {
        $this->currentState = $currentState;
        $this->nextState = $nextState;
        $this->event = $event;
        $this->action = $action;
    }

    public function match($state, $event)
    {
        return ($this->currentState == $state) && ($this->event == $event);
    }

    public function accept($fsm)
    {
        $closure = $this->action;
        $closure($fsm);
    }


}