<template>
    <section>
        <event-info :event="event"></event-info>
        <event :event="event" @submit="updateEvent">Update {{ event.name }}</event>
    </section>
</template>

<script>
    import Event from './Event';
    import EventInfo from './EventInfo';
    import { ENDPOINTS } from "../../config/api";

    export default {
        components: {
            Event,
            EventInfo
        },

        data() {
            return {
                event: {
                    name: "",
                    event_date: "",
                    price: 0,
                    users: [],
                    products: [],
                }
            }
        },

        created() {
            this.$http.get(ENDPOINTS.EVENTS + '/' + this.$route.params.id)
                .then(response => {
                    this.event = response.data;

                    this.event.products = response.data.products.map(product => {
                        return { quantity: product.pivot.quantity, ...product };
                    });

                    this.event.users = response.data.users.map(user => {
                        return { payed: user.pivot.payed_date !== null, ...user };
                    });
                });
        },

        methods: {
            updateEvent(event) {
                this.$http.patch(ENDPOINTS.EVENTS + '/' + event.id, event)
                    .then(response => {
                        this.$router.push('/events');
                        this.$M.toast({ html: `Event ${this.event.name} updated`, classes: 'green' });
                    })
                    .catch(error => {
                        this.showErrors(error);
                    })
            }
        }
    }
</script>