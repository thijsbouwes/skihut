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
                        name: 'Gebruikers',
                        data_name: 'total_users'
                    },
                    {
                        name: 'Prijs',
                        data_name: 'price',
                        filter: 'formatNumber'
                    },
                    {
                        name: 'Winst',
                        data_name: 'profit',
                        filter: 'formatNumber'
                    },
                    {
                        name: 'Datum',
                        data_name: 'event_date'
                    }
                ]
            }
        }
    }
</script>