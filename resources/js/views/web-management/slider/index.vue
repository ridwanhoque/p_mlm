<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-laptop"></i> Slides</h1>
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
                    <div class="tile-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Button Text</th>
                                    <th>Button Link</th>
                                    <th>Image</th>
                                    <th>Type</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(slide, index) in slides">
                                    <td>{{ slide.title }}</td>
                                    <td>{{ slide.description }}</td>
                                    <td>{{ slide.button_text }}</td>
                                    <td>{{ slide.link }}</td>
                                    <td>
                                        <img class="img-thumbnail" width="200px" :src="slide.image" alt="">
                                    </td>
                                    <td>{{ slide.type }}</td>
                                    <td>
                                        <button @click="openUpdateModal(slide)" class="btn btn-primary btn-xs">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button @click="willDelete(slide.routes.destroy, () => slides.splice(index, 1))" class="btn btn-danger btn-xs">
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
                    <label for="title">Title</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('title')}" class="form-control" name="title" id="title" placeholder="Enter title here">
                    <ErrorMessage :errors="errors" error-key="title"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea rows="4" :class="{'is-invalid': errors.hasOwnProperty('description')}" class="form-control" name="description" id="description" placeholder="Enter description here"></textarea>
                    <ErrorMessage :errors="errors" error-key="description"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="button_text">Button Text</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('button_text')}" class="form-control" name="button_text" id="button_text" placeholder="Enter button text here">
                    <ErrorMessage :errors="errors" error-key="button_text"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="link">Button Link</label>
                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty('link')}" value="#" class="form-control" name="link" id="link" placeholder="Enter button link here">
                    <ErrorMessage :errors="errors" error-key="link"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" :class="{'is-invalid': errors.hasOwnProperty('image')}" class="form-control" name="image" id="image">
                    <ErrorMessage :errors="errors" error-key="image"></ErrorMessage>
                    <p class="text-muted">Image Size (1920x820)px</p>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Create</button>
                </div>
            </form>
        </Modal>
        <Modal modal-class="update-modal" title="Update Slide">
            <form @submit.prevent="update" :action="slide.routes.update" v-if="!isEmpty(slide)">
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="edit-title">Title</label>
                    <input :value="slide.title" type="text" :class="{'is-invalid': errors.hasOwnProperty('title')}" class="form-control" name="title" id="edit-title" placeholder="Enter title here">
                    <ErrorMessage :errors="errors" error-key="title"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="edit-description">Description</label>
                    <textarea rows="4" :class="{'is-invalid': errors.hasOwnProperty('description')}" class="form-control" name="description" id="edit-description" placeholder="Enter description here">{{ slide.description }}</textarea>
                    <ErrorMessage :errors="errors" error-key="description"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="edit-button_text">Button Text</label>
                    <input type="text" :value="slide.button_text" :class="{'is-invalid': errors.hasOwnProperty('button_text')}" class="form-control" name="button_text" id="edit-button_text" placeholder="Enter button text here">
                    <ErrorMessage :errors="errors" error-key="button_text"></ErrorMessage>
                </div>
                <div class="form-group">
                    <label for="edit-link">Button Link</label>
                    <input type="text" :value="slide.link" :class="{'is-invalid': errors.hasOwnProperty('link')}" value="#" class="form-control" name="link" id="edit-link" placeholder="Enter link here">
                    <ErrorMessage :errors="errors" error-key="link"></ErrorMessage>
                </div>
                <div class="form-group">
                    <img :src="slide.image" class="img-thumbnail" alt="">
                    <label for="image">Image</label>
                    <input type="file" :class="{'is-invalid': errors.hasOwnProperty('image')}" class="form-control" name="image" id="image">
                    <ErrorMessage :errors="errors" error-key="image"></ErrorMessage>
                    <p class="text-muted">Image Size (1920x820)px</p>
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

    export default {
        data(){
            return {
                errors: {},
                slides: [],
                slide: {}
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
            create(e){
                window.axios.post('/slides', new FormData(e.target)).then(() => {
                    $('.create-modal').modal('hide')
                    this.getSlides()
                }).catch(({ response }) => {
                    this.errors = response.data.errors
                })
            },
            getSlides(){
                window.axios.get(`/slides`).then(({ data }) => {
                    this.slides = data.data
                })
            },
            openUpdateModal(slide){
                this.slide = slide
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