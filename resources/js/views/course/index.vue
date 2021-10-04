<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-book"></i> Courses</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <router-link :to="{ name: 'courses.create' }" class="btn btn-primary">Create</router-link>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <app-loader/>
                    <div class="tile-body">
                        <table class="table table-bordered" v-if="!isEmpty(courseData)">
                            <thead>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Publish</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(course, index) in courseData.data">
                                    <td>{{ course.id }}</td>
                                    <td>{{ course.name }}</td>
                                    <td>{{ course.price.formatted() }}</td>
                                    <td>
                                        <span class="badge p-1" :class="`badge-${course.publish.class}`">{{ course.publish.text }}</span>
                                    </td>
                                    <td>
                                        <router-link exact class="btn btn-primary btn-xs" :to="{ name: 'courses.update', params: { slug: course.slug } }">
                                            <i class="fa fa-pencil"></i>
                                        </router-link>
                                        <button class="btn btn-danger btn-xs" @click="willDelete(course.routes.destroy, () => courseData.data.splice(index, 1))">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Paginator :data="courseData" @change-page="getCourses"></Paginator>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Modal from '../../components/modal'
    import ErrorMessage from '../../components/error-message'
    import Paginator from '../../components/paginator'

    export default {
        data(){
            return {
                errors: {},
                courseData: {}
            }
        },
        components: {
            Modal, ErrorMessage, Paginator
        },
        mounted(){
            this.getCourses()
        },
        methods: {
            getCourses(page = 1){
                window.axios.get(`/courses`, {
                    params: {
                        page
                    }
                }).then(({ data }) => {
                    this.courseData = data
                })
            }
        }
    }
</script>