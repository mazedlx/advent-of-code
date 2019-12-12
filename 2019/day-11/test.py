from operator import add, mul
from collections import defaultdict

oper = {1: add, 2: mul}

with open('11.in') as f:
    data = list(map(int, f.read().split(',')))
    mem = defaultdict(int, enumerate(map(int, data)))
    # print(mem)


def int_code(seq: list, i=0, inp: int = 0) -> list:
    output = []
    rb = 0
    while True:
        inst = mem[i]
        if inst == 99:
            return [None, None, None]
        a = b = c = 0
        if inst > 100:
            inst, params = inst % 100, inst // 100
            c = params % 10
            params //= 10
            b = params % 10
            params //= 10
            a = params % 10
            params //= 10
        if inst in [1, 2, 5, 6, 7, 8]:
            if c == 0:
                p_1 = mem[mem[i + 1]]
            elif c == 1:
                p_1 = mem[i + 1]
            elif c == 2:
                p_1 = mem[rb + mem[i + 1]]

            if b == 0:
                p_2 = mem[mem[i + 2]]
            elif b == 1:
                p_2 = mem[i + 2]
            elif b == 2:
                p_2 = mem[rb + mem[i + 2]]
            if a == 2:
                index = rb + mem[i + 3]
            else:
                index = mem[i + 3]

            if inst in [1, 2]:
                mem[index] = oper[inst](p_1, p_2)
                i += 4
            elif inst == 5:
                i = p_2 if p_1 != 0 else (i + 3)
            elif inst == 6:
                i = p_2 if p_1 == 0 else (i + 3)
            elif inst == 7:
                mem[index] = 1 if p_1 < p_2 else 0
                i += 4
            elif inst == 8:
                mem[index] = 1 if p_1 == p_2 else 0
                i += 4
        elif inst == 3:
            code = mem[i]
            if code // 100 == 2:
                mem[rb + mem[i + 1]] = inp
            else:
                mem[mem[i + 1]] = inp
            i += 2
        elif inst == 4:
            if c == 0:
                index = mem[i + 1]
            elif c == 1:
                index = i + 1
            elif c == 2:
                index = rb + mem[i + 1]
            output.append(mem[index])
            # print(output)
            i += 2
            if len(output) == 2:
                o = output[:]
                output = []
                return mem, i, o
        elif inst == 9:
            if c == 0:
                index = mem[i + 1]
            elif c == 1:
                index = i + 1
            elif c == 2:
                index = rb + mem[i + 1]
            rb += mem[index]
            i += 2
        else:
            print(f'Unhandled error on code: {seq[i]}')
            return [-1]  # error


print('Part 1:')
inp = 0
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
i = 0
inp = 0
while mem:
    print(f'\ncurr_pos: {curr_pos}')
    mem, i, inp = int_code(mem, i, inp)
    if not inp:
        break
    inp, dir = inp
    panels[tuple(curr_pos)] = inp
    facing += 1 if dir else -1
    facing %= 4
    curr_pos = [curr_pos[0] + dirs[facing][0], curr_pos[1] + dirs[facing][1]]
    print(f'facing: {facing}\ncurr_pos: {curr_pos}')
    inp = panels[tuple(curr_pos)]
print(len(panels))

# print('Part 2:')
# print(int_code(data[:], 2))
