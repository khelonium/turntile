Tuntile State Machine
---------------------
Initial State is Locked

State, Event, New State, Action
Lock, Coin, Unlock, unlock()
Lock, Pass, Lock, alarm()
Unlock, Pass,Lock, lock()
Unlock, Coin, Unlock, thanks()


To implement
------
- switch implementation
- Table Driven
- state pattern implementation
