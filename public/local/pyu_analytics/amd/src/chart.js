define(['core/chartjs'], function(ChartJs) {
    return {
        init: function(engagementData, heatmapData) {
            engagementData = engagementData || {labels: [], values: []};
            heatmapData = heatmapData || {labels: [], values: []};

            const ctxEng = document.getElementById('engagementTrendChart');
            if (ctxEng && ChartJs) {
                new ChartJs(ctxEng, {
                    type: 'line',
                    data: {
                        labels: engagementData.labels || [],
                        datasets: [{
                            label: 'Active Users',
                            data: engagementData.values || [],
                            borderColor: '#3F4594',
                            backgroundColor: 'rgba(63, 69, 148, 0.1)',
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            }

            const ctxHeat = document.getElementById('courseHeatmap');
            if (ctxHeat && ChartJs && heatmapData.labels && heatmapData.labels.length) {
                new ChartJs(ctxHeat, {
                    type: 'bar',
                    data: {
                        labels: heatmapData.labels,
                        datasets: [{
                            label: 'Engagement %',
                            data: heatmapData.values,
                            backgroundColor: 'rgba(63, 69, 148, 0.6)',
                        }]
                    },
                    options: {
                        responsive: true,
                        indexAxis: 'y',
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { beginAtZero: true, max: 100 }
                        }
                    }
                });
            }
        }
    };
});
