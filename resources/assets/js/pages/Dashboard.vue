<template>
    <layout>
        <section>
            <div class="row">
                <div class="col s12 m6 l4 xl3">
                    <time-date></time-date>
                </div>
            </div>
        </section>
    </layout>
</template>

<script>
    import Layout from '../layouts/main/Layout';
    import TimeDate from '../components/TimeDate';

    export default {
        components: {Layout, TimeDate},
    }
</script>