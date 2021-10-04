<template>
    <p class="text-danger" v-if="errors.hasOwnProperty(errorKey)">{{ errors[errorKey][0] }}</p>
</template>

<script>
    export default {
        props: {
            errors: {
                type: Object,
                default: function () {
                    return {}
                }
            },
            errorKey: {
                type: String,
                default: ''
            }
        }
    }
</script>