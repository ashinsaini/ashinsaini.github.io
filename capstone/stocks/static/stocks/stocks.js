document.addEventListener('DOMContentLoaded', () => {
  let ticker = document.querySelector('#symbol').innerText;
  let user = document.querySelector('#userid').innerText;
  document.addEventListener('click', event => {
    const element = event.target;
    let id = element.id.slice(4);
    if (document.querySelector(`#btn_${id}`)) {
      document.getElementById('myChart').remove();
      document.getElementById('vol_chart').remove();

      chart(ticker, id);
    } else {
      document.getElementById('myChart').style.display = 'block';
    }
  })
  document.getElementById('responsive_dates').style.display='block';
  chart(ticker, 5);
  avatar(user);
})

function avatar(user){
  document.getElementById("username").src=`http://127.0.0.1:8000/media/images/avatar-${user}`
}

function chart(ticker, days) {

  fetch(`/chart/${ticker}/${days}`)
    .then(response => response.json())
    .then(getdata => {
      ccreate(getdata, ticker, days)
      vol_chart(getdata['volume'],getdata['date'],getdata['close'],ticker,days)
      console.log(Object.values(getdata['volume']),Object.values(getdata['close']).sort((a, b) => { return Math.max(a - b) }));
    });
  }

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
          backgroundColor: ['rgba(38, 12, 12, 0.1)'],
          borderColor: ['rgba(33, 45, 170, 0.93)'],
          borderDash: [5, 5],
          fill: false
        },
        {
          label: `SP of ${ticker}`,
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
      ]
    }


    const config = {
      type: 'line',
      data: data,
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: {
            position: 'top',
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
      console.log(`Chart updated ${days}`);
    } else {
      console.log('Chart did not display');
    }
  }


function vol_chart(vol,dte,close,ticker,days){

  let time = Object.values(dte)
  const dataa  = Object.values(close)
  let final_dash = dataa.fill(dataa[0], 0)
  let dates = Array.from(time, v => [String(new Date(v).getFullYear()) + ' / ' + String(new Date(v).getMonth() + 1) + ' / ' + String(new Date(v).getDate())])
  let div = document.querySelector('#vol_chart')
   const skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;
    const down = (ctx, value) => ctx.p0.parsed.y > ctx.p1.parsed.y ? value : undefined;
    const data = {
      labels: dates,
      datasets: [
        {
          label: "Trades",
          data : Object.values(vol),
          backgroundColor: ['rgba(18,236,211,0.6)'],
          borderRadius: 5,
          borderWidth: 1
        }
       ]
    }
  const config = {
    type: 'bar',
    data: data,
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom',
        },
        title: {
          display :true,
          text: "Trade Volume"
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
            text: 'Shares volume'
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

  if (days === 30 || 90 || 180 || 365) {

    let c = document.createElement('canvas');
   c.id = `vol_chart`
    var divv = document.querySelector('#Chart_ii');
    divv.append(c)
  } else {
    console.log('vol_chart did not display');
  }
}
