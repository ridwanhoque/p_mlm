<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-laptop"></i> Commission Hand</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <button data-toggle="modal" data-target=".create-modal" class="btn btn-primary">Create</button>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <app-loader/>
                    <div class="tile-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Label</th>
                                <th>Hand Level</th>
                                <th>Commission</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(commissionHand, index) in commissionHandData.data">
                                    <td>{{ commissionHand.label }}</td>
                                    <td>{{ commissionHand.hand_level }}</td>
                                    <td>{{ commissionHand.commission }}</td>
                                    <td>
                                        <button @click="openEditModal(commissionHand)" class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button @click="willDelete(commissionHand.routes.destroy, () => commissionHandData.data.splice(index, 1))" class="btn btn-danger btn-xs">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot v-if="commissionHandData.data.length">
                                <tr>
                                    <td class="text-right">Total</td>
                                    <td>{{ totalHand }}</td>
                                    <td>{{ totalCommission }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <Modal modal-class="create-modal" title="Create Commission Hand">
            <form @submit.prevent="create">
                <div class="form-group">
                    <label for="label">Label</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('label')}" class="form-control" name="label" id="label" placeholder="Enter label here">
                    <ErrorMessage :errors="errors" error-key="label"></ErrorMessage>
                </div>

                <div class="form-group">
                    <label for="hand_level">Hand Level</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('hand_level')}" class="form-control" name="hand_level" id="hand_level" placeholder="Enter hand level here">
                    <ErrorMessage :errors="errors" error-key="hand_level"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="commission">Commission Percentage</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('commission')}" class="form-control" name="commission" id="commission" placeholder="Enter commission here">
                    <ErrorMessage :errors="errors" error-key="commission"></ErrorMessage>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary">Create</button>
                </div>
            </form>
        </Modal>

        <Modal modal-class="update-modal" title="Update Commission Hand">
            <form @submit.prevent="update" :action="commissionHand.routes.update" v-if="!isEmpty(commissionHand)">
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="edit-label">Label</label>
                    <input type="text" v-model="commissionHand.label" :class="{'is-invalid': errors.hasOwnProperty('label')}" class="form-control" name="label" id="edit-label" placeholder="Enter label here">
                    <ErrorMessage :errors="errors" error-key="label"></ErrorMessage>
                </div>

                <div class="form-group">
                    <label for="edit-hand_level">Hand Level</label>
                    <input type="text" v-model="commissionHand.hand_level" :class="{'is-invalid': errors.hasOwnProperty('hand_level')}" class="form-control" name="hand_level" id="edit-hand_level" placeholder="Enter hand level here">
                    <ErrorMessage :errors="errors" error-key="hand_level"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="edit-commission">Commission Percentage</label>
                    <input type="text" v-model="commissionHand.commission" :class="{'is-invalid': errors.hasOwnProperty('commission')}" class="form-control" name="commission" id="edit-commission" placeholder="Enter commission here">
                    <ErrorMessage :errors="errors" error-key="commission"></ErrorMessage>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </Modal>
    </div>
</template>

<script>
    import Modal from '../../../components/modal'
    import ErrorMessage from '../../../components/error-message'
    import CommissionHand from "../../../services/CommissionHand";

    export default {
        data(){
            return {
                errors: {},
                commissionHandData: {
                    data: []
                },
                commissionHand: {}
            }
        },
        computed: {
            totalCommission(){
                return this.commissionHandData.data.reduce((carry, commission) => {
                    return (carry + commission.commission)
                }, 0)
            },
            totalHand(){
                return this.commissionHandData.data.length
            }
        },
        components: {
            Modal, ErrorMessage
        },
        mounted(){
            this.getCommissionHand()
            this.$nextTick(() => {
                $('.create-modal, .update-modal').on('hide.bs.modal', () => {
                    this.errors = {}
                })
            })
        },
        methods: {
            create({ target }){
                CommissionHand.create(target).then(() => {
                    this.getCommissionHand()
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            },
            getCommissionHand(page = 1){
                CommissionHand.get({ page }).then(({ data }) => {
                    this.commissionHandData = data
                })
            },
            openEditModal(commissionHand){
                this.commissionHand = commissionHand
                $('.update-modal').modal()
            },
            update({ target }){
                window.axios.post(target.action, new FormData(target)).then(() => {
                    this.getCommissionHand()
                    $('.update-modal').modal('hide')
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            }
        }
    }
</script>