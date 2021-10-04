<template>
    <div class="row">
        <div v-for="(image, index) in images" class="mb-3 col-md-3">
            <div class="img-thumbnail">
                <button @click="willDelete(`/images/${image.id}`, () => $emit('deleted', index))" type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <img :src="`/uploads/${image.path}`" class="img-fluid">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'images'
        ]
    }
</script>