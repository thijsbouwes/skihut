<template>
    <div class="card-content">
        <span class="card-title">Events
            <router-link :to="{ name: 'create.event', params: { id: 123 } }" class="waves-effect waves-light btn right">
                <i class="material-icons right">add</i>create
            </router-link>
        </span>
        <data-table
            endpoint="events"
            :columns="columns"
            :actions="actions"
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
                ],
                actions: [
                    {
                        name: "Edit",
                        icon: "edit"
                    },
                    {
                        name: "Delete",
                        icon: "delete"
                    }
                ]
            }
        }
    }
</script>