<?php

namespace vennv;

final class ChildLoop {

    public function __construct(
        private int $id,
        private \Fiber $fiber, 
        private float $timeOut, 
        private float $timeCurrent,
        private int $status,
        private mixed $return = null
    ) {}

    public function getId() : int 
    {
        return $this->id;
    }

    public function getFiber() : \Fiber 
    {
        return $this->fiber;
    }

    public function getTimeOut() : float 
    {
        return $this->timeOut;
    }

    public function getTimeCurrent() : float 
    {
        return $this->timeCurrent;
    }

    public function getStatus() : int 
    {
        return $this->status;
    }

    public function setStatus(int $status) : ChildLoop 
    {
        $this->status = $status;
        return $this;
    }

    public function getReturn() : mixed 
    {
        return $this->return;
    }

    public function setReturn(mixed $return) : ChildLoop 
    {
        $this->return = $return;
        return $this;
    }

}