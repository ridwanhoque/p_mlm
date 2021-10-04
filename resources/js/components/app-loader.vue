<template>
    <Loader v-if="$store.state.app.isLoading"/>
</template>

<script>
    import Loader from './loader'
    export default {
        components: {
            Loader
        }
    }
</script>