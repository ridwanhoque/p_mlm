<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-book"></i> Edit Course</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <router-link :to="{ name: 'courses.index' }" exact class="btn btn-primary">Back</router-link>
                </li>
            </ul>
        </div>
        <div class="tile">
            <form @submit.prevent="update">
                <div class="row" v-if="!isEmpty(course)">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="name">Course Name</label>
                            <input :value="course.name" required type="text" :class="{'is-invalid': errors.hasOwnProperty('name')}" class="form-control" name="name" id="name">
                            <ErrorMessage error-key="name" :errors="errors"/>
                        </div>
                        <div v-for="(module, index) in course.modules">
                            <div class="form-group">
                                <label :for="`duration-${index}`">Module Name {{ (index + 1) }}</label>
                                <input :value="module.name" :class="{'is-invalid': errors.hasOwnProperty(`modules.${index}.name`)}" type="text" :name="`modules[${index}][name]`" :id="`duration-${index}`" class="form-control">
                                <ErrorMessage :error-key="`modules.${index}.name`" :errors="errors"/>
                                <input v-if="module.id" :value="module.id" type="hidden" :name="`modules[${index}][id]`">
                            </div>
                            <div class="text-right">
                                <button type="button" v-if="course.modules.length == (index + 1)" @click="addModule" class="btn btn-xs btn-primary">Add More</button>
                                <button v-if="index" @click="course.modules.splice(index, 1)" type="button" class="btn btn-xs btn-danger">Delete</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="duration">Course Duration</label>
                            <input type="text" :value="course.duration" name="duration" id="duration" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="delivery_center">Delivery Center</label>
                            <input type="text" :value="course.delivery_center" name="delivery_center" id="delivery_center" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="number_of_lecture">Number Of Lecture</label>
                            <input type="text" :value="course.number_of_lecture" name="number_of_lecture" id="number_of_lecture" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="class_per_week">Class Per Week</label>
                            <input type="text" :value="course.class_per_week" name="class_per_week" id="class_per_week" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="price">Course Price</label>
                            <input :class="{'is-invalid': errors.hasOwnProperty('price')}" type="text" v-selected v-model.number="course.price" name="price" id="price" class="form-control">
                            <ErrorMessage error-key="price" :errors="errors"/>
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount %</label>
                            <input type="text" v-selected v-model.number="course.discount_percentage" name="discount_percentage" id="discount" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="discount_amount">Discount Given</label>
                            <input type="text" :value="discountGiven" readonly name="discount_amount" id="discount_amount" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="price_after_discount">Price After Discount</label>
                            <input type="text" :value="priceAfterDiscount" readonly name="price_after_discount" id="price_after_discount" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="discount_start_date">Discount Start Date</label>
                            <Datepicker v-model="course.discount_start_date" name="discount_start_date" id="discount_start_date"/>
                        </div>
                        <div class="form-group">
                            <label for="discount_end_date">Discount End Date</label>
                            <Datepicker v-model="course.discount_end_date" name="discount_end_date" id="discount_end_date"/>
                        </div>

                        <div class="form-group">
                            <label for="commission">Commission</label>
                            <input type="text" v-model.number="course.commission" v-selected id="commission" name="commission" class="form-control" value="0">
                        </div>

                        <EditCategoryTree :default-categories="course.categories"/>

                        <div class="form-group">
                            <label for="comments">Comments</label>
                            <textarea v-model="course.comments" class="form-control" rows="5" name="comments" id="comments"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="cash_back">Cash Back</label>
                            <textarea v-model="course.cash_back" class="form-control" rows="5" name="cash_back" id="cash_back"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="nb">NB:</label>
                            <textarea v-model="course.nb" class="form-control" rows="5" name="nb" id="nb"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="position">Post To</label>
                            <select v-model="course.position" name="position" id="position" class="form-control">
                                <option value="1">Ony Front</option>
                                <option value="2">Only Back</option>
                                <option value="3">Both</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="images">Images</label>
                            <input accept="image/*" multiple :class="{'is-invalid': errors.hasOwnProperty('images')}" type="file" class="form-control form-control-sm" name="images[]" id="images">
                            <ErrorMessage error-key="images" :errors="errors"/>
                        </div>
                        <div class="form-group">
                            <label for="is_publish">Publish Status</label>
                            <select v-model="course.is_publish" name="is_publish" id="is_publish" class="form-control">
                                <option value="1">Publish</option>
                                <option value="0">Un Publish</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="mt-2">
                                    <ProgressBar :percentage="uploadPercentage"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <ImageEdit :images="course.images" @deleted="(index) => course.images.splice(index, 1)"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Datepicker from '../../components/datepicker'
    import ErrorMessage from '../../components/error-message'
    import ProgressBar from '../../components/progress-bar'
    import EditCategoryTree from '../../components/edit-category-tree'
    import VueSelect from 'vue-select'
    import ImageEdit from '../../components/image-edit'

    export default {
        data(){
            return {
                errors: {},
                course: {},
                uploadPercentage: 0
            }
        },
        computed: {
            discountGiven(){
                return Math.round(
                    this.course.price.percentOf(this.course.discount_percentage)
                )
            },
            priceAfterDiscount(){
                return (this.course.price - this.discountGiven)
            }
        },
        mounted(){
            this.getCourse()
        },
        components: {
            ErrorMessage, Datepicker, VueSelect, ProgressBar, EditCategoryTree, ImageEdit
        },
        methods: {
            update({ target }){
                let vm = this
                window.axios.post(`/courses/${this.course.slug}`, new FormData(target), {
                    onUploadProgress(event){
                        if(event.lengthComputable){
                            vm.uploadPercentage = Math.round(event.loaded * 100 / event.total)
                        }
                    }
                }).then(() => {
                    this.$router.push({name: 'courses.index'})
                }).catch(({ response }) => {
                    if(response.status == 422){
                        this.errors = response.data.errors
                    }
                    this.uploadPercentage= 0
                })
            },
            addModule(){
                this.course.modules.push({
                    name: ''
                })
            },
            getCourse(){
                window.axios.get(`/courses/${this.$route.params.slug}`).then(({ data }) => {
                    this.course = data.data
                })
            }
        }
    }
</script>