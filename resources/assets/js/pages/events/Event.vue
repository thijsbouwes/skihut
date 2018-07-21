<template>
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title"><slot></slot></span>

                    <form action="POST" @submit.prevent="doSubmit()">
                        <div class="row">
                            <div class="input-field col s12 m6 l4">
                                <i class="material-icons prefix">note</i>
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control" name="name" data-length="255" v-model="event.name" required>
                            </div>

                            <div class="input-field col s12 m3 l4">
                                <i class="material-icons prefix">euro_symbol</i>
                                <label for="price">Price</label>
                                <input id="price" type="number" step="0.01" min="0.01" max="99999999.99" class="form-control" name="price" v-model="event.price" required>
                            </div>

                            <div class="input-field col s12 m3 l4">
                                <i class="material-icons prefix">event</i>
                                <input type="text" class="datepicker" required @change="updateDate()">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12">
                                <i class="material-icons prefix">people</i>
                                <label>Number of users {{ number_of_users }}</label>
                            </div>

                            <div class="col s12 m6 l6" v-for="(number, index) in number_of_users" :key="index">
                                <div class="row">
                                    <div class="input-field col s8 m8 l10">
                                        <select v-model="user_ids[index]" required @change="setUser(index)">
                                            <option value="" disabled>Choose your option</option>
                                            <option v-for="user in users"
                                                    :value="user.id"
                                                    :disabled="user.selected && user_ids[index] !== user.id"
                                                    :key="user.id"
                                            >{{ user.name }}</option>
                                        </select>
                                        <label>User {{ number }}</label>
                                    </div>

                                    <div class="input-field col s4 m4 l2" v-if="event.users[index]">
                                        <p>
                                            <label>
                                                <input type="checkbox" class="filled-in" v-model="event.users[index].pivot.payed"/>
                                                <span>Payed</span>
                                            </label>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col s12 right-align">
                                <a class="waves-effect waves-light btn" @click=number_of_users-->-</a>
                                <a class="waves-effect waves-light btn" @click=number_of_users++>+</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12">
                                <i class="material-icons prefix">shopping_cart</i>
                                <label>Number of products {{ number_of_products }}</label>
                            </div>

                            <div class="col s12 m6 l6" v-for="(number, index) in number_of_products" :id="index">
                                <div class="row">
                                    <div class="input-field col s6 m4 l6">
                                        <select v-model="product_ids[index]" required @change="setProduct(index)">
                                            <option value="" disabled>Choose your option</option>
                                            <option v-for="product in products"
                                                    :value="product.id"
                                                    :disabled="product.selected && product_ids[index] !== product.id"
                                                    :key="product.id"
                                            > {{ product.name }} ({{product.price}}) </option>
                                        </select>
                                        <label>Product {{ number }}</label>
                                    </div>

                                    <template v-if="event.products[index]">
                                        <div class="input-field col s4 m4 l3">
                                            <label for="quantity">Quantity</label>
                                            <input v-model.number="event.products[index].quantity" id="quantity" step="1" min="1" max="4294967295" type="number" class="form-control" name="quantity" required>
                                        </div>

                                        <div class="input-field col s2 m4 l3">
                                            <label>{{ event.products[index].price * event.products[index].quantity | formatNumber }}</label>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="col s12 right-align">
                                <a class="waves-effect waves-light btn" @click=number_of_products-->-</a>
                                <a class="waves-effect waves-light btn" @click=number_of_products++>+</a>
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
    import { ENDPOINTS } from '../../config/api';

    export default {
        props: {
            event: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                date_instance: {},
                number_of_users: 0,
                number_of_products: 0,
                products: [],
                users: [],
                product_ids: [],
                user_ids: []
            }
        },

        watch: {
            number_of_products: function(newNumber) {
                this.updateSelect();
                this.event.products.splice(-1, this.event.products.length - newNumber);
            },

            number_of_users: function(newNumber) {
                this.updateSelect();
                this.event.users.splice(-1, this.event.users.length - newNumber);
            },

            event: {
                handler: function(event) {
                    if (event.users.length > 0 && this.number_of_users === 0) {
                        this.user_ids = event.users.map(user => user.id);
                        this.number_of_users = event.users.length;
                    }

                    if (event.products.length > 0 && this.number_of_products === 0) {
                        this.product_ids = event.products.map(product => product.id);
                        this.number_of_products = event.products.length;
                    }

                    if (event.event_date) {
                        this.date_instance.setDate(new Date(event.event_date));
                    }
                },
                deep: true,
                immediate: true
            },


        },

        created() {
            this.$http.get(ENDPOINTS.PRODUCTS + '?all=1')
                .then(response => {
                    this.products = response.data;

                    this.updateSelect();
                });

            this.$http.get(ENDPOINTS.USERS + '?all=1')
                .then(response => {
                    this.users = response.data.map(user => {
                        user.pivot = {
                            payed: false
                        };
                        return user;
                    });

                    this.updateSelect();
                });
        },

        mounted() {
            let date_elem = document.querySelector('.datepicker');
            let date_option = {
                format: 'yyyy-mm-dd',
                defaultDate: new Date(),
                setDefaultDate: true,
                autoClose: true
            };
            this.date_instance = this.$M.Datepicker.init(date_elem, date_option);

            let selec_elem = document.querySelectorAll('select');
            let selec_instance = this.$M.FormSelect.init(selec_elem);
        },

        methods: {
            updateSelect() {
                // make sure selects are rendered
                this.$nextTick(function () {
                    // update selects
                    let selec_elem = document.querySelectorAll('select');
                    let selec_instance = this.$M.FormSelect.init(selec_elem);

                    // update fields
                    this.$M.updateTextFields();
                });
            },

            updateDate() {
                this.event.event_date = this.$moment(this.date_instance.date).format('YYYY-MM-DD');
            },

            doSubmit() {
                this.$emit('submit', this.event);
            },

            setProduct(index_select_id) {
                // find old product
                if (this.event.products[index_select_id]) {
                    this.event.products[index_select_id].selected = false;
                }

                // update new product
                let product_id = this.product_ids[index_select_id];
                this.$set(this.event.products, index_select_id, this.products.find(product => product.id === product_id));
                this.event.products[index_select_id].selected = true;

                this.updateSelect();
            },

            setUser(index_select_id) {
                // find old user
                if (this.event.users[index_select_id]) {
                    this.event.users[index_select_id].selected = false;
                }

                // update new user
                let user_id = this.user_ids[index_select_id];
                this.$set(this.event.users, index_select_id, this.users.find(user => user.id === user_id));
                this.event.users[index_select_id].selected = true;

                this.updateSelect();
            }
        }
    }
</script>
