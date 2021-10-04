<template>
    <div>
        <Modal :title="source" modal-class="payment-details">
            <ul class="list-group" v-if="!isEmpty(payment)">
                <li class="list-group-item"><b>Card Brand: </b>{{ payment.walletable.card_brand }}</li>
                <li class="list-group-item"><b>Card Issuer: </b>{{ payment.walletable.card_issuer }}</li>
                <li class="list-group-item"><b>Card Issuer Country: </b>{{ payment.walletable.card_issuer_country }}</li>
                <li class="list-group-item"><b>Card Issuer Country Code: </b>{{ payment.walletable.card_issuer_country_code }}</li>
                <li class="list-group-item"><b>Transaction ID: </b>{{ payment.walletable.tran_id }}</li>
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