// Advent of code Year 2019 Day 5 solution
// Author = Albert Zhang
// Date = December 2019

const readline = require('readline');

const POSITION = "0"
const IMMEDIATE = "1"

const instructions = {
    1: {
        async handler ({ code, args }) {
            code[args[2]] = args[0] + args[1]
        },
        argLen: 3,
        store: true
    },
    2: {
        async handler ({ code, args }) {
            code[args[2]] = args[0] * args[1]
        },
        argLen: 3,
        store: true
    },
    3: {
        async handler ({ code, args, input }) {
            code[args[0]] = await input()
        },
        argLen: 1,
        store: true
    },
    4: {
        async handler ({ args, output }) {
            output(args[0])
        },
        argLen: 1,
    },
    5: {
        async handler({ args }) {
            if (args[0] !== 0) {
                return args[1]
            }
        },
        argLen: 2
    },
    6: {
        async handler({ args }) {
            if (args[0] === 0) {
                return args[1]
            }
        },
        argLen: 2
    },
    7: {
        async handler({ code, args }) {
            if (args[0] < args[1]) {
                code[args[2]] = 1
            } else {
                code[args[2]] = 0
            }
        },
        argLen: 3,
        store: true
    },
    8: {
        async handler({ code, args }) {
            if (args[0] === args[1]) {
                code[args[2]] = 1
            } else {
                code[args[2]] = 0
            }
        },
        argLen: 3,
        store: true
    },
    9: {
        async handler({ args, relBase }) {
            return relBase + args[0]    
        },
        argLen: 1
    },
    99: {
        async handler () {
            return null
        },
        argLen: 0
    }
}

async function interpretIntcode(intcode, input, output) {
    let idx = 0
    let relBase = 0

    while (true) {
        const val = intcode[idx]

        const opCode = val % 100
        if (opCode === 99) {
            break
        }

        const instr = instructions[opCode]
        if (!instr) {
            console.log("Error!, ", { idx, opCode })
            break
        }

        const modeStr = Number(val).toString()

        const args = []
        const modes = []
        const params = []
        for (let i = 1; i < instr.argLen + 1; i++) {
            let pos = false
            let mode = 0

            let param = intcode[idx + i]
            params.push(param)

            if (instr.store && i === instr.argLen) {
                pos = true
                mode = 1
            }

            if (modeStr.length - 2 - i >= 0) {
                mode = Number(modeStr[modeStr.length - 2 - i])
            }

            modes.push(mode)

            if (mode === 2) {
                param += relBase
            }

            if (pos) {
                args.push(param)
            } else if (mode === 0 || mode === 2) {
                args.push(intcode[param])
            } else if (mode === 1) {
                args.push(param)
            }
        }

        // console.log({ idx, val, args, modes, params, relBase})
        const res = await instr.handler({ code: intcode, args: args, output: output, input: input, relBase: relBase })

        let jump
        if (opCode === 9) {
            relBase = res
        } else {
            jump = res
        }

        if (jump !== undefined) {
            idx = jump
        } else {
            idx += instr.argLen + 1
        }
    }
}

module.exports = interpretIntcode

