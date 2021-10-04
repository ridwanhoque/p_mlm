<template>
    <div class="dropdown">
        <button :class="`btn-${statusObject.className}`" class="btn btn-xs text-md-center dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ statusObject.text }}
        </button>
        <div class="dropdown-menu">
            <button @click="updateStatus(status)" class="dropdown-item" v-for="status in statuses" type="button">{{ status.text }}</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            status: Number,
            statusClass: {
                type: String,
                default: 'warning text-white'
            },
            url: {
                type: String,
                default: ''
            },
            statuses: {
                type: Array,
                default: function () {
                    return [
                        {
                            text: 'Pending',
                            value: 0,
                            className: 'warning text-white'
                        },{
                            text: 'Processing',
                            value: 1,
                            className: 'info'
                        },{
                            text: 'Delivering',
                            value: 2,
                            className: 'secondary'
                        },{
                            text: 'Delivered',
                            value: 3,
                            className: 'success'
                        },{
                            text: 'Canceled',
                            value: 4,
                            className: 'danger'
                        },
                    ]
                }
            }
        },
        computed: {
            statusObject(){

                return this.statuses[this.status]
            }
        },
        methods: {
            updateStatus(status) {
                window.axios.put(this.url, {
                    status: status.value
                }).then((response) => {
                    this.$emit('updated', response)
                }).catch(({ response }) => {
                    this.$emit('error', response)
                })
            }
        }
    }
</script>