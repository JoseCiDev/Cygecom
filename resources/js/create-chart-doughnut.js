const createChartDoughnut = (canvasChartId, chartLabels, chartData, title = false, subtitle = false) => {
    const chartStatus = Chart.getChart(canvasChartId);
    if(chartStatus) {
        chartStatus.destroy();
    }

    const chartConfig = {
        type: 'doughnut',
        data: { labels: chartLabels, datasets: [{ data: chartData, }], },
        options: { plugins: { legend: { labels: { font: { size: 16, } } } } }
    };

    if(title) {
        chartConfig.options.plugins.title = {
            display: true,
            text: title,
            font: {size: 16, color: '#000'}
        }
    }

    if(subtitle) {
        chartConfig.options.plugins.subtitle = { display: true, text: subtitle, }
    }

    new Chart($(`#${canvasChartId}`), chartConfig);
}

const createChartBar = (canvasChartId, chartLabels = false, chartData = false, title = false, subtitle = false) => {
    const chartStatus = Chart.getChart(canvasChartId);
    if(chartStatus) {
        chartStatus.destroy();
    }

    const data = {
        labels: ['Jan', 'Feb', 'Jan','Mar', 'Apr', 'May', 'Jun', 'Jul',],
        datasets: [{
            label: 'My First Dataset',
            data: [65, 59, 80, 81, 56, 55, 40],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        },
      };

    new Chart($(`#${canvasChartId}`), config);
}

export {createChartDoughnut, createChartBar};
