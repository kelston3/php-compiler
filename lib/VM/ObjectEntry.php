<?php

/*
 * This file is part of PHP-Compiler, a PHP CFG Compiler for PHP code
 *
 * @copyright 2015 Anthony Ferrara. All rights reserved
 * @license MIT See LICENSE at the root of the project for more info
 */

namespace PHPCompiler\VM;

use PHPCfg\Func;
use PHPCfg\Op;
use PHPCfg\Block as CfgBlock;
use PHPCfg\Operand;
use PHPCfg\Script;
use PHPTypes\Type;

class ObjectEntry {

    private static int $counter = 0;
    public ClassEntry $class;
    public int $id;
    private array $properties = [];

    public function __construct(ClassEntry $class) {
        $this->class = $class;
        $this->id = ++self::$counter;
        foreach ($class->properties as $property) {
            $this->properties[$property->name] = $property->getVariable();
        }
    }

    public function getProperty(string $name): Variable {
        if (!isset($this->properties[$name])) {
            throw new \LogicException("Undefined property access");
        }
        return $this->properties[$name];
    }

    public function getProperties(int $purpose): array {
        return $this->class->getProperties($this->properties, $purpose);
    }

}