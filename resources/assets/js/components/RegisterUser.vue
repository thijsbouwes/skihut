<template>
    <div class="card">
        <div class="card-content">
            <span class="card-title">Users</span>
                <form role="form" method="POST" @submit.prevent="doSubmit()">
                    <div class="input-field">
                        <i class="material-icons prefix">face</i>
                        <label for="name">Name</label>
                        <input id="name" v-model="name" type="text" class="validate" name="name" length="255" maxlength="255" required>
                    </div>

                    <div class="input-field">
                        <i class="material-icons prefix">mail_outline</i>
                        <label for="email">Email</label>
                        <input id="email" v-model="email" type="email" class="validate" name="email" length="255" maxlength="255" required>
                    </div>

                    <div class="input-field">
                        <i class="material-icons prefix">lock_outline</i>
                        <label for="password">Password</label>
                        <input id="password" v-model="password" type="password" class="validate" name="password" length="255" maxlength="255" minlength="8" required>
                    </div>

                    <div class="input-field">
                        <i class="material-icons prefix">lock_outline</i>
                        <label for="password_confirmation">Password confirmation</label>
                        <input id="password_confirmation" v-model="password_confirmation" type="password" class="validate" name="password_confirmation" length="255" maxlength="255" minlength="8" required>
                    </div>

                    <div class="input-field center-align">
                        <button class="btn waves-effect waves-light modal-action modal-close" type="submit" name="action">Register</button>
                    </div>
                </form>
            </div>
        </div>
</template>

<script>
    import Auth from '../service/auth-service';
    import ValidationError from '../mixins/validationError';

    export default {
        mixins: [ValidationError],

        data() {
            return {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }
        },

        methods: {
            doSubmit() {
                Auth.register(this.name, this.email, this.password, this.password_confirmation)
                    .then(response => {
                        this.$M.toast({ html: "Created: " + this.name, classes: "green" });
                        this.name = '';
                        this.email = '';
                        this.password = '';
                        this.password_confirmation = '';
                    })
                    .catch(error => {
                        // Show error
                        this.showErrors(error);
                    });
            }
        }
    }
</script>