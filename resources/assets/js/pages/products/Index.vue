<template>
    <section>
        <data-table
            endpoint="products"
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
                        name: 'Price',
                        data_name: 'price',
                        filter: 'formatNumber'
                    },
                    {
                        name: 'In stock',
                        data_name: 'in_stock_quantity'
                    },
                    {
                        name: 'Used',
                        data_name: 'quantity_used'
                    },
                    {
                        name: 'Date',
                        data_name: 'created_at'
                    }
                ]
            }
        }
    }
</script>