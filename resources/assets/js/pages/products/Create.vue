<template>
    <section>
        <product :product="product" @submit="saveProduct">Create product</product>
    </section>
</template>

<script>
    import Product from './Product';
    import { ENDPOINTS } from '../../config/api';
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

        methods: {
            saveProduct(product) {
                this.$http.post(ENDPOINTS.PRODUCTS, product)
                    .then(response => {
                        this.$router.push('/products');
                        this.$M.toast({ html: `Product ${this.product.name} created`, classes: 'green' });
                    })
                    .catch(error => {
                        this.showErrors(error);
                    })
            }
        }
    }
</script>