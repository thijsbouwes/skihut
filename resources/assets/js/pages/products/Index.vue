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
                        name: 'Naam',
                        data_name: 'name'
                    },
                    {
                        name: 'Prijs',
                        data_name: 'price',
                        filter: 'formatNumber'
                    },
                    {
                        name: 'Datum',
                        data_name: 'created_at'
                    }
                ]
            }
        }
    }
</script>