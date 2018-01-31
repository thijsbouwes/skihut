<template>
    <layout>
        <div class="row">

            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Users</span>

                        <table class="striped responsive-table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Admin</th>
                                <th>Email</th>
                                <th>Created</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users">
                                <td v-text="user.name"></td>
                                <td v-html="isAdmin(user)"></td>
                                <td v-text="user.email"></td>
                                <td>{{ user.created_at | formatDate }}</td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="progress" v-show="loading">
                            <div class="indeterminate"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col s12 m6">
                <register-user></register-user>
            </div>
        </div>
    </layout>
</template>

<script>
    import Layout from '../layouts/main/Layout';
    import RegisterUser from '../components/RegisterUser';
    import { ENDPOINTS } from '../config/api';

    export default {
        components: { Layout, RegisterUser },

        data() {
            return {
                loading: true,
                users: []
            }
        }
    }
</script>