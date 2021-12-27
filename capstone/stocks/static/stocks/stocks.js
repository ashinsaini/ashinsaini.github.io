document.addEventListener('DOMContentLoaded', () => {
  let ticker = document.querySelector('#symbol').innerText;
  document.addEventListener('click', event => {
    const element = event.target;
    let id = element.id.slice(4);
    if (element.id = `btn_${id}`) {
      document.getElementById('myChart').remove();
      chart(ticker, id);
    } else {
      chart(ticker, 5);
    }
    //if(element.id = 'lin_regress'){
    // sessionStorage.setItem('lin',true);
    // chart(ticker, 60);
    //}else{
    //  console.log('an error occurred with your poor coding.')}

  })
  chart(ticker, 5)
})

function chart(ticker, days) {

  fetch(`/stocks/chart/${ticker}/${days}`)
    .then(response => response.json())
    .then(getdata => {
      ccreate(getdata, ticker, days)
      console.log(getdata, Object.values(getdata['close']).sort((a, b) => { return Math.max(a - b) }));
    });


  function ccreate(getdata, ticker, days) {

    const skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;
    const down = (ctx, value) => ctx.p0.parsed.y > ctx.p1.parsed.y ? value : undefined;
    let div = document.querySelector('#myChart')
    const data_dash = Object.values(getdata['close'])
    let final_dash = data_dash.fill(data_dash[0], 0)
    let dates_year = Object.values(getdata['date'])
    let high = Object.values(getdata['high'])
    let low = Object.values(getdata['low'])
    let dates = Array.from(dates_year, v => [String(new Date(v).getFullYear()) + ' / ' + String(new Date(v).getMonth() + 1) + ' / ' + String(new Date(v).getDate())])
    const data = {
      labels: dates,
      datasets: [
        {
          label: 'Price Differential',
          data: final_dash,
          backgroundColor: ['grey'],
          borderColor: ['grey'],
          borderDash: [5, 5],
          fill: false
        },
        {
          label: `${days} Day SP of ${ticker}`,
          data: Object.values(getdata['close']),
          backgroundColor: ['rgba(0,99,132,1)'],
          borderColor: ['rgba(0,250,0,0.9)'],
          segment: {
            borderColor: data_dash => skipped(data_dash, 'rgb(0,0,0,0.2)') || down(data_dash, 'rgb(250,75,0,0.9)'),
          },
          borderWidth: 1,
          fill: false,
          spanGaps: true,
          cubicInterpolationMode: 'monotone',
          tension: 0.4,
          fill: { above: ['rgba(0,195,0,0.5)'], below: ['rgb(255,0,0,0.6'], target: { value: final_dash[0] } }
        }
       ,{
          label: 'Highs and lows',
          data: array_sep(high,low),
          backgroundColor: ['rgba(0,0,220,0.6)'],
          borderRadius: 5,
          borderWidth: 1,
          type: 'bar'

        }
      ]
    }
    const config = {
      type: 'line',
      data: data,
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom',
          }
        },
        interaction: {
          mode: 'index',
          intersect: false
        },
        scales: {
          y: {
            beginAtZero: false,
            title: {
              display: true,
              text: 'Price'
            }
          },
          x: {
            title: {
              display: true,
              text: `Dates : Past ${days} days`
            }
          }
        }
      }
    }

    const mychart = new Chart(div, config);
    console.log(mychart.data);

    if (days === 30 || 90 || 180 || 365) {
      let c = document.createElement('canvas');
      c.id = `myChart`
      var divv = document.querySelector('#Chart');
      divv.append(c)
      var mymychart = new Chart(document.querySelector(`#myChart`), config);
      console.log(`Chart updated ${days}`);
    } else {
      console.log('Chart did not display');
    }

  }
}

function findLineByLeastSquares(values_x, values_y) {
  var sum_x = 0;
  var sum_y = 0;
  var sum_xy = 0;
  var sum_xx = 0;
  var count = 0;

  /*
   * We'll use those variables for faster read/write access.
   */
  var x = 0;
  var y = 0;
  var values_length = values_x.length;

  if (values_length != values_y.length) {
    throw new Error('The parameters values_x and values_y need to have same size!');
  }

  /*
   * Nothing to do.
   */
  if (values_length === 0) {
    return [[], []];
  }

  /*
   * Calculate the sum for each of the parts necessary.
   */
  for (var v = 0; v < values_length; v++) {
    x = values_x[v];
    y = values_y[v];
    sum_x += x;
    sum_y += y;
    sum_xx += x * x;
    sum_xy += x * y;
    count++;
  }

  /*
   * Calculate m and b for the formular:
   * y = x * m + b
   */
  var m = (count * sum_xy - sum_x * sum_y) / (count * sum_xx - sum_x * sum_x);
  var b = (sum_y / count) - (m * sum_x) / count;

  /*
   * We will make the x and y result line now
   */
  var result_values_x = [];
  var result_values_y = [];

  for (var v = 0; v < values_length; v++) {
    x = values_x[v];
    y = x * m + b;
    result_values_x.push(x);
    result_values_y.push(y);
  }

  return [result_values_x, result_values_y];
}

function array_sep(high,low){
    var y = []
    for(var x = 0; x < high.length; x++){
      final=[high[x],low[x]];
      y.push(final);
    }
    return y;
}