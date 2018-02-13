<template>
    <div class="card-content">
        <span class="card-title">Events
            <router-link :to="{ name: 'events.create' }" class="waves-effect waves-light btn right">
                <i class="material-icons right">add</i>create
            </router-link>
        </span>
        <data-table
            endpoint="events"
            :columns="columns"
        ></data-table>
    </div>
</template>

<script>
    import { ENDPOINTS } from '../../config/api';
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