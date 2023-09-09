<?php

/**
 * Vapm - A library support for PHP about Async, Promise, Coroutine, Thread, GreenThread
 *          and other non-blocking methods. The library also includes some Javascript packages
 *          such as Express. The method is based on Fibers & Generator & Processes, requires
 *          you to have php version from >= 8.1
 *
 * Copyright (C) 2023  VennDev
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

declare(strict_types=1);

namespace vennv\vapm\utils;

use Closure;
use Generator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionException;
use ReflectionFunction;
use SplFileInfo;
use vennv\vapm\simultaneous\Error;
use vennv\vapm\simultaneous\Promise;
use function array_slice;
use function file;
use function implode;
use function is_array;
use function is_object;
use function is_string;
use function preg_match;
use function serialize;
use function strlen;
use function strpos;
use function substr;

interface UtilsInterface
{

    /**
     * Transform milliseconds to seconds
     */
    public static function milliSecsToSecs(float $milliSecs): float;

    /**
     * @throws ReflectionException
     *
     * Transform a closure or callable to string
     */
    public static function closureToString(Closure $closure): string;

    /**
     * Get all Dot files in a directory
     */
    public static function getAllByDotFile(string $path, string $dotFile): Generator;

    /**
     * @return array<int, string>|string
     *
     * Transform a string to inline
     */
    public static function outlineToInline(string $text): array|string;

    /**
     * @return array<int, string>|string
     *
     * Fix input command
     */
    public static function fixInputCommand(string $text): array|string;

    /**
     * @return null|string|array<int, string>
     *
     * Remove comments from a string
     */
    public static function removeComments(string $text): null|string|array;

    /**
     * @param mixed $data
     *
     * Get bytes of a string or object or array
     */
    public static function getBytes(mixed $data): int;

    /**
     * @return Generator
     *
     * Split a string by slash
     */
    public static function splitStringBySlash(string $string): Generator;

    /**
     * @return false|string
     *
     * Replace path
     */
    public static function replacePath(string $path, string $segment): false|string;

    /**
     * @return array<int, string>|string|null
     *
     * Replace advanced
     */
    public static function replaceAdvanced(string $text, string $search, string $replace): array|string|null;

    /**
     * @return Generator
     *
     * Evenly divide a number
     */
    public static function evenlyDivide(int $number, int $parts): Generator;

    /**
     * @param array<int, mixed> $array
     * @param int $size
     * @return Generator
     */
    public static function splitArray(array $array, int $size): Generator;

    /**
     * @param string $class
     * @return bool
     *
     * This method is used to check if the current class is the same as the class passed in
     */
    public static function isClass(string $class): bool;

}

final class Utils implements UtilsInterface
{

    public static function milliSecsToSecs(float $milliSecs): float
    {
        return $milliSecs / 1000;
    }

    /**
     * @throws ReflectionException
     */
    public static function closureToString(Closure $closure): string
    {
        $reflection = new ReflectionFunction($closure);
        $startLine = $reflection->getStartLine();
        $endLine = $reflection->getEndLine();
        $filename = $reflection->getFileName();

        if ($filename === false || $startLine === false || $endLine === false) throw new ReflectionException(Error::CANNOT_FIND_FUNCTION_KEYWORD);

        $lines = file($filename);
        if ($lines === false) throw new ReflectionException(Error::CANNOT_READ_FILE);

        $result = implode("", array_slice($lines, $startLine - 1, $endLine - $startLine + 1));
        $startPos = strpos($result, 'function');
        if ($startPos === false) {
            $startPos = strpos($result, 'fn');
            if ($startPos === false) throw new ReflectionException(Error::CANNOT_FIND_FUNCTION_KEYWORD);
        }

        $endBracketPos = strrpos($result, '}');
        if ($endBracketPos === false) throw new ReflectionException(Error::CANNOT_FIND_FUNCTION_KEYWORD);

        return substr($result, $startPos, $endBracketPos - $startPos + 1);
    }

    public static function getAllByDotFile(string $path, string $dotFile): Generator
    {
        $dir = new RecursiveDirectoryIterator($path);
        $iterator = new RecursiveIteratorIterator($dir);

        foreach ($iterator as $file) {
            if ($file instanceof SplFileInfo && preg_match('%' . $dotFile . '$%', $file->getFilename()) === 1) yield $file->getPathname();
        }
    }

    /**
     * @return array<int, string>|string
     */
    public static function outlineToInline(string $text): array|string
    {
        return str_replace(array("\r", "\n", "\t", '  '), '', $text);
    }

    /**
     * @return array<int, string>|string
     */
    public static function fixInputCommand(string $text): array|string
    {
        return str_replace('"', '\'', $text);
    }

    /**
     * @return null|string|array<int, string>
     *
     * Remove comments from a string
     */
    public static function removeComments(string $text): null|string|array
    {
        $text = preg_replace('/\/\/.*?(\r\n|\n|$)/', '', $text);
        if ($text === null || is_array($text)) return null;
        return preg_replace('/\/\*.*?\*\//ms', '', $text);
    }

    /**
     * @param mixed $data
     *
     * Get bytes of a string or object or array
     */
    public static function getBytes(mixed $data): int
    {
        if (is_string($data)) return strlen($data);
        if (is_object($data) || is_array($data)) return strlen(serialize($data));
        return 0;
    }

    /**
     * @return Generator
     *
     * Split a string by slash
     */
    public static function splitStringBySlash(string $string): Generator
    {
        $parts = explode('/', $string);
        foreach ($parts as $value) {
            $path = '/' . $value;
            if ($path !== '/') yield $path;
        }
    }

    /**
     * @return false|string
     *
     * Replace path
     */
    public static function replacePath(string $path, string $segment): false|string
    {
        $pos = strpos($path, $segment);
        if ($pos === false) return false;
        return substr($path, $pos + strlen($segment));
    }

    /**
     * @return array<int, string>|string|null
     *
     * Replace advanced
     */
    public static function replaceAdvanced(string $text, string $search, string $replace): array|string|null
    {
        return preg_replace('/(?<!-)(' . $search . ')(?!d)/', $replace, $text);
    }

    public static function evenlyDivide(int $number, int $parts): Generator
    {
        $quotient = intdiv($number, $parts);
        $remainder = $number % $parts;

        for ($i = 0; $i < $parts; $i++) {
            yield $quotient + ($remainder > 0 ? 1 : 0);
            $remainder--;
        }
    }

    /**
     * @param array<int, mixed> $array
     * @param int $size
     * @return Generator
     */
    public static function splitArray(array $array, int $size): Generator
    {
        $totalItems = count($array);
        $quotient = intdiv($totalItems, $size);
        $remainder = $totalItems % $size;

        $offset = 0;
        for ($i = 0; $i < $size; $i++) {
            $length = $quotient + ($remainder > 0 ? 1 : 0);

            yield array_slice($array, $offset, $length);

            $offset += $length;
            $remainder--;
        }
    }

    /**
     * @param string $class
     * @return bool
     * @throws ReflectionException
     */
    public static function isClass(string $class): bool
    {
        $trace = debug_backtrace();
        if (isset($trace[2])) {
            $args = $trace[2]['args'];
            if (!empty($args)) {
                /** @var Closure $closure */
                $closure = $args[0];
                $reflectionFunction = new ReflectionFunction($closure);
                return $reflectionFunction->getClosureScopeClass()->getName() === $class;
            } else {
                return true; // This is a class
            }
        }

        return false;
    }

}