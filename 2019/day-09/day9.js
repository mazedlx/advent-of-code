const fs = require('fs')
const interpretIntcode = require('./intcode.js')

const intcode = fs.readFileSync('input.txt', 'utf8')

const perms = require('./perm')

ic = intcode.split(',').map(Number)

// function part1(t, prev) {
//     return new Promise((resolve, reject) => {
//         var first = true

//         interpretIntcode(ic.slice(), () => { if (first) { first = false; return t; } else return prev }, resolve)
//             .catch(e => reject(e))
//     })
// }

// Promise.all(
//     perms([0, 1, 2, 3, 4])
//         .map(async p => {
//             const [a, b, c, d, e] = p
//             return await part1(e,
//                 await part1(d,
//                     await part1(c,
//                         await part1(b,
//                             await part1(a,
//                                 0)
//                         )
//                     )
//                 )
//             )
//         })
// ).then(outputs => console.log("Part 1: ", Math.max(...outputs)))

// class Machine {
//     constructor (name, readFrom, debug) {
//         this.queue = []
//         this.resolve = null
//         this.halted = false
//         this.name = name
//         this.debug = debug

//         if (readFrom) {
//             readFrom.link(this)
//         }
//     }

//     read () {
//         return new Promise((resolve, reject) => {
//             if (this.queue.length > 0) {
//                 resolve(this.queue.pop())
//             } else {
//                 this.resolve = data => {
//                     resolve(data)
//                     this.resolve = null
//                 }
//             }
//         })
//     }

//     write (data) {
//         if (this.resolve) {
//             this.resolve(data)
//         } else {
//             this.queue.push(data)
//         }
//     }

//     link (machine) {
//         this.writeTo = machine
//     }

//     reset () {
//         this.queue = []
//         this.halted = false
//     }

//     async run (phase, extra) {
//         this.halted = false

//         let phaseWritten = false

//         if (extra !== undefined) {
//             this.queue = [extra]
//         }

//         let toRet = undefined

//         await interpretIntcode(
//             ic.slice(),
//             () => {
//                 if (!phaseWritten) {
//                     phaseWritten = true
//                     return new Promise(resolve => resolve(phase))
//                 } else {
//                     return this.read()
//                 }
//             },
//             data => {
//                 if (this.writeTo.halted) {
//                     toRet = data
//                 } else {
//                     // console.log(`${this.name} => ${this.writeTo.name}`, data)
//                     this.writeTo.write(data)
//                 }
//             },
//             this.debug
//         )

//         this.halted = true

//         return toRet
//     }
// }

// Promise.all(
//     perms([5, 6, 7, 8, 9])
//         .map(async p => {
//             const [a, b, c, d, e] = p

//             const am = new Machine('a', null)
//             const bm = new Machine('b', am)
//             const cm = new Machine('c', bm)
//             const dm = new Machine('d', cm)
//             const em = new Machine('e', dm)
            
//             em.link(am)

//             am.run(a, 0)
//             bm.run(b)
//             cm.run(c)
//             dm.run(d)

//             return await em.run(e)    
//         })
// ).then(outputs => console.log("Part 2: ", Math.max(...outputs)))


const readline = require('readline')

const rli = readline.createInterface({
    input: process.stdin,
    output: process.stdout
})

function input() {
    return new Promise((resolve, reject) => {
        rli.question('Input: ', input => {
            const num = +input
            if (isNaN(num)) {
                reject('Must enter int')
            } else {
                resolve(num)
            }
        })
    })
}


interpretIntcode(ic.slice().concat(Array(1000000).fill(0)), input, console.log.bind(console))
            .catch(e => console.log(e))
