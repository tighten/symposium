<template>
    <div class="loader ease-linear rounded-full border-2 border-t-2"></div>
</template>

<script>
    export default {
        name: 'LoadingSpinner',
    }
</script>

<style scoped>
    .loader {
        border-top-color: var(--primary);
        -webkit-animation: spinner 1.5s linear infinite;
        animation: spinner 1.5s linear infinite;
    }

    @-webkit-keyframes spinner {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spinner {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
