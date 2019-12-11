<?php

class Intcode {
    public $instructions;
    public $step;
    public $cmd;
    public $mode;
    public $initial;
    public $phase;

    public function __construct($initial, $instructions, $phase) {
        $this->initial = $initial;
        $this->phase = $phase;
        $this->mode = [];
        $this->step = 0;
        $this->output = 0;
        $this->instructions = array_map(function($instruction) { 
            return (int) $instruction; 
        }, explode(',', $instructions));
    }

    public function get($step, $mode)
    {
        switch($mode) {
            case 0: // parameter
                return $this->instructions[$this->instructions[$step]];
            case 1; // intermediate
                return $this->instructions[$step];
            default:
                die('error mode');
        }
    }

    public function set($value, $step, $mode) {
        switch($mode) {
            case 0: // parameter
                return $this->instructions[$this->instructions[$step]] = $value;
            default:
                die('error mode');
        }
    }

    public function run() 
    {
        for($this->step; $this->step < count($this->instructions);) {
            $this->cmd = (int) substr($this->instructions[$this->step], -2 ,5); 

            if ($this->instructions[$this->step] > 99) {
                $this->mode = str_split(
                    strrev(
                        substr($this->instructions[$this->step], 0, strlen($this->instructions[$this->step]) - 2)
                    )
                );
                $this->mode = array_map(function($mode) {
                    return (int) $mode;
                }, $this->mode);
                if (count($this->mode) < 2) {
                    $this->mode[] = 0;
                }
                if (count($this->mode) < 3) {
                    $this->mode[] = 0;
                }
            } else {
                $this->mode = [0,0,0];
            }
            switch($this->cmd) {
                case 1: // ADD
                    $value = $this->get($this->step + 1, $this->mode[0]) + $this->get($this->step + 2, $this->mode[1]);
                    $this->set($value, $this->step + 3, $this->mode[2]);
                    $this->step += 4;
                    break;
                case 2: // MUL
                    $value = $this->get($this->step + 1, $this->mode[0]) * $this->get($this->step + 2, $this->mode[1]);
                    $this->set($value, $this->step + 3, $this->mode[2]);
                    $this->step += 4;
                    break;
                case 3: // INP
                    $value = $this->phase ? $this->phase : $this->initial;
                    $this->phase = false;
                    $this->set($value, $this->step + 1, $this->mode[0]);
                    $this->step += 2;
                    break;
                case 4: // OUT
                    $this->output = $this->get($this->step + 1, $this->mode[0]);
                    $this->step += 2;
                    break;
                case 5: // JIT
                    $this->get($this->step + 1, $this->mode[0]) !== 0 
                        ? $this->step = $this->get($this->step + 2, $this->mode[1])
                        : $this->step += 3;
                    break;
                case 6: // JIF
                    $this->get($this->step + 1, $this->mode[0]) === 0 
                        ? $this->step = $this->get($this->step + 2, $this->mode[1])
                        : $this->step += 3;
                    break;
                case 7: // LT
                    $this->get($this->step + 1, $this->mode[0]) < $this->get($this->step + 2, $this->mode[1])
                        ? $this->set(1, $this->step + 3, $this->mode[2])
                        : $this->set(0, $this->step + 3, $this->mode[2]);
                    $this->step += 4;
                    break;
                case 8: // EQ
                    $this->get($this->step + 1, $this->mode[0]) === $this->get($this->step + 2, $this->mode[1])
                        ? $this->set(1, $this->step + 3, $this->mode[2])
                        : $this->set(0, $this->step + 3, $this->mode[2]);
                    $this->step += 4;
                    break;
                case 99:
                    return $this->output;
                    break;
                default: 
                    die('error cmd ' . $this->cmd . ' @ step ' . $this->step . PHP_EOL);
            }
        }
    }
}

function permutate($items)
{
    $perms = [];
    
    $recurse = function($items, $start_i = 0) use (&$perms, &$recurse) {
        if ($start_i === count($items)-1) {
            array_push($perms, $items);
        }

        for ($i = $start_i; $i < count($items); $i++) {
            $t = $items[$i]; $items[$i] = $items[$start_i]; $items[$start_i] = $t;
            $recurse($items, $start_i + 1);
            $t = $items[$i]; $items[$i] = $items[$start_i]; $items[$start_i] = $t;
        }
    };

    $recurse($items);
    return $perms;
}

function maxThrust() {
    $program = '3,8,1001,8,10,8,105,1,0,0,21,38,47,64,85,106,187,268,349,430,99999,3,9,1002,9,4,9,1001,9,4,9,1002,9,4,9,4,9,99,3,9,1002,9,4,9,4,9,99,3,9,1001,9,3,9,102,5,9,9,1001,9,5,9,4,9,99,3,9,101,3,9,9,102,5,9,9,1001,9,4,9,102,4,9,9,4,9,99,3,9,1002,9,3,9,101,2,9,9,102,4,9,9,101,2,9,9,4,9,99,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,101,1,9,9,4,9,3,9,102,2,9,9,4,9,3,9,101,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,1002,9,2,9,4,9,99,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,101,1,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,101,2,9,9,4,9,3,9,101,1,9,9,4,9,99,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,3,9,101,1,9,9,4,9,3,9,101,1,9,9,4,9,3,9,101,1,9,9,4,9,3,9,1002,9,2,9,4,9,99,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,101,1,9,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,102,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,101,2,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1002,9,2,9,4,9,99,3,9,1002,9,2,9,4,9,3,9,101,1,9,9,4,9,3,9,102,2,9,9,4,9,3,9,1001,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,1002,9,2,9,4,9,3,9,1001,9,1,9,4,9,3,9,102,2,9,9,4,9,99';
    #$program = '3,31,3,32,1002,32,10,32,1001,31,-2,31,1007,31,0,33,1002,33,7,33,1,33,31,31,1,32,31,31,4,31,99,0,0,0';
    #$program = '3,23,3,24,1002,24,10,24,1002,23,-1,23,101,5,23,23,1,24,23,23,4,23,99,0,0';
    #$program = '3,15,3,16,1002,16,10,16,1,16,15,15,4,15,99,0,0';
    $max = 0;
    
    foreach (permutate(range(0, 4)) as $perm) {
        [$a, $b, $c, $d, $e] = $perm;
        $outputA = (new Intcode(20, $program, $a))->run();
        $outputB = (new Intcode($outputA, $program, $b))->run();
        $outputC = (new Intcode($outputB, $program, $c))->run();
        $outputD = (new Intcode($outputC, $program, $d))->run();
        $outputE = (new Intcode($outputD, $program, $e))->run();
        if ($outputE > $max) {
            $max = $outputE;
        }
    }
    echo 'MAX ', $max, PHP_EOL;
}

maxThrust();
