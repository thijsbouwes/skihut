<template>
    <layout>
        <section>
            <div class="row data-cards">
                <div class="col s12 m6 l4 xl3">
                    <time-date></time-date>
                </div>
                <div class="col s12 m6 l4 xl3">
                    <number title="Events">
                        <div>Future: <span>{{ dashboard.future_event_count }}</span></div>
                        <div>Past: <span>{{ dashboard.past_event_count }}</span></div>
                    </number>
                </div>
                <div class="col s12 m6 l4 xl3">
                    <number title="Stock">
                        <div>Products: <span>{{ dashboard.products_in_stock }}</span></div>
                        <div>Value: <span>{{ dashboard.products_in_stock_price | formatNumber }}</span></div>
                    </number>
                </div>
                <div class="col s12 m6 l4 xl3">
                    <number title="Payments">
                        <div>Revenue: <span>{{ dashboard.revenue | formatNumber }}</span></div>
                        <div>Outstanding: <span>{{ dashboard.outstanding_money | formatNumber }}</span></div>
                    </number>
                </div>
            </div>

            <div class="row">
                <div class="col m6">
                    <data-table
                        name="Users with debt"
                        endpoint="users/debt"
                        :actions="actions"
                        :columns="debt_columns"
                        link_to_detail="users.show"
                    ></data-table>
                </div>
                <div class="col m6">
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
                dashboard: {
                    future_event_count: 0,
                    past_event_count: 0,
                    products_in_stock: 0,
                    products_in_stock_price: 0,
                    revenue: 0,
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
            this.$http.get(ENDPOINTS.DASHBOARD)
                .then(response => {
                    this.dashboard = response.data;
                });
        }
    }
</script>