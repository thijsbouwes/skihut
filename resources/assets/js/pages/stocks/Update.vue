<template>
    <section>
        <stock-info :stock="stock"></stock-info>
        <stock :stock="stock" @submit="updateStock">Update {{ stock.name }}</stock>
    </section>
</template>

<script>
    import Stock from './Stock';
    import StockInfo from './StockInfo';
    import { ENDPOINTS } from "../../config/api";

    export default {
        components: {
            Stock,
            StockInfo
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

        created() {
            this.$http.get(ENDPOINTS.STOCKS + '/' + this.$route.params.id)
                .then(response => {
                    this.stock = response.data;
                });
        },

        methods: {
            updateStock(stock) {
                this.$http.patch(ENDPOINTS.STOCKS + '/' + stock.id, stock)
                    .then(response => {
                        this.$router.push('/stocks');
                        this.$M.toast({ html: `Stock updated`, classes: 'green' });
                    })
                    .catch(error => {
                        this.showErrors(error);
                    })
            }
        }
    }
</script>