<template>
    <layout>
        <div class="card data">
            <div class="card-content">
                <router-view/>
            </div>
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