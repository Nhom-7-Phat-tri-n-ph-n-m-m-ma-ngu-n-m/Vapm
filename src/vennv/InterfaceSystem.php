<?php

/*
 * Copyright (c) 2023 VennV
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types = 1);

namespace vennv;

use Throwable;

interface InterfaceSystem {

    /**
     * @throws Throwable
     *
     * This method is used to run callback after a certain amount of time.
     */
    public static function setTimeout(callable $callable, int $timeout) : void;

    /**
     * @throws Throwable
     *
     * This method is used to run repeatable callback after a certain amount of time.
     */
    public static function setInterval(callable $callable, int $interval) : void;

    /**
     * @param array<int, mixed> $options
     *
     * This method is used to fetch data from an url.
     */
    public static function fetch(string $url, array $options = [CURLOPT_RETURNTRANSFER => true]) : Promise;

    /**
     * This method is used to fetch data from an url. But it uses file_get_contents() instead of curl.
     */
    public static function fetchJg(string $url) : Promise;

    /**
     * @throws Throwable
     *
     * This method is used to run a single job.
     * It is used when you want to run the event loop in a blocking way.
     */
    public static function endSingleJob() : void;

    /**
     * @throws Throwable
     *
     * This method is usually used at the end of the whole chunk of your program,
     * it is used to run the event loop.
     *
     * This method is used when you want to run the event loop in a non-blocking way.
     * You should run this method in a separate thread and make it repeat every second.
     */
    public static function endMultiJobs() : void;

}