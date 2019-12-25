'use strict';

const fs = require('fs');

const rawInput = fs.readFileSync(__dirname + '/input', { encoding: 'utf-8' });
const input = rawInput.replace(/\r\n/g, '\n').replace(/\n$/, '');
const lines = input.split('\n');


run();
async function run()
{
	const realops = input.split(',').filter(Boolean).map((op) => parseInt(op));

	let inputQueues = new Map();
	let pcs = new Map();
	let natValues = new Set();
	let natBuffer;
	let idle = new Array(50).fill(0);


	for(let id = 0; id < 50; ++id)
	{
		let pcID = id;
		let inputQueue = [];
		inputQueues.set(id, inputQueue);
		inputQueue.push(id);

		let packetDestination;
		let packetX;
		let packetY;
		let outputCounter = 0;


		let ops = realops.slice();
		let relbase = 0;
		let ip = 0;
		pcs.set(id, next);

		function next()
		{
			ip = execNext();
		}
		function execNext()
		{
			let opdata = ops[ip];
			let opmeta = Math.floor(opdata / 100);
			let opcode = opdata % 100;
			switch(opcode)
			{
				case 99:
					return -1;

				case 1: //<3> = <1> + <2>
					ops[getParamAddress(3)] = getParamValue(1) + getParamValue(2);
					return ip + 4;

				case 2: //<3> = <1> * <2>
					ops[getParamAddress(3)] = getParamValue(1) * getParamValue(2);
					return ip + 4;

				case 3: //<1> = input()
					ops[getParamAddress(1)] = getInput();
					return ip + 2;

				case 4: //output(<1>)
					writeOutput(getParamValue(1));
					return ip + 2;

				case 5: //Jmp to <1> if <2> is !0
					if(getParamValue(1) !== 0)
						return getParamValue(2);
					return ip + 3;

				case 6: //Jmp to <1> if <2> is 0
					if(getParamValue(1) === 0)
						return getParamValue(2);
					return ip + 3;

				case 7: //If <1> is lower than <2> write 1 to <3>; else write 0 to <3>
					ops[getParamAddress(3)] = getParamValue(1) < getParamValue(2) ? 1 : 0;
					return ip + 4;

				case 8: //If <1> equals <2> write 1 to <3>; else write 0 to <3>
					ops[getParamAddress(3)] = getParamValue(1) === getParamValue(2) ? 1 : 0;
					return ip + 4;

				case 9:
					relbase += getParamValue(1);
					return ip + 2;

				default:
					console.error(`Unknown opcode ${opcode} at instruction ${ip}`);
					return -1;
			}


			function getParamValue(paramID)
			{
				let val = ops[ip + paramID] || 0;
				let paramMode = Math.floor(opmeta / (10 ** (paramID - 1))) % 10;
				if(paramMode === 0)
					return ops[val] || 0;
				else if(paramMode === 1)
					return val;
				else if(paramMode === 2)
					return ops[relbase + val] || 0;
			}
			function getParamAddress(paramID)
			{
				let val = ops[ip + paramID];
				let paramMode = Math.floor(opmeta / (10 ** (paramID - 1))) % 10;
				if(paramMode === 0)
					return val;
				else if(paramMode === 2)
					return relbase + val;
			}
		}
		function getInput()
		{
			if(inputQueue.length === 0)
			{
				++idle[pcID];
				if(idle.every((i) => i > 100))
					sendIdle();

				return -1;
			}

			idle[pcID] = 0;


			let val = inputQueue[0];
			inputQueue.shift();

			return val;
		}
		function writeOutput(val)
		{
			idle[pcID] = 0;
			switch(outputCounter++)
			{
				case 0:
					packetDestination = val;
					break;
				case 1:
					packetX = val;
					break;
				case 2:
					packetY = val;

					outputCounter = 0;

					let destinationQueue = inputQueues.get(packetDestination);
					if(destinationQueue)
					{
						destinationQueue.push(packetX);
						destinationQueue.push(packetY);
					}
					if(packetDestination === 255)
					{
						natBuffer = { x: packetX, y: packetY };
					}

					break;
			}
		}
	}

	while(true)
	{
		for(let pc of pcs.values())
			pc();
	}


	function sendIdle()
	{
		let inputQueue = inputQueues.get(0);
		inputQueue.push(natBuffer.x);
		inputQueue.push(natBuffer.y);

		if(natValues.has(natBuffer.y))
		{
			console.log(natBuffer.y);
			process.exit(0);
		}

		idle[0] = 0;
		natValues.add(natBuffer.y);
	}
}

