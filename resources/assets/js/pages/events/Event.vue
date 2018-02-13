<template>
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
                <input id="price" type="number" step="0.01" min="0" class="form-control" name="price" v-model="event.price" required>
            </div>

            <div class="input-field col s12 m3 l4">
                <i class="material-icons prefix">event</i>
                <input type="text" class="datepicker" v-model="event.created_at" required>
            </div>
        </div>

        <div class="row">
            <span class="card-title">Users</span>
            <div class="input-field col s12 m6 l6">
                <i class="material-icons prefix">people</i>
                <label for="price">Number of users</label>
                <input id="number_of_users" type="number" step="1" min="1" class="form-control" name="number_of_users" v-model.number="number_of_users" required>
            </div>

            <div class="col s12 m6 l6" v-for="(number, index) in number_of_users" :id="index">
                <div class="row">
                    <div class="input-field col s8 m8 l10">
                        <!--<select v-model="event.users[index]" required>-->
                            <!--<option value="" disabled selected>Choose your option</option>-->
                            <!--<option v-for="user in users" :value="user.name">{{ user.name }}</option>-->
                        <!--</select>-->
                        <label>User {{ number }}</label>
                    </div>

                    <div class="input-field col s4 m4 l2">
                        <p>
                            <label>
                                <!--<input type="checkbox" class="filled-in" v-model="event.users[index]"/>-->
                                <span>Payed</span>
                            </label>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <span class="card-title">Products</span>
            <div class="input-field col s12 m6 l6">
                <i class="material-icons prefix">shopping_cart</i>
                <label for="price">Number of products</label>
                <input id="number_of_products" type="number" step="1" min="1" class="form-control" name="number_of_products" v-model.number="number_of_products" required>
            </div>

            <div class="col s12 m6 l6" v-for="(number, index) in number_of_products" :id="index">
                <div class="row">
                    <div class="input-field col s6 m4 l6">
                        <select v-model="event.products[index]" required>
                            <option value="" disabled selected>Choose your option</option>
                            <option v-for="product in products" :value="product.id">{{ product.name }} ({{product.price}})</option>
                        </select>
                        <label>Product {{ number }}</label>
                    </div>

                    <div class="input-field col s4 m4 l3">
                        <label for="price">Quantity</label>
                        <input id="quantity" type="number" step="1" min="1" class="form-control" name="quantity" required>
                    </div>

                    <div class="input-field col s2 m4 l3">
                        <label>&euro; 100,-</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <router-link to="/events" class="waves-effect waves-green btn-flat">Cancel</router-link>
            <button class="btn waves-effect waves-light" type="submit" name="action">Save</button>
        </div>
    </form>
</template>

<script>
    import { ENDPOINTS } from '../../config/api';
    import ValidationErrors from '../../mixins/validationError';

    export default {
        mixins: [ValidationErrors],

        props: {
            event: {
                type: Object,
                default: {
                    name: "Skihut",
                    date: "",
                    price: 10,
                    users: [],
                    products: [],
                }
            }
        },

        data() {
            return {
                number_of_users: 2,
                number_of_products: 0,
                products: [
                    {
                        name: "Heineken",
                        price: 10,
                        selected: false,
                    },
                ],
                users: [
                    {
                        name: "Thijs Bouwes",
                        selected: false,
                    },
                    {
                        name: "Bram Bouwes",
                        selected: false,
                    },
                    {
                        name: "Jelle Bouwes",
                        selected: false,
                    },
                    {
                        name: "Koen Bouwes",
                        selected: false,
                    }
                ]
            }
        },

        watch: {
            number_of_products: function(newNumber, oldNumber) {
                this.updateSelect();
            },

            number_of_users: function(newNumber, oldNumber) {
                this.updateSelect();
            }
        },

        mounted() {
            let date_elem = document.querySelector('.datepicker');
            let date_option = {
                format: 'mmm dd, yyyy',
                setDefaultDate: true
            };
            let date_instance = this.$M.Datepicker.init(date_elem, date_option);

            let selec_elem = document.querySelectorAll('select');
            let selec_instance = this.$M.Select.init(selec_elem);

            this.$M.updateTextFields();
        },

        methods: {
            updateSelect() {
                // make sure selects are rendered
                this.$nextTick(function () {
                    // update selects
                    let selec_elem = document.querySelectorAll('select');
                    let selec_instance = this.$M.Select.init(selec_elem);
                });
            },

            doSubmit() {
                this.$http.post(ENDPOINTS.EVENTS, this.event)
                    .then(response => {
                        this.$router.push('/events');
                        this.$M.toast({ html: `Event ${this.event.name} created`, classes: 'green' });
                    })
                    .catch(error => {
                        this.showErrors(error);
                    })
            }
        }
    }
</script>
