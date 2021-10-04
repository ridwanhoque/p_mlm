<template>
    <input type="text" class="form-control" autocomplete="off" :name="name" :id="id" :value="value" @input="$emit('input', $event.target.value)">
</template>

<script>
    import 'bootstrap-datepicker'

    export default {
        props: {
            value: {
                type: String,
                default: ''
            },
            name: {
                type: String,
                default: ''
            },
            id: {
                type: String,
                default: ''
            },
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
        },
        mounted() {
            this.$nextTick(() => {
                $(this.$el).datepicker({
                    format: 'yyyy-mm-dd',
                    todayHighlight: true,
                    autoclose: true
                }).on('changeDate', (event) => {
                    this.$emit('input', event.target.value)
                })
            })
        },
        model:{
            prop: 'value',
            event: 'input'
        }

    }
</script>