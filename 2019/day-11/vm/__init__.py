from typing import Union
from collections import defaultdict


class IntCode:
    def __init__(self, mem):
        self.mem = defaultdict(int, enumerate(map(int, mem)))
        self.input = []
        self.rb = 0
        self.ip = 0
        self.op = -1
        self.modes = []
        self.reads = []
        self.writes = []

    def _get_inst(self) -> None:
        mem = str(self.mem[self.ip]).zfill(5)
        self.op = int(mem[-2:])
        self.modes = [int(c) for c in mem[:-2][::-1]]

    def _get_args(self, size: int) -> None:
        args = [self.mem[self.ip + i] for i in range(1, size)]
        self.reads = [(self.mem[x], x, self.mem[x + self.rb])[m] for x, m in zip(args, self.modes)]
        self.writes = [(x, None, x + self.rb)[m] for x, m in zip(args, self.modes)]

    def run(self, inp=None) -> Union[None, int]:
        """
        Takes an integer, runs IntCode computer until output or halt

        :param inp: instruction input
        :return: output
        """
        if type(inp) == int:
            self.input.append(inp)
        elif type(inp) == list:
            for v in inp:
                self.input.append(v)
        while True:
            self._get_inst()
            if self.op == 99:  # Halt
                return None

            size = [0, 4, 4, 2, 2, 3, 3, 4, 4, 2][self.op]
            self._get_args(size)

            self.ip += size
            if self.op == 1:  # Add
                self.mem[self.writes[2]] = self.reads[0] + self.reads[1]

            elif self.op == 2:  # Multiply
                self.mem[self.writes[2]] = self.reads[0] * self.reads[1]

            elif self.op == 3:  # Input
                self.mem[self.writes[0]] = self.input.pop(0)  # inp.pop(0)

            elif self.op == 4:  # Output
                return int(self.reads[0])

            elif self.op == 5:  # Jump if Not Zero
                if self.reads[0]:
                    self.ip = self.reads[1]

            elif self.op == 6:  # Jump if Zero
                if not self.reads[0]:
                    self.ip = self.reads[1]

            elif self.op == 7:  # Less Than
                self.mem[self.writes[2]] = (self.reads[0] < self.reads[1])

            elif self.op == 8:  # Equals
                self.mem[self.writes[2]] = (self.reads[0] == self.reads[1])

            elif self.op == 9:  # Relative Base
                self.rb += self.reads[0]

            else:
                print(f'Unhandled error on code: {self.op}\nip = {self.ip}\nmem = {self.mem}')
                assert False


def tests():
    program = [3, 9, 8, 9, 10, 9, 4, 9, 99, -1, 8]
    for i in [7, 8, 9]:
        assert (IntCode(program).run([i]) == (i == 8))

    program = [3, 9, 7, 9, 10, 9, 4, 9, 99, -1, 8]
    for i in [7, 8, 9]:
        assert (IntCode(program).run([i]) == (i < 8))

    program = [3, 3, 1108, -1, 8, 3, 4, 3, 99]
    for i in [7, 8, 9]:
        assert (IntCode(program).run([i]) == (i == 8))

    program = [3, 3, 1107, -1, 8, 3, 4, 3, 99]
    for i in [7, 8, 9]:
        assert (IntCode(program).run([i]) == (i < 8))

    for i in [0, 1, -2]:
        program = [3, 12, 6, 12, 15, 1, 13, 14, 13, 4, 13, 99, -1, 0, 1, 9]
        assert (IntCode(program).run([i]) == (i != 0))
        program = [3, 3, 1105, -1, 9, 1101, 0, 0, 12, 4, 12, 99, 1]
        assert (IntCode(program).run([i]) == (i != 0))

    program = [3, 21, 1008, 21, 8, 20, 1005, 20, 22, 107, 8, 21, 20, 1006, 20, 31, 1106, 0, 36, 98, 0, 0, 1002, 21, 125,
               20, 4, 20, 1105, 1, 46, 104, 999, 1105, 1, 46, 1101, 1000, 1, 20, 4, 20, 1105, 1, 46, 98, 99]
    a = {7: 999, 8: 1000, 9: 1001}
    for i in [7, 8, 9]:
        assert IntCode(program).run(i) == a[i]
    print('tests passed')


if __name__ == '__main__':
    tests()

