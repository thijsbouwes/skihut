<template>
    <div class="card data-info">
        <div class="card-content">
            <span class="card-title">{{ title }}</span>
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                required: true,
                type: String
            },
        },

        data() {
            return {

            }
        },

        created() {

        },

        methods: {

        }
    }
</script>