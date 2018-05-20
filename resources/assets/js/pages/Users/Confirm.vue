<template>
    <external-layout>
        <div class="banner full-height center-panel" :style="randomBackground">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Welcome {{ user.name }}</span>

                    <form role="form" method="POST" @submit.prevent="doSubmit()">
                        <div class="input-field">
                            <i class="material-icons prefix">lock_outline</i>
                            <label for="password">Password</label>
                            <input id="password" v-model="user.password" type="password" class="validate" name="password" length="255" maxlength="255" minlength="8" required>
                        </div>

                        <div class="input-field">
                            <i class="material-icons prefix">lock_outline</i>
                            <label for="password_confirmation">Password confirmation</label>
                            <input id="password_confirmation" v-model="user.password_confirmation" type="password" class="validate" name="password_confirmation" length="255" maxlength="255" minlength="8" required>
                        </div>

                        <div class="input-field center-align">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Update</button>
                        </div>

                        <div class="center-align hide-on-large-only">
                            <router-link tag="span" to="/login" exact><a>Login</a></router-link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </external-layout>
</template>

<script>
    import ExternalLayout from '../../layouts/external/Layout';
    import RandomBackground from '../../mixins/randomBackground';
    import { ENDPOINTS } from '../../config/api';
    import Auth from '../../service/auth-service';

    export default {
        components: { ExternalLayout },
        mixins: [RandomBackground],

        data() {
            return {
                user: {
                    email: 'info@computer4life.nl',
                    name: 'Thijs',
                    password: '',
                    password_confirmation: ''
                }
            }
        },

        created() {
            this.user.token = this.$route.params.token;
        },

        methods: {
            doSubmit() {
                this.$http.post(ENDPOINTS.PASSWORD_RESET, this.user)
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        // Redirect
                        this.$router.push('/');
                        this.$M.toast({ html: "Invalid token", classes: "red" });
                    })
            }
        }
    }
</script>