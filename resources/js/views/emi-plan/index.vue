<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-laptop"></i> Emi Planes</h1>
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
                                <th>Installment</th>
                                <th>Interest</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(plan, index) in plans">
                                <td>{{ plan.name }}</td>
                                <td>{{ plan.installment }}</td>
                                <td>{{ plan.interest }}%</td>
                                <td>
                                    <button @click="openUpdateModal(plan)" class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button @click="willDelete(plan.routes.destroy, () => plans.splice(index, 1))" class="btn btn-danger btn-xs">
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

        <Modal modal-class="create-modal" title="Create Slide">
            <form @submit.prevent="create">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="installment">Installment</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('installment')}" class="form-control" name="installment" id="installment" placeholder="Enter installment here">
                    <ErrorMessage :errors="errors" error-key="installment"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="interest">Interest</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('interest')}" class="form-control" name="interest" id="interest" placeholder="Enter interest here">
                    <ErrorMessage :errors="errors" error-key="interest"></ErrorMessage>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Create</button>
                </div>
            </form>
        </Modal>
        <Modal modal-class="update-modal" title="Update Slide">
            <form @submit.prevent="update" :action="plan.routes.update" v-if="!isEmpty(plan)">
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" :value="plan.name" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="installment">Installment</label>
                    <input type="text" :value="plan.installment" :class="{'is-invalid': errors.hasOwnProperty('installment')}" class="form-control" name="installment" id="installment" placeholder="Enter installment here">
                    <ErrorMessage :errors="errors" error-key="installment"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="interest">Interest</label>
                    <input type="text" :value="plan.interest" :class="{'is-invalid': errors.hasOwnProperty('interest')}" class="form-control" name="interest" id="interest" placeholder="Enter interest here">
                    <ErrorMessage :errors="errors" error-key="interest"></ErrorMessage>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </Modal>
    </div>
</template>

<script>
    import Modal from '../../components/modal'
    import ErrorMessage from '../../components/error-message'

    export default {
        data(){
            return {
                errors: {},
                plans: [],
                plan: {}
            }
        },
        components: {
            Modal, ErrorMessage
        },
        mounted(){
            this.getSlides()
            this.$nextTick(() => {
                $('.create-modal, .update-modal').on('bs.modal.hide', () => {
                    this.errors = {}
                })
            })
        },
        methods: {
            create({ target }){
                window.axios.post('/emi-plans', new FormData(target)).then(() => {
                    $('.create-modal').modal('hide')
                    this.getSlides()
                    target.reset()
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            },
            getSlides(){
                window.axios.get(`/emi-plans`).then(({ data }) => {
                    this.plans = data.data
                })
            },
            openUpdateModal(plan){
                this.plan = plan
                $('.update-modal').modal()
            },
            update({ target }){
                axios.post(target.action, new FormData(target)).then(() => {
                    this.getSlides()
                    $('.update-modal').modal('hide')
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            }
        }
    }
</script>