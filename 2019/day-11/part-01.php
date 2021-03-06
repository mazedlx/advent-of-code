<?php

error_reporting(0);

class Intcode
{
    public $instructions;
    public $step;
    public $cmd;
    public $mode;
    public $initial;
    public $relativeBase;
    public $currentOutput;
    public $panels = [];
    public $x = 0;
    public $y = 0;
    public $rotation = 0;
    public function __construct($initial, $instructions)
    {
        $this->currentOutput = $initial;
        $this->mode = [];
        $this->step = 0;
        $this->relativeBase = 0;
        $this->instructions = array_map(function ($instruction) {
            return (int) $instruction;
        }, explode(',', $instructions));
    }

    public function get($step, $mode)
    {
        switch ($mode) {
            case 0: // parameter
                return $this->instructions[$this->instructions[$step]];
            case 1: // intermediate
                return $this->instructions[$step];
            case 2: // relative
                return $this
                    ->instructions[$this->relativeBase + $this->instructions[$step]];
            default:
                die('error mode');
        }
    }

    public function set($value, $step, $mode)
    {
        switch ($mode) {
            case 0: // parameter
                return $this->instructions[$this->instructions[$step]] = $value;
            case 1: // intermediate		
            echo 'hier';
                return $this->instructions[$step] = $value;
            case 2: // relative
                return $this->instructions[
                    $this->relativeBase + $this->instructions[$step]
                ] = $value;
            default:
                die('error mode');
        }
    }

    public function run()
    {
        for ($this->step; $this->step < count($this->instructions); ) {
            $this->cmd = (int) substr($this->instructions[$this->step], -2, 5);

            if ($this->instructions[$this->step] > 99) {
                $this->mode = str_split(
                    strrev(
                        substr(
                            $this->instructions[$this->step],
                            0,
                            strlen($this->instructions[$this->step]) - 2
                        )
                    )
                );
                $this->mode = array_map(function ($mode) {
                    return (int) $mode;
                }, $this->mode);
                if (count($this->mode) < 2) {
                    $this->mode[] = 0;
                }
                if (count($this->mode) < 3) {
                    $this->mode[] = 0;
                }
            } else {
                $this->mode = [0, 0, 0];
            }
            switch ($this->cmd) {
                case 1: // ADD
                    $value =
                        $this->get($this->step + 1, $this->mode[0]) +
                        $this->get($this->step + 2, $this->mode[1]);
                    $this->set($value, $this->step + 3, $this->mode[2]);
                    $this->step += 4;
                    break;
                case 2: // MUL
                    $value =
                        $this->get($this->step + 1, $this->mode[0]) *
                        $this->get($this->step + 2, $this->mode[1]);
                    $this->set($value, $this->step + 3, $this->mode[2]);
                    $this->step += 4;
                    break;
                case 3: // INP
                    foreach(array_chunk($this->output, 2) as $arr) {
                        $color = array_pop($arr);
                        $rotation = array_pop($arr);
                        
       				    if(array_key_exists($this->x.'/'.$this->y, $this->panels)) {
					    	$this->currentOutput =  $this->panels[$this->$x.'/'.$this->$y];
					    } else {
					    	$this->currentOutput = 0;
					    }

                        $this->panels[$this->$x.'/'.$this->$y] = $color;
					    $rotation === 0 
					    	? $rotation -= 90 
					    	: $rotation += 90;

					    $this->rotation = $rotation % 360;
					    if ($this->rotation === 0) {
					        $this->y += 1;
					    } elseif ($this->rotation === 90 || $this->rotation === -270) {
					        $this->x += 1;
					    } elseif ($this->rotation === -90 || $this->rotation === 270) {
					        $this->x -= 1;
					    } elseif (abs($this->rotation) === 180) {
					        $this->y -= 1;
					    }
                    }

					$this->set(
						$this->currentOutput,
                        $this->step + 1,
                        $this->mode[0]
                    );
                    $this->step += 2;
                    break;
                case 4: // OUT
                	$value = $this->get(
                        $this->step + 1,
                        $this->mode[0]
                    );
					$this->output[] = $value;
                    $this->step += 2;
                    break;
                case 5: // JIT
                    $this->get($this->step + 1, $this->mode[0]) !== 0
                        ? ($this->step = $this->get(
                            $this->step + 2,
                            $this->mode[1]
                        ))
                        : ($this->step += 3);
                    break;
                case 6: // JIF
                    $this->get($this->step + 1, $this->mode[0]) === 0
                        ? ($this->step = $this->get(
                            $this->step + 2,
                            $this->mode[1]
                        ))
                        : ($this->step += 3);
                    break;
                case 7: // LT
                    $this->get($this->step + 1, $this->mode[0]) <
                    $this->get($this->step + 2, $this->mode[1])
                        ? $this->set(1, $this->step + 3, $this->mode[2])
                        : $this->set(0, $this->step + 3, $this->mode[2]);
                    $this->step += 4;
                    break;
                case 8: // EQ
                    $this->get($this->step + 1, $this->mode[0]) ===
                    $this->get($this->step + 2, $this->mode[1])
                        ? $this->set(1, $this->step + 3, $this->mode[2])
                        : $this->set(0, $this->step + 3, $this->mode[2]);
                    $this->step += 4;
                    break;
                case 9: // REL
                    $this->relativeBase += $this->get(
                        $this->step + 1,
                        $this->mode[0]
                    );
                    $this->step += 2;
                    break;
                case 99:
                    echo 'halt', PHP_EOL;
                    return;
                default:
                    echo 'error cmd ', $this->cmd, ' @ step ', $this->step, PHP_EOL;
                    die();
            }
        }
    }
}

$intcode = new Intcode(
    0,
    '3,8,1005,8,330,1106,0,11,0,0,0,104,1,104,0,3,8,102,-1,8,10,1001,10,1,10,4,10,108,0,8,10,4,10,1001,8,0,28,1,1103,17,10,1006,0,99,1006,0,91,1,102,7,10,3,8,1002,8,-1,10,101,1,10,10,4,10,108,1,8,10,4,10,1002,8,1,64,3,8,102,-1,8,10,1001,10,1,10,4,10,108,0,8,10,4,10,102,1,8,86,2,4,0,10,1006,0,62,2,1106,13,10,3,8,1002,8,-1,10,1001,10,1,10,4,10,1008,8,0,10,4,10,101,0,8,120,1,1109,1,10,1,105,5,10,3,8,102,-1,8,10,1001,10,1,10,4,10,108,1,8,10,4,10,1002,8,1,149,1,108,7,10,1006,0,40,1,6,0,10,2,8,9,10,3,8,102,-1,8,10,1001,10,1,10,4,10,1008,8,1,10,4,10,1002,8,1,187,1,1105,10,10,3,8,102,-1,8,10,1001,10,1,10,4,10,1008,8,1,10,4,10,1002,8,1,213,1006,0,65,1006,0,89,1,1003,14,10,3,8,102,-1,8,10,1001,10,1,10,4,10,108,0,8,10,4,10,102,1,8,244,2,1106,14,10,1006,0,13,3,8,102,-1,8,10,1001,10,1,10,4,10,108,0,8,10,4,10,1001,8,0,273,3,8,1002,8,-1,10,1001,10,1,10,4,10,108,1,8,10,4,10,1001,8,0,295,1,104,4,10,2,108,20,10,1006,0,94,1006,0,9,101,1,9,9,1007,9,998,10,1005,10,15,99,109,652,104,0,104,1,21102,937268450196,1,1,21102,1,347,0,1106,0,451,21101,387512636308,0,1,21102,358,1,0,1105,1,451,3,10,104,0,104,1,3,10,104,0,104,0,3,10,104,0,104,1,3,10,104,0,104,1,3,10,104,0,104,0,3,10,104,0,104,1,21101,0,97751428099,1,21102,1,405,0,1105,1,451,21102,1,179355806811,1,21101,416,0,0,1106,0,451,3,10,104,0,104,0,3,10,104,0,104,0,21102,1,868389643008,1,21102,439,1,0,1105,1,451,21102,1,709475853160,1,21102,450,1,0,1105,1,451,99,109,2,22102,1,-1,1,21101,0,40,2,21101,482,0,3,21102,1,472,0,1105,1,515,109,-2,2106,0,0,0,1,0,0,1,109,2,3,10,204,-1,1001,477,478,493,4,0,1001,477,1,477,108,4,477,10,1006,10,509,1101,0,0,477,109,-2,2105,1,0,0,109,4,2101,0,-1,514,1207,-3,0,10,1006,10,532,21101,0,0,-3,21202,-3,1,1,22101,0,-2,2,21101,1,0,3,21101,0,551,0,1105,1,556,109,-4,2106,0,0,109,5,1207,-3,1,10,1006,10,579,2207,-4,-2,10,1006,10,579,22102,1,-4,-4,1105,1,647,21201,-4,0,1,21201,-3,-1,2,21202,-2,2,3,21101,0,598,0,1106,0,556,22101,0,1,-4,21102,1,1,-1,2207,-4,-2,10,1006,10,617,21101,0,0,-1,22202,-2,-1,-2,2107,0,-3,10,1006,10,639,22102,1,-1,1,21102,1,639,0,105,1,514,21202,-2,-1,-2,22201,-4,-2,-4,109,-5,2105,1,0'
);

$intcode->run();

$panels = [];
$x = 0;
$y = 0;
$minX = 0;
$maxX = 0;
$minY = 0;
$maxY = 0;
$rotation = 0;

for ($i = 0; $i < count($intcode->output); ) {
    $panels["$x/$y"] = $intcode->output[$i] === 1 ? '▓' : ' ';
    if ($intcode->output[$i + 1] === 0) {
        $rotation -= 90;
    } else {
        $rotation += 90;
    }

    $rotation %= 360;
    if ($rotation === 0) {
        $y += 1;
    } elseif ($rotation === 90 || $rotation === -270) {
        $x += 1;
    } elseif ($rotation === -90 || $rotation === 270) {
        $x -= 1;
    } elseif (abs($rotation) === 180) {
        $y -= 1;
    }
    if ($x > $maxX) {
        $maxX = $x;
    }
    if ($y > $maxY) {
        $maxY = $y;
    }
    if ($x < $minX) {
        $minX = $x;
    }
    if ($y < $minY) {
        $minY = $y;
    }
    $i += 2;
}

for ($n = $maxY; $n >= $minY; $n--) {
	for ($m = $minX; $m <= $maxX; $m++) {
        if (array_key_exists("$m/$n", $panels)) {
            echo $panels["$m/$n"];
        } else {
            echo ' ';
        }
    }

    echo PHP_EOL;
}

echo array_reduce($panels, function($carry, $item) {
    return $carry + 1;
}, 0), PHP_EOL;

