<template>
    <section>
        <stock :stock="stock" @submit="saveStock">Create stock</stock>
    </section>
</template>

<script>
    import Stock from './Stock';
    import { ENDPOINTS } from '../../config/api';
    import ValidationErrors from '../../mixins/validationError';

    export default {
        mixins: [ValidationErrors],

        components: {
            Stock
        },

        data() {
            return {
                stock: {
                    name: "Ah",
                    order_date: "",
                    products: []
                }
            }
        },

        methods: {
            saveStock(stock) {
                this.$http.post(ENDPOINTS.STOCKS, stock)
                    .then(response => {
                        this.$router.push('/stocks');
                        this.$M.toast({ html: `Stock created`, classes: 'green' });
                    })
                    .catch(error => {
                        this.showErrors(error);
                    })
            }
        }
    }
</script>