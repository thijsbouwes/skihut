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
                <event-table
                    :events="user.events"
                    :columns="event_columns"
                    :selection="selection"
                    :user="user_id"
                ></event-table>
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
    import EventTable from "../../components/EventTable";
    import DataTable from "../../components/DataTable";
    import TimeDate from '../../components/TimeDate';
    import Number from '../../components/Number';

    export default {
        components: {EventTable, DataTable, TimeDate, Number},

        data() {
            return {
                selection: false,
                user_id: null,
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
            if (typeof this.$route.params.id !== 'undefined') {
                this.selection = true;
                this.user_id = this.$route.params.id;

                this.$http.get(ENDPOINTS.USER + '/' + this.$route.params.id)
                    .then(response => {
                        this.user = response.data;
                    });
            } else {
                this.$store.dispatch('profile/loadProfile')
                    .then(response => {
                        this.user = this.$store.getters['profile/user'];
                    });

            }
        },

        mounted() {
            // Create Tabs
            let elem = document.querySelector('.tabs');
            let instance = this.$M.Tabs.init(elem);
        }
    }
</script>