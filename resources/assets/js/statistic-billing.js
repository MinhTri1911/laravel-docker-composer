/**
 * Create js statistic billing
 *
 * @package App\Http\Controllers
 * @author quangpm
 * @date 2018/06/19
*/

$( document ).ready(function() {
  initDatePicker();
  initScrollbar();
  initChart();
});

/**
 * Init datetimepicker
 * 
 * @returns void
 */
function initDatePicker() {
  $('#start-create-paper-date').datepicker({
    dateFormat: "yy/mm/dd"
  });
}

/**
 * Init scrollbar
 * 
 * @returns void
 */
function initScrollbar() {
  var scroll;

  scroll = document.querySelector('#block-tbl-statistic');
  new PerfectScrollbar(scroll, function () {
    table.style.width = '897px'
  });

  scroll = document.querySelector('.table-statistic tbody');
  new PerfectScrollbar(scroll, function () {
    table.style.height = '675px'
  });
}

/**
 * Init Chart statistic billing
 * 
 * @returns void
 */
function initChart() {
  var ctx = document.getElementById("chart-billing").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["サービス 1", "サービス 2", "サービス 3", "サービス 4", "サービス 5", "サービス 6", 
        "サービス 7", "サービス 8", "サービス 9", "サービス 10", "サービス 11", "サービス 12"],
      datasets: [{
        label: 'サービス',
        data: [1200, 1900, 3800, 1500, 2000, 3000, 1200, 1900, 3800, 1500, 2000, 3000],
        backgroundColor: 'rgba(2, 79, 249, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero:true
          }
        }]
      }
    }
  });
}