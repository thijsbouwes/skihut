<template>
    <section>
        <product :product="product" @submit="updateProduct">Update {{ product.name }}</product>
    </section>
</template>

<script>
    import Product from './Product';
    import { ENDPOINTS } from "../../config/api";
    import ValidationErrors from '../../mixins/validationError';

    export default {
        mixins: [ValidationErrors],

        components: {
            Product
        },

        data() {
            return {
                product: {
                    name: "Heineken",
                    price: 10
                }
            }
        },

        created() {
            this.$http.get(ENDPOINTS.PRODUCTS + '/' + this.$route.params.id)
                .then(response => {
                    this.product = response.data;
                })
                .catch(error => {
                    this.showErrors(error);
                });
        },

        methods: {
            updateProduct(product) {
                this.$http.patch(ENDPOINTS.PRODUCTS + '/' + product.id, product)
                    .then(response => {
                        this.$router.push('/products');
                        this.$M.toast({ html: `Product ${this.product.name} updated`, classes: 'green' });
                    })
                    .catch(error => {
                        this.showErrors(error);
                    })
            }
        }
    }
</script>