<template>
    <layout>
        <section>
            <div class="row">
                <div class="input-field col s6">
                    <select v-model="filters.year" @change="fetchDashboard">
                        <option value="" selected>Choose your option</option>
                        <option
                            v-for="(year, index) in yearOptions"
                            :key="index"
                            :value="year"
                        >{{ year }}</option>
                    </select>
                    <label>Year</label>
                </div>
                <div class="input-field col s6">
                    <select v-model="filters.month" @change="fetchDashboard">
                        <option value="" selected>Choose your option</option>
                        <option
                            v-for="(month, index) in monthOptions"
                            :key="index"
                            :value="month"
                        >{{ month }}</option>
                    </select>
                    <label>Month</label>
                </div>

                <div class="col s12">
                    <div class="progress" v-show="loading">
                        <div class="indeterminate"></div>
                    </div>
                </div>
            </div>

            <div class="row data-cards">
                <div class="col s12 m6 l4 xl3">
                    <time-date></time-date>
                </div>
                <div class="col s12 m6 l4 xl3">
                    <number title="Events">
                        <div>Future: <span>{{ dashboard.future_event_count }}</span></div>
                        <div>Total: <span>{{ dashboard.total_event_count }}</span></div>
                    </number>
                </div>
                <div class="col s12 m6 l4 xl3">
                    <number title="Payments">
                        <div>Profit: <span>{{ dashboard.profit | formatNumber }}</span></div>
                        <div>Outstanding: <span>{{ dashboard.outstanding_money | formatNumber }}</span></div>
                    </number>
                </div>
                <div class="col s12 m6 l4 xl3">
                    <number title="Stock">
                        <div>Products: <span>{{ dashboard.products_in_stock }}</span></div>
                        <div>Value: <span>{{ dashboard.products_in_stock_price | formatNumber }}</span></div>
                    </number>
                </div>
            </div>

            <div class="row">
                <div class="col s12 l6">
                    <data-table
                        name="Users with debt"
                        endpoint="users/debt"
                        :actions="actions"
                        :columns="debt_columns"
                        link_to_detail="users.show"
                    ></data-table>
                </div>
                <div class="col s12 l6">
                    <data-table
                        name="Products in stock"
                        endpoint="products/stock"
                        :actions="actions"
                        :columns="stock_columns"
                        :paginate="false"
                    ></data-table>
                </div>
            </div>
        </section>
    </layout>
</template>

<script>
    import Layout from '../layouts/main/Layout';
    import TimeDate from '../components/TimeDate';
    import Number from '../components/Number';
    import {ENDPOINTS} from "../config/api";
    import DataTable from "../components/DataTable";

    export default {
        components: {DataTable, Layout, TimeDate, Number},

        data() {
            return {
                loading: false,
                filters: {
                    year: this.$moment().format('YYYY'),
                    month: this.$moment().format('MMMM')
                },
                dashboard: {
                    future_event_count: 0,
                    total_event_count: 0,
                    products_in_stock: 0,
                    products_in_stock_price: 0,
                    profit: 0,
                    outstanding_money: 0
                },
                actions: {
                    edit: false,
                    create: false
                },
                debt_columns: [
                    {
                        name: 'Name',
                        data_name: 'name'
                    },
                    {
                        name: 'Debts',
                        data_name: 'debt',
                        filter: 'formatNumber'
                    }
                ],
                stock_columns: [
                    {
                        name: 'Name',
                        data_name: 'name'
                    },
                    {
                        name: 'In stock',
                        data_name: 'in_stock_quantity'
                    },
                    {
                        name: 'Used',
                        data_name: 'quantity_used'
                    }
                ]
            }
        },

        created() {
            this.fetchDashboard();
        },

        mounted() {
            let elems = document.querySelectorAll('select');
            let instances = this.$M.FormSelect.init(elems);
        },

        computed: {
            yearOptions() {
                let start = this.$moment("2018-01-01");
                let years = [];

                while (start.isSameOrBefore(this.$moment())) {
                    years.push(start.format("YYYY"));
                    start = start.add(1, 'year');
                }

                return years;
            },

            monthOptions() {
                return this.$moment.months();
            }
        },

        methods: {
            fetchDashboard() {
                if (this.loading) {
                    return;
                }

                this.loading = true;
                let params = {};

                if (this.filters.year) {
                    params.year = this.filters.year;
                }
                if (this.filters.month) {
                    params.month = this.$moment().month(this.filters.month).format("M");
                }

                this.$http.get(ENDPOINTS.DASHBOARD, { params } )
                    .then(response => {
                        this.dashboard = response.data;
                        this.loading = false;
                    });
            }
        }
    }
</script>