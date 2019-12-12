let data = '3,8,1005,8,330,1106,0,11,0,0,0,104,1,104,0,3,8,102,-1,8,10,1001,10,1,10,4,10,108,0,8,10,4,10,1001,8,0,28,1,1103,17,10,1006,0,99,1006,0,91,1,102,7,10,3,8,1002,8,-1,10,101,1,10,10,4,10,108,1,8,10,4,10,1002,8,1,64,3,8,102,-1,8,10,1001,10,1,10,4,10,108,0,8,10,4,10,102,1,8,86,2,4,0,10,1006,0,62,2,1106,13,10,3,8,1002,8,-1,10,1001,10,1,10,4,10,1008,8,0,10,4,10,101,0,8,120,1,1109,1,10,1,105,5,10,3,8,102,-1,8,10,1001,10,1,10,4,10,108,1,8,10,4,10,1002,8,1,149,1,108,7,10,1006,0,40,1,6,0,10,2,8,9,10,3,8,102,-1,8,10,1001,10,1,10,4,10,1008,8,1,10,4,10,1002,8,1,187,1,1105,10,10,3,8,102,-1,8,10,1001,10,1,10,4,10,1008,8,1,10,4,10,1002,8,1,213,1006,0,65,1006,0,89,1,1003,14,10,3,8,102,-1,8,10,1001,10,1,10,4,10,108,0,8,10,4,10,102,1,8,244,2,1106,14,10,1006,0,13,3,8,102,-1,8,10,1001,10,1,10,4,10,108,0,8,10,4,10,1001,8,0,273,3,8,1002,8,-1,10,1001,10,1,10,4,10,108,1,8,10,4,10,1001,8,0,295,1,104,4,10,2,108,20,10,1006,0,94,1006,0,9,101,1,9,9,1007,9,998,10,1005,10,15,99,109,652,104,0,104,1,21102,937268450196,1,1,21102,1,347,0,1106,0,451,21101,387512636308,0,1,21102,358,1,0,1105,1,451,3,10,104,0,104,1,3,10,104,0,104,0,3,10,104,0,104,1,3,10,104,0,104,1,3,10,104,0,104,0,3,10,104,0,104,1,21101,0,97751428099,1,21102,1,405,0,1105,1,451,21102,1,179355806811,1,21101,416,0,0,1106,0,451,3,10,104,0,104,0,3,10,104,0,104,0,21102,1,868389643008,1,21102,439,1,0,1105,1,451,21102,1,709475853160,1,21102,450,1,0,1105,1,451,99,109,2,22102,1,-1,1,21101,0,40,2,21101,482,0,3,21102,1,472,0,1105,1,515,109,-2,2106,0,0,0,1,0,0,1,109,2,3,10,204,-1,1001,477,478,493,4,0,1001,477,1,477,108,4,477,10,1006,10,509,1101,0,0,477,109,-2,2105,1,0,0,109,4,2101,0,-1,514,1207,-3,0,10,1006,10,532,21101,0,0,-3,21202,-3,1,1,22101,0,-2,2,21101,1,0,3,21101,0,551,0,1105,1,556,109,-4,2106,0,0,109,5,1207,-3,1,10,1006,10,579,2207,-4,-2,10,1006,10,579,22102,1,-4,-4,1105,1,647,21201,-4,0,1,21201,-3,-1,2,21202,-2,2,3,21101,0,598,0,1106,0,556,22101,0,1,-4,21102,1,1,-1,2207,-4,-2,10,1006,10,617,21101,0,0,-1,22202,-2,-1,-2,2107,0,-3,10,1006,10,639,22102,1,-1,1,21102,1,639,0,105,1,514,21202,-2,-1,-2,22201,-4,-2,-4,109,-5,2105,1,0'.toString().split(',').map(Number)

/// This is running part two, change value in robot.gridSoFar for part one

let relativeBase = 0;
let partTwo = [];

function PanelGrid(x,y,color='B'){
    this.color = color;
    this.x = x
    this.y = y
    this.paintedOnce = false;
    this.coord = [this.x,this.y]
}

const robot = {
    directions: ['U','L','B','R'],
    indDir: 0,
    gridSoFar: [new PanelGrid(0,0,"W")], /// CHANGE VALUE HERE FOR PART ONE, REPLACE "W" WITH "B"
    run: function(){
        let outputs = getDiagnostic(0,0);
    },
    getPosition: function(index,x,y){
        let direction = this.directions[index];
        switch(direction){
            case 'U':
                y-- 
                break
            case 'L':
                x--
                break
            case 'B':
                y++
                break
            case 'R':
                x++
                break
        }
        return [x,y]
    }



}

robot.run()


function getValue(a){
    return data[a] == undefined ? 0: data[a] ;
}

function getIndex(mode,ip){
    switch(mode){
        case 0: return data[ip]
        case 1: return ip
        case 2: return relativeBase+data[ip]           
    }
}
function mod(n, m) {
    return ((n % m) + m) % m;
  }

function getDiagnostic(x,y){
    
  let output = []
    for(let i=0;i<data.length;i++){
        if(output.length==2){        
           let firstOutput = output.shift()
           let secondOutput = output.shift();
           let currentPanel = robot.gridSoFar.find( el => el.x == x && el.y == y)
           firstOutput == 0 ? currentPanel.color = 'B' : currentPanel.color = "W"       
           currentPanel.paintedOnce == false ? currentPanel.paintedOnce = true : undefined;
           let currX = currentPanel.x;
           let currY = currentPanel.y
           secondOutput == 0 ? robot.indDir = mod((robot.indDir+1),4) : robot.indDir = mod((robot.indDir-1),4) 
           let nextPos = robot.getPosition(robot.indDir,currX,currY)
           let doesExist = robot.gridSoFar.find( el => el.x == nextPos[0] && el.y == nextPos[1])
           if(!doesExist){
              let nextPanel = new PanelGrid(nextPos[0],nextPos[1]); 
              robot.gridSoFar.push(nextPanel); 
           }
            [x,y] = nextPos
            partTwo.push(nextPos)
        }
        let currentPanel = robot.gridSoFar.find( el => el.x == x && el.y == y)
        let opcode = data[i].toString().split('');
        let instruction = opcode.length == 1 ? parseInt(opcode[opcode.length-1]) :  parseInt(opcode[opcode.length-2] + opcode[opcode.length-1])
        if(instruction==99){       
            console.log('Part One ' + robot.gridSoFar.filter(el => el.paintedOnce == true).length)    
            i = data.length;
            return output
        }
        let modeFirst = opcode[opcode.length-3] ? parseInt(opcode[opcode.length-3]) : 0;
        let modeSecond = opcode[opcode.length-4] ? parseInt(opcode[opcode.length-4]) : 0;
        let modeThird = opcode[opcode.length-5] ? parseInt(opcode[opcode.length-5]) :  0;
        let a = getIndex(modeFirst,i+1)
        let b = getIndex(modeSecond,i+2)
        let c = getIndex(modeThird,i+3)
        switch (instruction) {
            case 1:
                data[c] = getValue(a) + getValue(b);
                i+=3
                break;
            case 2:
                data[c] = getValue(a) * getValue(b);
                i+=3
                break;
            case 3:
                input = currentPanel.color=='B'? 0 : 1;
                data[a] = input;    
                i += 1;
                break;
            case 4:
                output.push(data[a])
                i += 1;
                break;
            case 5:
                getValue(a) != 0 ? i = getValue(b)-1 : i+=2
                break;
            case 6:
                getValue(a)==0 ? i = getValue(b)-1 : i+=2;
                break;
            case 7:
                getValue(a)<getValue(b) ? data[c]=1 : data[c]=0
                i += 3;
                break;
            case 8:
                getValue(a)==getValue(b) ? data[c] = 1 : data[c] = 0;
                i+=3
                break;
            case 9:
                relativeBase += getValue(a);
                i+=1
                break;
        }
        
    }
    return output
}


let minX = partTwo.map(el => el[0]).reduce((a,b) => a<b ? a : b)
let maxX = partTwo.map(el => el[0]).reduce((a,b) => a>b ? a : b)
let minY = partTwo.map(el => el[1]).reduce((a,b) => a<b ? a : b)
let maxY = partTwo.map(el => el[1]).reduce((a,b) => a>b ? a : b)
res='';
partTwo = partTwo.map(el=> el.toString(','))
for(a=minY;a<=maxY;a++){
    for(b=minX;b<=maxX;b++){
       let coords=b.toString()+','+ a.toString()
       let isEmpty= partTwo.indexOf(coords) < 0 ;
       isEmpty ? res += " " : (curr = robot.gridSoFar.find(el=>el.x==b && el.y==a), curr.color=='B' ? res += " " : res += '▮')
    }
    res+='\n';
} 
console.log(res)

