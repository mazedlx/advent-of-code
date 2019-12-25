import itertools
import sys
from collections import defaultdict, deque
import random
from copy import deepcopy

class Program(object):
    def __init__(self, pid, program_file, input):
        self.P = defaultdict(int)
        with open(program_file) as fin:
            for i,x in enumerate(fin.read().split(',')):
                self.P[i] = int(x)
        self.input = input
        self.ip = 0
        self.pid = pid
        self.rel_base = 0
        self.halted = False
    def idx(self, i, I):
        mode = (0 if i>=len(I) else I[i])
        val = self.P[self.ip+1+i]
        if mode == 0:
            pass # no-op
        elif mode == 2:
            val = val+self.rel_base
        else:
            assert False, mode
        return val
    def val(self, i, I):
        mode = (0 if i>=len(I) else I[i])
        val = self.P[self.ip+1+i]
        if mode == 0:
            val = self.P[val]
        elif mode == 2:
            val = self.P[val+self.rel_base]
        return val
    def run_all(self):
        ans = []
        while True:
            val = self.run()
            if val == None:
                return ans
            ans.append(val)

    def run(self, timeout=None):
        """Return next output"""
        t = 0
        while (not timeout) or (t<timeout):
            cmd = str(self.P[self.ip])
            opcode = int(cmd[-2:])
            I = list(reversed([int(x) for x in cmd[:-2]]))
            if opcode == 1:
                i1,i2 = self.val(0,I),self.val(1,I)
                self.P[self.idx(2, I)] = self.val(0, I) + self.val(1, I)
                self.ip += 4
            elif opcode == 2:
                i1,i2 = self.val(0,I),self.val(1,I)
                self.P[self.idx(2, I)] = self.val(0, I) * self.val(1, I)
                self.ip += 4
            elif opcode == 3:
                inp = self.input()
                self.P[self.idx(0, I)] = inp #self.Q[0]
                #self.Q.pop(0)
                self.ip += 2
            elif opcode == 4:
                ans = self.val(0, I)
                self.ip += 2
                return ans
            elif opcode == 5:
                self.ip = self.val(1, I) if self.val(0, I)!=0 else self.ip+3
            elif opcode == 6:
                self.ip = self.val(1, I) if self.val(0, I)==0 else self.ip+3
            elif opcode == 7:
                self.P[self.idx(2, I)] = (1 if self.val(0,I) < self.val(1,I) else 0)
                self.ip += 4
            elif opcode == 8:
                self.P[self.idx(2, I)] = (1 if self.val(0,I) == self.val(1,I) else 0)
                self.ip += 4
            elif opcode == 9:
                self.rel_base += self.val(0, I)
                self.ip += 2
            else:
                assert opcode == 99, opcode
                self.halted = True
                return None
            t += 1
        return None

N = 50
Q = [deque([i]) for i in range(N)]
def get_input(i):
    if Q[i]:
        return Q[i].popleft()
    return -1

NAT = None
LAST_NAT = None
P = []
for i in range(N):
  P.append(Program(i, sys.argv[1], lambda: get_input(i)))
change = 0
t = 0
while True:
  #print(t,change)
  if t>change+500:
    assert NAT is not None
    Q[0].append(NAT[0])
    Q[0].append(NAT[1])
    print(NAT)
    if LAST_NAT and NAT[1] == LAST_NAT:
      print(LAST_NAT)
      sys.exit(0)
    LAST_NAT = NAT[1]
    change = t
  for i in range(N):
    addr = P[i].run(timeout=10)
    if addr == None:
      continue
    change = t
    x = P[i].run()
    y = P[i].run()
    #print(i,x,y,addr)
    if addr == 255:
      print(addr,x,y)
      NAT = (x,y)
    else:
      assert addr<N
      Q[addr].append(x)
      Q[addr].append(y)
  t += 1

