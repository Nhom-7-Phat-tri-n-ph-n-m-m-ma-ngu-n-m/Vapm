<?php

namespace vennv;

use Fiber;
use Throwable;

interface InterfaceQueue
{

    /**
     * This method to get the id for the queue.
     */
    public function getId() : int;

    /**
     * This method to get the fiber for the queue.
     */
    public function getFiber() : Fiber;

    /**
     * This method to get the timeout for the queue.
     */
    public function getTimeOut() : float;

    /**
     * This method to get the status for the queue.
     */
    public function getStatus() : StatusQueue;

    /**
     * This method to set the status for the queue.
     */
    public function setStatus(StatusQueue $status) : void;

    /**
     * This method to check if the queue is a promise.
     */
    public function isPromise() : bool;

    /**
     * This method to get the time start for the queue.
     */
    public function getTimeStart() : float;

    /**
     * This method to get result of a queue.
     */
    public function getReturn() : mixed;

    /**
     * This method to set result of a queue.
     */
    public function setReturn(mixed $return) : void;

    /**
     * @throws Throwable
     *
     * This method to run a callback for a queue when the queue is fulfilled.
     */
    public function useCallableResolve(mixed $result) : void;

    /**
     * This method to set a callback resolve for a queue.
     */
    public function setCallableResolve(callable $callableResolve) : Queue;

    /**
     * @throws Throwable
     *
     * This method to run a callback for a queue when the queue is rejected.
     */
    public function useCallableReject(mixed $result) : void;

    /**
     * This method to set a callback reject for a queue.
     */
    public function setCallableReject(callable $callableReject) : Queue;

    /**
     * This method to get result of a queue when the queue is resolved.
     */
    public function getReturnResolve() : mixed;

    /**
     * This method to get result of a queue when the queue is rejected.
     */
    public function getReturnReject() : mixed;

    /**
     * This method to catch result of a queue parent when the queue is resolved.
     */
    public function thenPromise(callable $callable) : Queue;

    /**
     * This method to catch result of a queue parent when the queue is rejected.
     */
    public function catchPromise(callable $callable) : Queue;

    /**
     * This method to catch result of a queue child when the queue is resolved.
     */
    public function then(callable $callable) : Queue;

    /**
     * This method to catch result of a queue child when the queue is rejected.
     */
    public function catch(callable $callable) : Queue;

    /**
     * This method to check should drop queue when the queue is resolved or rejected.
     */
    public function canDrop() : bool;

    /**
     * @return  array<callable|Async|Promise>
     *
     * This method to get waiting promises.
     */
    public function getWaitingPromises() : array;

    /**
     * @param array<callable|Async|Promise> $waitingPromises
     *
     * This method to set waiting promises.
     */
    public function setWaitingPromises(array $waitingPromises) : void;

    /**
     * This method check if the queue is a promise for all.
     */
    public function isPromiseAll() : bool;

    /**
     * This method to set the queue is a promise race.
     */
    public function setRacePromise(bool $isRacePromise) : void;

    /**
     * This method to check if the queue is a promise race.
     */
    public function isRacePromise() : bool;

    /**
     * This method to set the queue is a promise any.
     */
    public function setAnyPromise(bool $isAnyPromise) : void;

    /**
     * This method to check if the queue is a promise any.
     */
    public function isAnyPromise() : bool;

    /**
     * This method to set the queue is a promise all settled.
     */
    public function setAllSettled(bool $isAllSettled) : void;

    /**
     * This method to check if the queue is a promise all settled.
     */
    public function isAllSettled() : bool;

    /**
     * @throws Throwable
     *
     * This method to check if the queue has completed all promises.
     */
    public function hasCompletedAllPromises() : bool;

}