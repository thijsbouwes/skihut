<template>
    <div>
        <ul id="slide-out" class="sidenav sidenav-fixed">
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="/images/backgrounds/background-profile.jpg" title="Example" width="100%">
                    </div>

                    <span class="white-text name">{{ user.name }}</span>
                    <span class="white-text email">{{ user.email }}</span>
                </div>
            </li>

            <!--Page links-->
            <template v-if="user.is_admin">
                <router-link tag="li" to="/dashboard" exact><a><i class="material-icons">dashboard</i>Dashboard</a></router-link>
                <router-link tag="li" to="/events"><a><i class="material-icons">event</i>Events</a></router-link>
                <router-link tag="li" to="/products"><a><i class="material-icons">shopping_cart</i>Products</a></router-link>
                <router-link tag="li" to="/stocks"><a><i class="material-icons">store</i>Stocks</a></router-link>
                <router-link tag="li" to="/users"><a><i class="material-icons">supervisor_account</i>Users</a></router-link>
            </template>
            <template v-else>
                <router-link tag="li" to="/" exact><a><i class="material-icons">dashboard</i>Dashboard</a></router-link>
            </template>

            <li><div class="divider"></div></li>

            <!--Logout-->
            <li>
                <a class="waves-effect" href="#" @click="logout"><i class="material-icons">exit_to_app</i>Logout</a>
            </li>
        </ul>
    </div>
    </template>

<script>
import Auth from '../../service/auth-service';
import { mapGetters } from 'vuex';

export default {
    computed: {
        ...mapGetters({
            user: 'profile/user',
        })
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