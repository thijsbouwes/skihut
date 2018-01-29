<template>
    <div>
        <ul id="slide-out" class="sidenav">
            <li>
                <div class="user-view">
                    <div class="background">
                        <!--<img v-if="user_background.url" :src="user_background.url" :title="user_background.name" width="100%">-->
                    </div>

                    <!--<a href="#!user"><img class="circle" v-if="user_image" :src="user_image"></a>-->
                    <!--<a href="#!name"><span class="white-text name" v-text="user_name"></span></a>-->
                    <!--<a href="#!email"><span class="white-text email" v-text="user_email"></span></a>-->
                </div>
            </li>

            <!--Page links-->
            <router-link tag="li" to="/" exact><a class="sidenav-close"><i class="material-icons">dashboard</i>Dashboard</a></router-link>
            <router-link tag="li" to="/news" exact><a class="sidenav-close"><i class="material-icons">import_contacts</i>News</a></router-link>

            <!--<router-link v-if="user.is_admin" tag="li" to="/users" exact><a class="sidenav-close"><i class="material-icons">supervisor_account</i>Users</a></router-link>-->

            <li><div class="divider"></div></li>

            <!--Logout-->
            <li>
                <a class="waves-effect" href="#" @click="logout"><i class="material-icons">exit_to_app</i>Logout</a>
            </li>
        </ul>
    </div>
    </template>

<script>
    import { mapGetters } from 'vuex';
    import { mapActions } from 'vuex';
    import { mapMutations } from 'vuex';
    import { mapState } from 'vuex';
    import * as types from '../../store/mutation-types';
    import Auth from '../../service/auth-service';
    import { ENDPOINTS } from "../../config/api";
    import moment from 'moment';

export default {
    computed: {
        // user_name() {
        //     return this.user.name;
        // },
        //
        // user_email() {
        //     return this.user.email;
        // },
        //
        // ...mapState({
        //     changed: state => state.profile.changed
        // }),
        //
        // ...mapGetters({
        //     user: 'profile/user'
        // })
    },

    created() {
        // this.$store.dispatch('profile/loadProfile')
        //     .then(() => {
        //         // Update text fields
        //         M.updateTextFields();
        //     });
    },

    mounted() {
        // Create sidenav
        let elem = document.querySelector('.sidenav');
        this.sidebar = new M.Sidenav(elem);
    },

    methods: {
        logout() {
            this.sidebar.close();
            Auth.logout();
            this.$router.push('/login');
        }
    },
}
</script>