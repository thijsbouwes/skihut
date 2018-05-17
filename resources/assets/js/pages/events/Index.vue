<template>
    <section>
        <data-table
            endpoint="events"
            :columns="columns"
        ></data-table>
    </section>
</template>

<script>
    import DataTable from '../../components/DataTable';
    import Layout from "../../layouts/main/Layout";

    export default {
        components: {
            Layout,
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
                        data_name: 'price'
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