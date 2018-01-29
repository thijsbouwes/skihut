<template>
    <div>
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large">
                <i class="large material-icons">menu</i>
            </a>
            <ul>
                <li><a @click="getRemoteHouse" class="btn-floating green modal-trigger" href="#remote"><i class="material-icons">settings_remote</i></a></li>
                <li><router-link class="btn-floating red" to="/news" exact><i class="material-icons">import_contacts</i></router-link></li>
                <li><a @click="toggleEdit" class="btn-floating yellow" href="#"><i class="material-icons">edit</i></a></li>
            </ul>
        </div>

        <!--<modal target_id="remote"></modal>-->
    </div>
</template>

<script>
    import { mapActions } from 'vuex';
    import { mapMutations } from 'vuex';
    import { mapGetters } from 'vuex';
    import Modal from '../components/Modal';

    export default {
        components: { Modal },

        mounted() {
            let elem = document.querySelector('.fixed-action-btn');
            let options = { direction: 'top', hoverEnabled: true, toolbarEnabled: false };
            let instance = new this.$M.FloatingActionButton(elem, options);
        },

        methods: {
            ...mapMutations({
                toggleEdit: 'widgets/TOGGLE_EDIT'
            }),

            ...mapActions('remoteHouse', [
                'getRemoteHouse'
            ])
        }
    }
</script>