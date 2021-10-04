<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-laptop"></i> Bonus Commission</h1>
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
                                <th>Name</th>
                                <th>Percentage</th>
                                <th>Payable</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(commission, index) in bonusCommissionData.data">
                                    <td>{{ commission.name }}</td>
                                    <td>{{ commission.percentage }}</td>
                                    <td>{{ commission.payable }}</td>
                                    <td>
                                        <span class="badge" :class="`badge-${commission.status.className}`">{{ commission.status.text }}</span>
                                    </td>
                                    <td>
                                        <button @click="openEditModal(commission)" class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button @click="willDelete(commission.routes.destroy, () => bonusCommissionData.data.splice(index, 1))" class="btn btn-danger btn-xs">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <Modal modal-class="create-modal" title="Create Commission Hand">
            <form @submit.prevent="create">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>

                <div class="form-group">
                    <label for="percentage">Percentage</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('percentage')}" class="form-control" name="percentage" id="percentage" placeholder="Enter percentage here">
                    <ErrorMessage :errors="errors" error-key="percentage"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="payable">Payable</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('payable')}" class="form-control" name="payable" id="payable" placeholder="Enter payable here">
                    <ErrorMessage :errors="errors" error-key="payable"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="is_active">Status</label>
                    <select name="is_active" :class="{'is-invalid': errors.hasOwnProperty('is_active')}" id="is_active" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <ErrorMessage :errors="errors" error-key="is_active"></ErrorMessage>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary">Create</button>
                </div>
            </form>
        </Modal>

        <Modal modal-class="update-modal" title="Update Commission Hand">
            <form @submit.prevent="update" :action="commission.routes.update" v-if="!isEmpty(commission)">
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="edit-name">Name</label>
                    <input type="text" v-model="commission.name" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="edit-name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>

                <div class="form-group">
                    <label for="edit-percentage">Percentage</label>
                    <input type="text" v-model="commission.percentage" :class="{'is-invalid': errors.hasOwnProperty('percentage')}" class="form-control" name="percentage" id="edit-percentage" placeholder="Enter percentage here">
                    <ErrorMessage :errors="errors" error-key="percentage"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="edit-payable">Payable</label>
                    <input type="text" v-model="commission.payable" :class="{'is-invalid': errors.hasOwnProperty('payable')}" class="form-control" name="payable" id="edit-payable" placeholder="Enter payable here">
                    <ErrorMessage :errors="errors" error-key="payable"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="edit-is_active">Status</label>
                    <select name="is_active" v-model="commission.is_active" :class="{'is-invalid': errors.hasOwnProperty('is_active')}" id="edit-is_active" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <ErrorMessage :errors="errors" error-key="is_active"></ErrorMessage>
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
    import BonusCommission from "../../../services/BonusCommission";

    export default {
        data(){
            return {
                errors: {},
                bonusCommissionData: {
                    data: []
                },
                commission: {}
            }
        },
        components: {
            Modal, ErrorMessage
        },
        mounted(){
            this.getBonusCommission()
            this.$nextTick(() => {
                $('.create-modal, .update-modal').on('hide.bs.modal', () => {
                    this.errors = {}
                })
            })
        },
        methods: {
            create({ target }){
                BonusCommission.create(target).then(() => {
                    this.getBonusCommission()
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            },
            getBonusCommission(page = 1){
                BonusCommission.get({ page }).then(({ data }) => {
                    this.bonusCommissionData = data
                })
            },
            openEditModal(commission){
                this.commission = commission
                $('.update-modal').modal()
            },
            update({ target }){
                window.axios.post(target.action, new FormData(target)).then(() => {
                    this.getBonusCommission()
                    $('.update-modal').modal('hide')
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            }
        }
    }
</script>