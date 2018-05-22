<template>
    <section>
        <data-table
            endpoint="stocks"
            :columns="columns"
        ></data-table>
    </section>
</template>

<script>
    import DataTable from '../../components/DataTable';

    export default {
        components: {
            DataTable
        },

        data() {
            return {
                columns: [
                    {
                        name: 'Name',
                        data_name: 'name'
                    },
                    {
                        name: 'Datum',
                        data_name: 'order_date'
                    }
                ]
            }
        }
    }
</script>