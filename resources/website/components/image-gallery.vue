<template>
    <ProductZoomer v-if="images.normal_size.length" :base-zoomer-options="$store.getters.galleryConfig" :base-images="images" ></ProductZoomer>
</template>

<script>

    export default {
        props: [
            'itemUrl'
        ],
        data(){
            return {
                images: {
                    normal_size: [],
                }
            }
        },
        mounted() {
            window.axios.get(this.itemUrl, {
                params: {
                    ajax: true
                }
            }).then(({ data }) => {
                this.images.normal_size = data.data.images.map((image) => {
                    return {
                        id: image.id,
                        url: '/uploads/'+image.path
                    }
                });
            })
        }
    }
</script>