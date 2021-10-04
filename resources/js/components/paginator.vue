<template>
    <Pagination ref="pagination" :limit="5" @pagination-change-page="fire" :data="data"></Pagination>
</template>

<script>
    import Pagination from 'laravel-vue-pagination'

    export default {
        props: ['data'],
        components: {
            Pagination
        },
        methods: {
            fire(page){
                this.$emit('change-page', page)
            }
        }
    }
</script>