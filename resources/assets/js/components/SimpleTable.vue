<template>
    <div class="card">
        <div class="card-content">

            <span class="card-title">
                {{ this.name | capitalize }}
            </span>

            <table class="striped responsive-table">
                <thead>
                    <tr>
                        <th v-for="column in columns"
                            v-text="column.name"
                        ></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in rows">
                        <td v-for="column in columns">{{ dynamicFilter(column.filter, row[column.data_name]) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            rows: {
                type: Array,
                required: true,
                default: []
            },
            name: {
                type: String,
                default: null
            },
            columns: {
                required: true,
                type: Array
            }
        },

        data() {
            return {
                title: "",
            }
        },

        methods: {
            dynamicFilter(filter, value) {
                if (filter && filter in this.$options.filters) {
                    return this.$options.filters[filter](value);
                }

                return value;
            }
        }
    }
</script>