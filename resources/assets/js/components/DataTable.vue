<template>
    <div>
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
                    <td v-for="column in columns">{{ row[column.data_name] }}</td>
                </tr>
            </tbody>
        </table>

        <ul class="pagination">
            <li :class="[back ? 'waves-effect' : 'disabled']">
                <a @click="move(current_page - 1)" href="#!"><i class="material-icons">chevron_left</i></a>
            </li>

            <li v-for="page in last_page" :class="{ 'active': current_page === page, 'waves-effect': current_page !== page}">
                <a @click="move(page)" href="#!">{{ page }}</a>
            </li>

            <li :class="[forward ? 'waves-effect' : 'disabled']">
                <a @click="move(current_page + 1)" href="#!"><i class="material-icons">chevron_right</i></a>
            </li>
        </ul>

        <div class="progress" v-show="loading">
            <div class="indeterminate"></div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            columns: {
                required: true,
                type: Array
            },
            actions: {
                required: false,
                type: Array,
                default: []
            },
            endpoint: {
                required: true,
                type: String
            }
        },

        data() {
            return {
                loading: true,
                current_page: 1,
                last_page: 1,
                rows: []
            }
        },

        computed: {
            back() {
                return this.current_page !== 1;
            },
            forward() {
                return this.current_page !== this.last_page;
            }
        },

        created() {
            this.getTableData();
        },

        methods: {
            move(page_number) {
                if (this.current_page === page_number || page_number < 1 || page_number > this.last_page) {
                    console.log(`error at page ${page_number}`);
                    return;
                }

                this.loading = true;
                this.getTableData(page_number);
            },

            getTableData(page_number = 1) {
                this.$http.get(this.endpoint + `?page=${page_number}` )
                    .then(response => {
                        this.current_page = response.data.current_page;
                        this.last_page = response.data.last_page;
                        this.rows = response.data.data;
                        this.loading = false;
                    })
            }
        }
    }
</script>