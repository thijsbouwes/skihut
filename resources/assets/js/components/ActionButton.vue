<template>
    <div>
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large">
                <i class="large material-icons">menu</i>
            </a>
            <ul>
                <li><a class="btn-floating green modal-trigger" href="#account"><i class="material-icons">account</i></a></li>
                <li><router-link class="btn-floating red" to="/news" exact><i class="material-icons">import_contacts</i></router-link></li>
                <li><a @click="toggleEdit" class="btn-floating yellow" href="#"><i class="material-icons">edit</i></a></li>
            </ul>
        </div>

        <modal target_id="account"><register-user></register-user></modal>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';
    import { mapMutations } from 'vuex';
    import { mapGetters } from 'vuex';
    import Modal from '../components/Modal';
    import RegisterUser from '../components/RegisterUser';

    export default {
        components: { Modal, RegisterUser},

        mounted() {
            let elem = document.querySelector('.fixed-action-btn');
            let options = { direction: 'top', hoverEnabled: true, toolbarEnabled: false };
            let instance = new this.$M.FloatingActionButton(elem, options);
        }
    }
</script>