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
                        name: 'Hoeveelheid',
                        data_name: 'total_quantity'
                    },
                    {
                        name: 'Prijs',
                        data_name: 'total_products_price',
                        filter: 'formatNumber'
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