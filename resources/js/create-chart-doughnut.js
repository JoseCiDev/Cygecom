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

export default createChartDoughnut;
