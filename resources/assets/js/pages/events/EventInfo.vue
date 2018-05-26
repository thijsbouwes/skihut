<template>
    <div class="row data-cards">
        <div class="col l3">
            <div class="card-panel">
                <div>Total products: <span>{{ event.products.length }}</span></div>
                <div>Total quantity: <span>{{ total_products }}</span></div>
                <div>Subtotal: <span>{{ total_products_price | formatNumber}}</span></div>
            </div>
        </div>

        <div class="col l3">
            <div class="card-panel">
                <div>Total users: <span>{{ event.users.length }}</span></div>
                <div>Revenue: <span>{{ total_revenue | formatNumber }}</span></div>
                <div>Outstanding: <span>{{ outstanding_money | formatNumber }}</span></div>
            </div>
        </div>

        <div class="col l3">
            <div class="card-panel">
                <div>Costs: <span>{{ total_products_price | formatNumber }}</span></div>
                <div>Revenue: <span>{{ total_revenue | formatNumber }}</span></div>
                <div>Profit: <span>{{ total_revenue - total_products_price | formatNumber }}</span></div>
            </div>
        </div>

        <div class="col l3">
            <div class="card-panel">
                <div>Recommended price: <span>{{ recommended_price | formatNumber }}</span></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            event: {
                type: Object,
                required: true
            }
        },

        computed: {
            total_products() {
                let count = 0;

                this.event.products.map(product => {
                    count += product.quantity;
                });

                return count;
            },

            total_products_price() {
                let price = 0;

                this.event.products.map(product => {
                    price += product.quantity * product.price;
                });

                return price;
            },

            total_revenue() {
                return this.event.price * this.event.users.length;
            },

            outstanding_money() {
                let not_payed = this.event.users.filter(user => user.payed === false);

                return this.event.price * not_payed.length;
            },

            recommended_price() {
                if (this.total_products_price === 0 || this.event.users.length === 0) {
                    return 0;
                }

                return this.total_products_price / this.event.users.length;
            }
        }
    }
</script>