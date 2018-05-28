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
                                <input id="name" type="text" class="form-control" name="name" data-length="255" v-model="stock.name" required>
                            </div>

                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">event</i>
                                <input type="text" class="datepicker" required @change="updateDate()">
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">shopping_cart</i>
                                <label for="number_of_products">Number of products</label>
                                <input id="number_of_products" type="number" step="1" min="1" class="form-control" name="number_of_products" v-model.number="number_of_products" required>
                            </div>

                            <div class="col s12 m6 l6" v-for="(number, index) in number_of_products" :id="index">
                                <div class="row">
                                    <div class="input-field col s6 m4 l6">
                                        <select v-model="product_ids[index]" required @change="setProduct(index)">
                                            <option value="" disabled>Choose your option</option>
                                            <option v-for="product in products"
                                                    :value="product.id"
                                                    :disabled="product.selected && product_ids[index] !== product.id"
                                            > {{ product.name }} ({{product.price}}) </option>
                                        </select>
                                        <label>Product {{ number }}</label>
                                    </div>

                                    <template v-if="stock.products[index]">
                                        <div class="input-field col s4 m4 l3">
                                            <label for="quantity">Quantity</label>
                                            <input v-model.number="stock.products[index].quantity" id="quantity" type="number" step="1" min="1" class="form-control" name="quantity" required>
                                        </div>

                                        <div class="input-field col s2 m4 l3">
                                            <label>{{ stock.products[index].price * stock.products[index].quantity | formatNumber }}</label>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <router-link to="/stocks" class="waves-effect waves-green btn-flat">Cancel</router-link>
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
            stock: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                date_instance: {},
                number_of_products: 0,
                products: [],
                product_ids: [],
            }
        },

        watch: {
            number_of_products: function (newNumber) {
                this.updateSelect();
                this.stock.products.splice(-1, this.stock.products.length - newNumber);
            },

            stock: {
                handler: function(stock) {
                    if (stock.products.length > 0 && this.number_of_products === 0) {
                        this.product_ids = stock.products.map(product => product.id);
                        this.number_of_products = stock.products.length;
                    }
                },
                deep: true,
                immediate: true
            },
        },

        created() {
            this.$http.get(ENDPOINTS.PRODUCTS)
                .then(response => {
                    this.products = response.data.data;

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

            this.$M.updateTextFields();
        },

        methods: {
            doSubmit() {
                this.$emit('submit', this.stock);
            },

            updateDate() {
                this.stock.order_date = this.$moment(this.date_instance.date).format('YYYY-MM-DD');
            },

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

            setProduct(index_select_id) {
                // find old product
                if (this.stock.products[index_select_id]) {
                    this.stock.products[index_select_id].selected = false;
                }

                // update new product
                let product_id = this.product_ids[index_select_id];
                this.$set(this.stock.products, index_select_id, this.products.find(product => product.id === product_id));
                this.stock.products[index_select_id].selected = true;

                this.updateSelect();
            }
        }
    }
</script>