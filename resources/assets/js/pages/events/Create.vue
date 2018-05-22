<template>
    <section>
        <event-info :event="event"></event-info>
        <event :event="event" @submit="saveEvent">Create event</event>
    </section>
</template>

<script>
    import Event from './Event';
    import EventInfo from './EventInfo';
    import { ENDPOINTS } from '../../config/api';
    import ValidationErrors from '../../mixins/validationError';

    export default {
        mixins: [ValidationErrors],

        components: {
            Event,
            EventInfo
        },

        data() {
            return {
                event: {
                    name: "Skihut",
                    event_date: "",
                    price: 10,
                    users: [],
                    products: [],
                }
            }
        },

        methods: {
            saveEvent(event) {
                this.$http.post(ENDPOINTS.EVENTS, event)
                    .then(response => {
                        this.$router.push('/events');
                        this.$M.toast({ html: `Event ${this.event.name} created`, classes: 'green' });
                    })
                    .catch(error => {
                        this.showErrors(error);
                    })
            }
        }
    }
</script>