<template>
    <div class="card">
        <div class="card-content">

            <span class="card-title">Events visited</span>

            <table class="striped responsive-table">
                <thead>
                    <tr>
                        <th v-if="selection">
                            <p><label><input type="checkbox" class="filled-in" v-model="selectAllState" @change="selectAll"/><span></span></label></p>
                        </th>
                        <th v-for="column in columns"
                            v-text="column.name"
                        ></th>
                        <th>Payed</th>
                    </tr>
                </thead>
                <tbody>
                <tr></tr>
                    <tr v-for="event in events">
                        <td v-if="selection">
                            <p><label>
                                <input type="checkbox" class="filled-in" v-model="event.pivot.payed"/>
                                <span></span>
                            </label></p>
                        </td>
                        <td v-for="column in columns">{{ dynamicFilter(column.filter, event[column.data_name]) }}</td>
                        <td v-html="payedIcon(event.pivot.payed)"></td>
                    </tr>
                </tbody>
            </table>

            <button class="btn waves-effect waves-light modal-action modal-close" @click="saveEventPayments" name="action">Save</button>
        </div>
    </div>
</template>
<script>
    import {ENDPOINTS} from "../config/api";
    import ValidationErrors from '../mixins/validationError';

    export default {
        mixins: [ValidationErrors],

        props: {
            selection: {
                type: Boolean,
                default: true,
            },
            user: {
                default: null
            },
            events: {
                type: Array,
                required: true,
                default: []
            },
            columns: {
                required: true,
                type: Array
            }
        },

        data() {
            return {
                title: "",
                selectAllState: false,
            }
        },

        methods: {
            dynamicFilter(filter, value) {
                if (filter && filter in this.$options.filters) {
                    return this.$options.filters[filter](value);
                }

                return value;
            },

            saveEventPayments() {
                this.$http.post(ENDPOINTS.EVENTS_PAYED + '/' + this.user, { events: this.events })
                    .then(response => {
                        this.$router.push('/dashboard');
                        this.$M.toast({ html: `User payments updated`, classes: 'green' });
                    })
                    .catch(error => {
                        this.showErrors(error);
                    })
            },

            payedIcon(payed) {
                if (payed) {
                    return '<i class="material-icons">check</i>'
                }

                return '<i class="material-icons">clear</i>'
            },

            selectAll() {
                this.events.map(row => {
                    row.pivot.payed = this.selectAllState;
                });
            }
        }
    }
</script>