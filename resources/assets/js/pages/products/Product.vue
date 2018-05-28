<template>
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title"><slot></slot></span>

                    <form action="POST" @submit.prevent="doSubmit()">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">note</i>
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control" name="name" data-length="255" v-model="product.name" required>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">euro_symbol</i>
                                <label for="price">Price</label>
                                <input id="price" type="number" step="0.01" min="0" class="form-control" name="price" v-model="product.price" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <router-link to="/events" class="waves-effect waves-green btn-flat">Cancel</router-link>
                            <button class="btn waves-effect waves-light" type="submit" name="action">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            product: {
                type: Object,
                required: true
            }
        },

        mounted() {
            this.$M.updateTextFields();
        },

        methods: {
            doSubmit() {
                this.$emit('submit', this.product);
            }
        }
    }
</script>
w