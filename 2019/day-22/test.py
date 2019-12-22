import sys
DECK = [i for i in range(10007)]
for line in open(sys.argv[1]).readlines():
   line = line.strip()
   if line == 'deal into new stack':
        DECK = list(reversed(DECK))
   if line.startswith('cut'):
       n = int(line.split(' ')[1])
       DECK = DECK[n:]+DECK[:n]
   if line.startswith('deal with increment'):
       n = int(line.split()[-1])
       NEW_DECK = list(DECK)
       for i in range(len(DECK)):
           NEW_DECK[(n*i)%len(NEW_DECK)] = DECK[i]
       DECK = NEW_DECK
   #print(line,[i for i in range(len(DECK)) if DECK[i]==5198])
for i in range(len(DECK)):
    if DECK[i] == 2019:
        print(i)

