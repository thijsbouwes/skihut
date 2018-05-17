<template>
    <main class="main_content">
        <navigation></navigation>
        <sidebar></sidebar>
        <router-view></router-view>
        <slot></slot>
    </main>
</template>

<script>
    import Navigation from './Navigation';
    import Sidebar from './Sidebar';

    export default {
        components: { Navigation, Sidebar }
    }
</script>