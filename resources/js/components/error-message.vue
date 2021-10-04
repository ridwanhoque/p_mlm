<template>
    <strong :class="errorClass" class="d-block" v-if="errors.hasOwnProperty(errorKey)">{{ errors[errorKey][0] }}</strong>
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
            },
            errorClass: {
                type: String,
                default: 'invalid-feedback'
            }
        }
    }
</script>