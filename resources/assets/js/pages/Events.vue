<template>
    <layout>
        <div class="row">
            <div class="col s12 m6">
                <span class="card-title">Events</span>
                <data-table
                    endpoint="events"
                    :columns="columns"
                ></data-table>

            </div>
        </div>
    </layout>
</template>

<script>
    import Layout from '../layouts/main/Layout';
    import { ENDPOINTS } from '../config/api';
    import DataTable from '../components/DataTable';

    export default {
        components: {
            DataTable,
            Layout
        },

        data() {
            return {
                columns: [
                    'name',
                    'price'
                ]
            }
        }
    }
</script>