<?php

namespace vennv;

use Fiber;
use Throwable;

final class System extends EventQueue
{

    /**
     * @throws Throwable
     */
    public static function setTimeout(callable $callable, int $timeout) : void
    {
        parent::addQueue(new Fiber($callable), false, false, Utils::milliSecsToSecs($timeout));
    }

    public static function fetch(string $url) : Promise 
    {
        return new Promise(function($resolve, $reject) use ($url) 
        {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                $reject(curl_error($ch));
            } else {
                $resolve($result);
            }
            curl_close($ch);
        });
    }

    public static function fecthJg(string $url) : Promise 
    {
        return new Promise(function($resolve, $reject) use ($url) 
        {
            $ch = file_get_contents($url);
            if ($ch === false) {
                $reject("Error in fetching data!");
            } else {
                $resolve($ch);
            }
        });
    }

    /**
     * @throws Throwable
     */
    public static function endSingleJob() : void
    {
        parent::runSingleJob();
    }

    /**
     * @throws Throwable
     */
    public static function endMultiJobs() : void
    {
        parent::runMultiJobs();
    }

}