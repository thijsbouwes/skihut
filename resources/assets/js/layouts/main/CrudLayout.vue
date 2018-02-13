<template>
    <layout>
        <div class="card data">
            <router-view/>
        </div>
    </layout>
</template>

<script>
    import Layout from '../../layouts/main/Layout';

    export default {
        components: {
            Layout
        }
    }
</script>