const fs = require('fs');
const input = 'input2019-16.txt';

fs.readFile(input, 'utf8', (err, data) => {
  if (err) throw err;
  var numberStream = Array(801).fill(data).join('').split(''); // Notice how the offset is always near the end.
  var messageOffset = Number(numberStream.slice(0, 7).join('')) - (650 * (10000 - 801));
  numberStream.forEach((num, index) => {
    numberStream[index] = Number(num);
  });
  var newStream = [];
  for (let a = 0; a < 100; a++) {
    let sum = 0;
    for (let n = numberStream.length - 1; n >= 0; n--) {
      sum += numberStream[n];
      newStream[n] = Math.abs(sum % 10);
    }
    for (let k = 0; k < numberStream.length; k++) {
      numberStream[k] = newStream[k];
    }
  }
  var output = numberStream.slice(messageOffset, messageOffset + 8).join('');
  console.log(output);
});
