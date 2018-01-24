<template>
	<layout>
        <div class="row">
            <time-date></time-date>
        </div>

        <!--action button-->
        <action-button></action-button>
	</layout>
</template>

<script>
    import Layout from '../layouts/main/Layout';
    import ActionButton from '../components/ActionButton';
    import TimeDate from '../components/TimeDate';

    export default {
        components: {ActionButton, Layout, TimeDate},
    }
</script>