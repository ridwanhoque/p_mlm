<template>
    <div class="modal fade" :class="modalClass" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" :class="modalDialogClass">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                default: 'Title',
                type: String
            },
            modalClass: {
                default: '',
                type: String,
                required: true
            },
            modalDialogClass: {
                default: '',
                type: String
            }
        },
    }
</script>