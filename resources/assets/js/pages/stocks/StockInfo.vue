<template>
    <div class="row data-cards">
        <div class="col s12 m12 l3">
            <div class="card-panel">
                <div>Total products: <span>{{ stock.products.length }}</span></div>
                <div>Total quantity: <span>{{ total_products }}</span></div>
                <div>Subtotal: <span>{{ total_products_price | formatNumber}}</span></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            stock: {
                type: Object,
                required: true
            }
        },

        computed: {
            total_products() {
                let count = 0;

                this.stock.products.map(product => {
                    count += product.quantity;
                });

                return count;
            },

            total_products_price() {
                let price = 0;

                this.stock.products.map(product => {
                    price += product.quantity * product.price;
                });

                return price;
            }
        }
    }
</script>