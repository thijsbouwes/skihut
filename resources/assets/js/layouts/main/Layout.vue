<template>
    <main class="main_content">
        <navigation></navigation>
        <sidebar></sidebar>
        <section class="content">
            <slot></slot>
        </section>
    </main>
</template>

<script>
    import Navigation from './Navigation';
    import Sidebar from './Sidebar';

    export default {
        components: { Navigation, Sidebar }
    }
</script>