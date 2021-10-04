<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-laptop"></i> Wallet Payments</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <app-loader/>
                    <div class="tile-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Transaction From</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(payment, index) in payments.data">
                                    <td>{{ payment.user.name }}</td>
                                    <td>{{ payment.amount.formatted() }}</td>
                                    <td><Wallet :id="payment.id" :source="payment.transaction_from"></Wallet></td>
                                    <td>{{ payment.created_at }}</td>
                                    <td>
                                        <span class="badge" :class="`badge-${payment.status.class_name}`">{{ payment.status.text }}</span>
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ErrorMessage from '../../../components/error-message'
    import WalletPayment from "../../../services/WalletPayment";
    import Wallet from '../../../components/wallet/wallet'

    export default {
        data(){
            return {
                errors: {},
                payments: {
                    data: []
                },
                payment: {}
            }
        },
        components: {
            ErrorMessage, Wallet
        },
        mounted(){
            this.getPayments()

        },
        methods: {
            create({ target }){
                WalletPayment.create(target).then(() => {
                    this.getPayments()
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            },
            getPayments(page = 1){
                WalletPayment.get({ page }).then(({ data }) => {
                    this.payments = data
                })
            },
            update({ target }){
                window.axios.post(target.action, new FormData(target)).then(() => {
                    this.getPayments()
                    $('.update-modal').modal('hide')
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            }
        }
    }
</script>