<template>
    <external-layout>
        <div class="banner full-height center-panel" :style="randomBackground">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Confirm password</span>

                    <form role="form" method="POST" @submit.prevent="doSubmit()" autocomplete="off">
                        <div class="input-field">
                            <i class="material-icons prefix">mail_outline</i>
                            <label for="email">Email</label>
                            <input id="email" v-model="user.email" type="email" class="validate" name="email" length="255" maxlength="255" required>
                        </div>

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
    import ValidationErrors from '../../mixins/validationError';
    import { ENDPOINTS } from '../../config/api';
    import Auth from '../../service/auth-service';

    export default {
        components: { ExternalLayout },
        mixins: [RandomBackground, ValidationErrors],

        data() {
            return {
                user: {
                    email: '',
                    password: '',
                    password_confirmation: ''
                }
            }
        },

        created() {
            this.user.token = this.$route.params.token;
            this.user.email = this.$route.params.email;
        },

        methods: {
            doSubmit() {
                this.$http.post(ENDPOINTS.PASSWORD_RESET, this.user)
                    .then(response => {
                        Auth.login(this.user.email, this.user.password)
                            .then(data => {
                                // Redirect
                                this.$router.push('/');
                                this.$M.toast({ html: "Welcome  👋🏼", classes: "green" });
                            })
                            .catch(error => {
                                this.$M.toast({ html: "Error: " + error.response.status + ", activation link invalid.", classes: "red" });
                            });
                    })
                    .catch(error => {
                        this.showErrors(error);
                    });
            }
        }
    }
</script>