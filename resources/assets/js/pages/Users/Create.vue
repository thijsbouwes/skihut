<template>
    <section>
        <div class="card">
            <div class="card-content">
                <span class="card-title">Users</span>
                <form role="form" method="POST" @submit.prevent="saveUser()">
                    <div class="input-field">
                        <i class="material-icons prefix">face</i>
                        <label for="name">Name</label>
                        <input id="name" v-model="user.name" type="text" class="validate" name="name" length="255" maxlength="255" required>
                    </div>

                    <div class="input-field">
                        <i class="material-icons prefix">mail_outline</i>
                        <label for="email">Email</label>
                        <input id="email" v-model="user.email" type="email" class="validate" name="email" length="255" maxlength="255" required>
                    </div>

                    <div class="input-field">
                        <router-link to="/users" class="waves-effect waves-green btn-flat">Cancel</router-link>
                        <button class="btn waves-effect waves-light modal-action modal-close" type="submit" name="action">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
    import ValidationError from '../../mixins/validationError';
    import { ENDPOINTS } from '../../config/api';

    export default {
        mixins: [ValidationError],

        data() {
            return {
                user: {
                    name: '',
                    email: '',
                }
            }
        },

        methods: {
            saveUser() {
                this.$http.post(ENDPOINTS.USERS, this.user)
                    .then(response => {
                        this.$router.push('/users');
                        this.$M.toast({ html: `User ${this.user.name} created`, classes: 'green' });
                    })
                    .catch(error => {
                        this.showErrors(error);
                    })
            }
        }
    }
</script>