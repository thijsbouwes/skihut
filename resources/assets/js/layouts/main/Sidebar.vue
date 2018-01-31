<template>
    <div>
        <ul id="slide-out" class="sidenav sidenav-fixed">
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="https://images.unsplash.com/photo-1458682625221-3a45f8a844c7" title="Example" width="100%">
                    </div>

                    <router-link to="/" exact><span class="white-text name">Thijs Bouwes</span></router-link>
                    <router-link to="/" exact><span class="white-text email">thijsbouwes@gmail.com</span></router-link>
                </div>
            </li>

            <!--Page links-->
            <router-link tag="li" to="/" exact><a><i class="material-icons">dashboard</i>Dashboard</a></router-link>
            <router-link tag="li" to="/events" exact><a><i class="material-icons">event</i>Events</a></router-link>
            <router-link tag="li" to="/products" exact><a><i class="material-icons">shopping_cart</i>Products</a></router-link>
            <router-link tag="li" to="/users" exact><a><i class="material-icons">supervisor_account</i>Users</a></router-link>


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
import moment from 'moment';

export default {
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