<template>
    <section>
        <div class="row data-cards">
            <div class="col s12 m6 l4">
                <time-date></time-date>
            </div>
            <div class="col s12 m6 l4">
                <number title="Details">
                    <div>Visited events: <span>{{ user.events.length }}</span></div>
                    <div>Last login: <span>{{ user.last_login | formatDate }}</span></div>
                </number>
            </div>
            <div class="col s12 m6 l4">
                <number title="Payments">
                    <div>Payed: <span>{{ payed | formatNumber }}</span></div>
                    <div>Outstanding: <span>{{ user.debt | formatNumber }}</span></div>
                </number>
            </div>
        </div>

        <div class="row">
            <div class="col s12 l8 offset-l2">
                <ul class="tabs">
                    <li class="tab col s3"><a class="active" href="#events">Events</a></li>
                    <li class="tab col s3"><a href="#products">Products</a></li>
                </ul>
            </div>
            <div id="events" class="col s12 l8 offset-l2">
                <simple-table
                    :rows="user.events"
                    :columns="event_columns"
                    name="Events visited"
                ></simple-table>
            </div>
            <div id="products" class="col s12 l8 offset-l2">
                <data-table
                    endpoint="products"
                    :columns="product_columns"
                    :actions="actions"
                    title="Products consumed"
                ></data-table>
            </div>
        </div>
    </section>
</template>

<script>
    import {ENDPOINTS} from "../../config/api";
    import SimpleTable from "../../components/SimpleTable";
    import DataTable from "../../components/DataTable";
    import TimeDate from '../../components/TimeDate';
    import Number from '../../components/Number';

    export default {
        components: {SimpleTable, DataTable, TimeDate, Number},

        data() {
            return {
                user: {
                    debt: 0,
                    last_login: 0,
                    events: []
                },
                actions: {
                    edit: false,
                    create: false
                },
                event_columns: [
                    {
                        name: 'Name',
                        data_name: 'name'
                    },
                    {
                        name: 'Price',
                        data_name: 'price',
                        filter: 'formatNumber'
                    },
                    {
                        name: 'Date',
                        data_name: 'event_date'
                    }
                ],
                product_columns: [
                    {
                        name: 'Name',
                        data_name: 'name'
                    },
                    {
                        name: 'Quantity',
                        data_name: 'quantity'
                    },
                    {
                        name: 'Quantity in stock',
                        data_name: 'in_stock_quantity'
                    }
                ]
            }
        },

        computed: {
            payed() {
                let event_prices = 0;
                this.user.events.map(event => event_prices += event.price);

                return event_prices > this.user.debt ? event_prices - this.user.debt : 0;
            }
        },

        created() {
            this.$http.get(ENDPOINTS.USER + '/' + this.$route.params.id)
                .then(response => {
                    this.user = response.data;
                });
        },

        mounted() {
            // Create Tabs
            let elem = document.querySelector('.tabs');
            let instance = this.$M.Tabs.init(elem);
        }
    }
</script>