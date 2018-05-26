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
                        name: 'Total quantity',
                        data_name: 'total_quantity'
                    },
                    {
                        name: 'Price',
                        data_name: 'total_products_price',
                        filter: 'formatNumber'
                    },
                    {
                        name: 'Date',
                        data_name: 'order_date'
                    }
                ]
            }
        }
    }
</script>