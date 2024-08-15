<template>
    <div class="page">
        <Navigation />
        <router-view></router-view>
    </div>
</template>

<script>
import Navigation from './components/Navigation.vue';

export default {
    components: {
        Navigation,
    },
};
</script>

<style scoped>
body {
    background-color: #eee;
    margin: 0;
    font-family: Arial, sans-serif;
}

.page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}
</style>
