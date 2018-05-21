<template>
    <external-layout>
        <div class="banner full-height center-panel" :style="randomBackground">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Forgot password</span>

                    <form role="form" method="POST" @submit.prevent="doSubmit()">
                        <div class="input-field">
                            <i class="material-icons prefix">mail_outline</i>
                            <label for="email">Email</label>
                            <input id="email" v-model="user.email" type="email" class="form-control" name="email" length="255" maxlength="255" required autofocus>
                        </div>

                        <div class="input-field center-align">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Reset password</button>
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
                    email: ''
                }
            }
        },

        methods: {
            doSubmit() {
                this.$http.post(ENDPOINTS.FORGOT_PASSWORD, this.user)
                    .then(response => {
                        this.$router.push('/login');
                        this.$M.toast({ html: "Check your email", classes: "green" });
                    })
            }
        }
    }
</script>