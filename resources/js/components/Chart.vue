<template>
    <div id="chart">
        <canvas ref="chart" height="400px"></canvas>
    </div>
</template>

<script>
    import Chart from 'chart.js';

    export default {
        name: 'chart',

        props: {
            type: {
                default: 'line'
            },
            datasets: {
                required: true,
            },
            datalabel: {
                default: null,
            },
        },

        mounted() {
            var chart = this.$refs.chart;
            var ctx = chart.getContext("2d");
            var myChart = new Chart(ctx, {
                type: this.type,
                data: {
                    labels: this.datasets.labels,
                    datasets: this.datasets.datasets,
                },
                options: {
                    legend: {
                        display: true,
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    }
</script>