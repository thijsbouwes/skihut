<template>
    <section>
        <data-table
            endpoint="users"
            :columns="columns"
            :actions="actions"
        ></data-table>
    </section>
</template>

<script>
    import CreateUser from './Create';
    import DataTable from '../../components/DataTable';

    export default {
        components: {
            CreateUser,
            DataTable
        },

        data() {
            return {
                loading: true,
                actions: {
                    edit: false,
                    create: true
                },
                columns: [
                    {
                        name: 'Naam',
                        data_name: 'name'
                    },
                    {
                        name: 'Email',
                        data_name: 'email'
                    },
                    {
                        name: 'Schulden',
                        data_name: 'debt',
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