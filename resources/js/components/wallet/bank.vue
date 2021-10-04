<template>
    <div>
        <Modal :title="source" modal-class="payment-details">
            <ul class="list-group" v-if="!isEmpty(payment)">
                <li class="list-group-item"><b>Bank Name: </b>{{ payment.walletable.bank_name }}</li>
                <li class="list-group-item"><b>Transaction ID: </b> {{ payment.walletable.transaction_id }}</li>
            </ul>
        </Modal>
    </div>
</template>

<script>
    import Modal from '../modal'
    export default {
        props: {
            source: String,
            payment: {
                type: Object,
                default: () => ({})
            }
        },
        components: {
            Modal
        },
        mounted() {
            this.$nextTick(() => {
                let modal = $('.payment-details');
                modal.modal();

                modal.on('hidden.bs.modal', () => {
                    this.$emit('modalClose')
                })
            })
        }
    }
</script>