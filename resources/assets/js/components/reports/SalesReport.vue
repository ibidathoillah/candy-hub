<template>
    <div>

        <div class="panel">
            <div class="panel-heading" v-if="showControls">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Rentang Tanggal</label>
                            <candy-daterange-picker @update="update" :from="fromDate.format('YYYY-MM-DD')" :to="toDate.format('YYYY-MM-DD')" />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label>Frekuensi</label>
                            <select class="form-control" v-model="viewMode" @change="refresh">
                                <option value="daily">Harian</option>
                                <option value="weekly">Mingguan</option>
                                <option value="monthly">Bulanan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label>Tipe Grafik</label>
                            <select class="form-control" v-model="style" @change="refresh">
                                <option value="line">Garis</option>
                                <option value="bar">Bar</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div v-show="loading">
                    <span><i class="fa fa-sync fa-spin"></i></span> Memuat Laporan
                </div>
                <canvas ref="graph" v-show="!loading"/>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            to: {
                type: String
            },
            from: {
                type: String,
            },
            mode: {
                type: String,
                default: 'weekly',
            },
            showControls: {
                type: Boolean,
                default: true,
            }
        },
        data() {
            return {
                chart: null,
                loading: true,
                fromDate: this.from,
                toDate: this.to,
                viewMode: this.mode,
                style: 'line',
            }
        },
        created() {
            if (!this.fromDate || !this.toDate) {
                this.fromDate = moment().subtract(1, 'months');
                this.toDate = moment().add(1, 'day');
            } else {
                this.fromDate = moment(this.from).subtract(1, 'months');
                this.toDate = moment(this.to);
            }
            this.refresh();
        },
        methods: {
            update(event) {
                this.fromDate = event.start;
                this.toDate = event.end;

                this.refresh();
            },
            refresh() {
                this.loading = true;
                // Get the report we want.
                apiRequest.send('GET', '/reports/sales', {}, {
                    from: this.fromDate.format('YYYY-MM-DD'),
                    to: this.toDate.format('YYYY-MM-DD'),
                    mode: this.viewMode,
                }).then(response => {
                    const ctx = this.$refs.graph.getContext("2d");
                    this.loading = false;

                    if (this.chart) {
                        this.chart.destroy();
                    }

                    this.chart = new Chart(ctx, {
                        type: this.style,
                        data: response,
                        options: {
                            responsive: true,
                            tooltips: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        var label = tooltipItem.yLabel;
                                        if (tooltipItem.datasetIndex == 1) {
                                            label = 'IDR' + tooltipItem.yLabel.money();
                                        }
                                        return data.datasets[tooltipItem.datasetIndex].label + ': ' + label;
                                    }
                                }
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Mingguan'
                                    }
                                }],
                                yAxes: [
                                    {
                                        id: 'A',
                                        position:'left',
                                        ticks: {
                                            beginAtZero: true
                                        },
                                        scaleLabel: {
                                            display: true,
                                            labelString: '# Total Pemesanan'
                                        }
                                    },
                                    {
                                        id: 'B',
                                        position:'right',
                                        ticks: {
                                            beginAtZero: true,
                                            callback: function(value, index, values) {
                                                return 'IDR' + value.money();
                                            }
                                        },
                                        scaleLabel: {
                                            display: true,
                                            labelString: 'Total Harga'
                                        }
                                    }
                                ]
                            }
                        }
                    });
                }).catch(errors => {
                });
            }
        }
    }
</script>

<style scoped>

</style>
