<?php
$adapters = '73
114
100
122
10
141
89
70
134
2
116
30
123
81
104
42
142
26
15
92
56
60
3
151
11
129
167
76
18
78
32
110
8
119
164
143
87
4
9
107
130
19
52
84
55
69
71
83
165
72
156
41
40
1
61
158
27
31
155
25
93
166
59
108
98
149
124
65
77
88
46
14
64
39
140
95
113
54
66
137
101
22
82
21
131
109
45
150
94
36
20
33
49
146
157
99
7
53
161
115
127
152
128';

$adapters = collect(explode(PHP_EOL, $adapters))
  ->map(function ($adapter) {
    return (int) $adapter;
  })
  ->sort()
  ->toArray();

$adapters[] = 0;
sort($adapters);
$adapters[] = $adapters[count($adapters) - 1] + 3;

$adapterCount = count($adapters);
$combinations = [$adapterCount - 1 => 1];

for ($i = $adapterCount - 2; $i >= 0; $i--) {
  $count = 0;
  for (
    $j = $i + 1;
    $j < $adapterCount && $adapters[$j] - $adapters[$i] <= 3;
    $j++
  ) {
    $count += $combinations[$j];
  }
  $combinations[$i] = $count;
}

dd($combinations[0]);
