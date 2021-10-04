<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-laptop"></i> Promotional Designation</h1>
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
                                <th>Stage</th>
                                <th>Required Designation Number</th>
                                <th>Required Designation</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(designation, index) in showDesignations">
                                    <td>{{ designation.name }}</td>
                                    <td>{{ designation.stage }}</td>
                                    <td>{{ designation.required_designation_number }}</td>
                                    <td>{{ designation.required_designation_name }}</td>
                                    <td>
                                        <button @click="openEditModal(designation)" class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button @click="willDelete(designation.routes.destroy, () => designations.splice(index, 1))" class="btn btn-danger btn-xs">
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

        <Modal modal-class="create-modal" title="Create Promotional Designation">
            <form @submit.prevent="create">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control"
                           name="name" id="name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="stage">Stage</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('stage')}" class="form-control"
                           name="stage" id="stage" placeholder="Enter stage here">
                    <ErrorMessage :errors="errors" error-key="stage"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="required_designation">Required Designation Number</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('required_designation')}" class="form-control"
                           name="required_designation" id="required_designation" placeholder="Enter required designation number here">
                    <ErrorMessage :errors="errors" error-key="required_designation"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="required_designation_id">Required Designation</label>
                    <select :class="{'is-invalid': errors.hasOwnProperty('required_designation_id')}" name="required_designation_id" id="required_designation_id" class="form-control">
                        <option v-for="designation in designations" :value="designation.id">{{ designation.name }}</option>
                    </select>
                    <ErrorMessage :errors="errors" error-key="required_designation_id"></ErrorMessage>
                </div>
                <button class="btn btn-primary">Create</button>
            </form>
        </Modal>

        <Modal modal-class="update-modal" title="Update Promotional Designation">
            <form @submit.prevent="update" :action="designation.routes.update" v-if="!isEmpty(designation)">
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="edit-name">Name</label>
                    <input type="text" v-model="designation.name" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control"
                           name="name" id="edit-name" placeholder="Enter name here">
                    <ErrorMessage :errors="errors" error-key="name"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="edit-stage">Stage</label>
                    <input type="text" v-model="designation.stage" :class="{'is-invalid': errors.hasOwnProperty('stage')}" class="form-control"
                           name="stage" id="edit-stage" placeholder="Enter stage here">
                    <ErrorMessage :errors="errors" error-key="stage"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="edit-required_designation">Required Designation Number</label>
                    <input type="text" v-model="designation.required_designation_number" :class="{'is-invalid': errors.hasOwnProperty('required_designation')}" class="form-control"
                           name="required_designation" id="edit-required_designation" placeholder="Enter required designation number here">
                    <ErrorMessage :errors="errors" error-key="required_designation"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="edit-required_designation_id">Required Designation</label>
                    <select v-model="designation.required_designation_id" :class="{'is-invalid': errors.hasOwnProperty('required_designation_id')}" name="required_designation_id" id="edit-required_designation_id" class="form-control">
                        <option v-for="designation in designations" :value="designation.id">{{ designation.name }}</option>
                    </select>
                    <ErrorMessage :errors="errors" error-key="required_designation_id"></ErrorMessage>
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
    import Paginator from '../../../components/paginator'
    import PromotionalDesignation from "../../../services/PromotionalDesignation";

    export default {
        data(){
            return {
                errors: {},
                designations: [],
                designation: {}
            }
        },
        computed: {
            showDesignations(){
                return this.designations.filter((d) => d.required_designation_id)
            }
        },
        components: {
            Modal, ErrorMessage, Paginator
        },
        mounted(){
            this.getPromotionalDesignation();

            this.$nextTick(() => {
                $('.create-modal, .update-modal').on('hide.bs.modal', () => {
                    this.errors = {}
                })
            })
        },
        methods: {
            create({ target }){
                PromotionalDesignation.create(target).then(() => {
                    this.getPromotionalDesignation()
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            },
            getPromotionalDesignation(){
                PromotionalDesignation.get().then(({ data }) => {
                    this.designations = data.data
                })
            },
            openEditModal(designation){
                this.designation = designation
                $('.update-modal').modal()
            },
            update({ target }){
                window.axios.post(target.action, new FormData(target)).then(() => {
                    this.getPromotionalDesignation()
                    $('.update-modal').modal('hide')
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            }
        }
    }
</script>