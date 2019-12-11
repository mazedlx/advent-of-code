<?php

class Intcode {
	public $instructions;
	public $step;
	public $cmd;
	public $mode;
	public $initial;

	public function __construct($initial, $instructions) {
		$this->initial = $initial;
		$this->mode = [];
		$this->step = 0;
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
					$this->set($this->initial, $this->step + 1, $this->mode[0]);
					$this->step += 2;
					break;
				case 4: // OUT
					echo $this->get($this->step + 1, $this->mode[0]);
					echo PHP_EOL;
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
					echo 'halt', PHP_EOL;
					return;
				default: 
					die('error cmd ' . $this->cmd . ' @ step ' . $this->step . PHP_EOL);
			}

		}

	}
}
 
$intcode = new Intcode(5, '3,225,1,225,6,6,1100,1,238,225,104,0,1102,40,93,224,1001,224,-3720,224,4,224,102,8,223,223,101,3,224,224,1,224,223,223,1101,56,23,225,1102,64,78,225,1102,14,11,225,1101,84,27,225,1101,7,82,224,1001,224,-89,224,4,224,1002,223,8,223,1001,224,1,224,1,224,223,223,1,35,47,224,1001,224,-140,224,4,224,1002,223,8,223,101,5,224,224,1,224,223,223,1101,75,90,225,101,9,122,224,101,-72,224,224,4,224,1002,223,8,223,101,6,224,224,1,224,223,223,1102,36,63,225,1002,192,29,224,1001,224,-1218,224,4,224,1002,223,8,223,1001,224,7,224,1,223,224,223,102,31,218,224,101,-2046,224,224,4,224,102,8,223,223,101,4,224,224,1,224,223,223,1001,43,38,224,101,-52,224,224,4,224,1002,223,8,223,101,5,224,224,1,223,224,223,1102,33,42,225,2,95,40,224,101,-5850,224,224,4,224,1002,223,8,223,1001,224,7,224,1,224,223,223,1102,37,66,225,4,223,99,0,0,0,677,0,0,0,0,0,0,0,0,0,0,0,1105,0,99999,1105,227,247,1105,1,99999,1005,227,99999,1005,0,256,1105,1,99999,1106,227,99999,1106,0,265,1105,1,99999,1006,0,99999,1006,227,274,1105,1,99999,1105,1,280,1105,1,99999,1,225,225,225,1101,294,0,0,105,1,0,1105,1,99999,1106,0,300,1105,1,99999,1,225,225,225,1101,314,0,0,106,0,0,1105,1,99999,1007,226,677,224,1002,223,2,223,1005,224,329,1001,223,1,223,1007,226,226,224,1002,223,2,223,1006,224,344,101,1,223,223,1107,677,226,224,102,2,223,223,1006,224,359,1001,223,1,223,108,677,677,224,1002,223,2,223,1006,224,374,1001,223,1,223,107,677,677,224,1002,223,2,223,1005,224,389,101,1,223,223,8,677,677,224,1002,223,2,223,1005,224,404,1001,223,1,223,108,226,226,224,1002,223,2,223,1005,224,419,101,1,223,223,1008,677,677,224,1002,223,2,223,1005,224,434,101,1,223,223,1008,226,226,224,1002,223,2,223,1005,224,449,101,1,223,223,7,677,226,224,1002,223,2,223,1006,224,464,1001,223,1,223,7,226,226,224,1002,223,2,223,1005,224,479,1001,223,1,223,1007,677,677,224,102,2,223,223,1005,224,494,101,1,223,223,1108,677,226,224,102,2,223,223,1006,224,509,1001,223,1,223,8,677,226,224,102,2,223,223,1005,224,524,1001,223,1,223,1107,226,226,224,102,2,223,223,1006,224,539,1001,223,1,223,1008,226,677,224,1002,223,2,223,1006,224,554,1001,223,1,223,1107,226,677,224,1002,223,2,223,1006,224,569,1001,223,1,223,1108,677,677,224,102,2,223,223,1005,224,584,101,1,223,223,7,226,677,224,102,2,223,223,1006,224,599,1001,223,1,223,1108,226,677,224,102,2,223,223,1006,224,614,101,1,223,223,107,226,677,224,1002,223,2,223,1005,224,629,101,1,223,223,108,226,677,224,1002,223,2,223,1005,224,644,101,1,223,223,8,226,677,224,1002,223,2,223,1005,224,659,1001,223,1,223,107,226,226,224,1002,223,2,223,1006,224,674,101,1,223,223,4,223,99,226');
echo $intcode->run();