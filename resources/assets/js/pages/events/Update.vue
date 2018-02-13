<template>
    <div>
        <span class="card-title">Update event</span>
        <event :event="event"></event>
    </div>
</template>

<script>
    import Event from './Event';
    import { ENDPOINTS } from "../../config/api";

    export default {
        components: {
            Event
        },

        data() {
            return {
                event: {}
            }
        },

        created() {
            this.$http.get(ENDPOINTS.EVENTS + '/' + this.$route.params.id)
                .then(response => {
                    this.event = response.data;
                    this.event.users = [];
                    this.event.products = [];
                });
        }
    }
</script>