from collections import defaultdict
from vm import IntCode

with open('11.in') as f:
    data = list(map(int, f.read().split(',')))

curr_pos = [0, 0]

# 0 == up
# 1 == right
# 2 == down
# 3 == left
dirs = {0: [0, -1], 1: [1, 0], 2: [0, 1], 3: [-1, 0]}
facing = 0
panels = defaultdict(int)
# 0 == black
# 1 == white
col = 1
vm = IntCode(data)
while True:
    col = vm.run([col])
    if col is None:
        break
    turn = vm.run()
    panels[tuple(curr_pos)] = col

    facing += 1 if turn else -1
    facing %= 4
    curr_pos = [curr_pos[0] + dirs[facing][0], curr_pos[1] + dirs[facing][1]]
    col = panels[tuple(curr_pos)]
print(len(panels))

x, y = max(panels, key=lambda p:p[0])[0], max(panels, key=lambda p:p[1])[1]
display = []
for row in range(y+1):
    display.append([])
    for col in range(x+1):
        display[row].append(' ')

for p, v in panels.items():
    x, y = p
    display[y][x] = v

for line in display:
    print(''.join('█' if c == 1 else ' ' for c in line))
