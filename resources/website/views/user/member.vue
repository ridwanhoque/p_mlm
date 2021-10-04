<template>
    <form ref="form" v-if="!isEmpty(user)">
        <input type="hidden" name="_method" value="PUT">
        <FormWizard ref="wizard" title="Upgrade your membership" subtitle="" color="#e63c38" shape="square">
            <TabContent title="Profile Update" :before-change="goNext">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Previous Price</th>
                            <th>Discount</th>
                            <th>Present Price</th>
                            <th>Commission</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products">
                            <td>
                                <label>
                                    <input type="checkbox">
                                    {{ product.id }}
                                </label>
                            </td>
                            <td>{{ product.name }}</td>
                            <td>{{ product.category.top.name }}</td>
                            <td>{{ product.price.previous }}</td>
                            <td>{{ product.price.discount }}</td>
                            <td>{{ product.price.present }}</td>
                            <td>{{ product.commission }}</td>
                            <td>
                                <a target="_blank" :href="product.routes.permalink">View Details</a>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </TabContent>
            <TabContent title="Joining Product" :before-change="goNext">
                <div class="row">
                    <div class="col-md-6">
                        <strong class="w-100">Personal Information</strong>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <div class="input-box">
                                <input type="text" v-model="user.first_name" id="first_name" name="first_name" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="first_name"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <div class="input-box">
                                <input type="text" v-model="user.last_name" id="last_name" name="last_name" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="last_name"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <div v-if="user.meta.profile_photo">
                                <img :src="`/uploads/${user.meta.profile_photo}`" class="img-thumbnail" alt="Profile Photo">
                            </div>
                            <label for="profile_photo">Profile Photo</label>
                            <div class="input-box">
                                <input type="file" autocomplete="off" id="profile_photo" name="files[profile_photo]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="files.profile_photo"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="father_name">Father's Name</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.father_name" id="father_name" name="meta[father_name]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.father_name"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mother_name">Mother's Name</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.mother_name" id="mother_name" name="meta[mother_name]" class="input-text w-100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.date_of_birth" autocomplete="off" id="date_of_birth" name="meta[date_of_birth]" class="input-text w-100 date">
                                <ErrorMessage :errors="errors" error-key="meta.date_of_birth"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.age" id="age" name="meta[age]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.age"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <div class="input-box">
                                <select v-model="user.meta.gender" id="gender" name="meta[gender]" class="input-text w-100">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <ErrorMessage :errors="errors" error-key="meta.gender"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="religion">Religion</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.religion" id="religion" name="meta[religion]" class="input-text w-100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nid_number">NID</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.nid_number" id="nid_number" name="meta[nid_number]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.nid_number"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <div v-if="user.meta.nid_image">
                                <img :src="`/uploads/${user.meta.nid_image}`" class="img-thumbnail" alt="">
                            </div>
                            <label for="nid_image">NID/Passport</label>
                            <div class="input-box">
                                <input type="file" id="nid_image" name="files[nid_image]" class="input-text w-100">
                                <p class="text-muted">Maximum size 600Kb</p>
                                <ErrorMessage :errors="errors" error-key="files.nid_image"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_qualification">Last Qualification</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.last_qualification" id="last_qualification" name="meta[last_qualification]" class="input-text w-100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="profession">Profession</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.profession" id="profession" name="meta[profession]" class="input-text w-100">
                            </div>
                        </div>
                        <strong class="w-100">Communication</strong>
                        <div class="form-group">
                            <label for="present_address">Present Address</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.present_address" id="present_address" name="meta[present_address]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.present_address"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="district_id">Present District</label>
                            <div class="input-box">
                                <select v-model="user.district_id" id="district_id" name="district_id" class="input-text w-100">
                                    <option :value="null">Select present district</option>
                                    <option :value="district.id" v-for="district in districts">{{ district.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="permanent_address">Permanent Address</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.permanent_address" id="permanent_address" name="meta[permanent_address]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.permanent_address"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="permanent_district">Permanent District</label>
                            <div class="input-box">
                                <select v-model="user.meta.permanent_district" id="permanent_district" name="meta[permanent_district]" class="input-text w-100">
                                    <option :value="null">Select permanent district</option>
                                    <option :value="district.name" v-for="district in districts">{{ district.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Mobile No. 1</label>
                            <div class="input-box">
                                <input type="text" v-model="user.phone_number" id="phone_number" name="phone_number" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="phone_number"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone_number_2">Mobile No. 2</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.phone_number_2" id="phone_number_2" name="meta[phone_number_2]" class="input-text w-100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bkash_number">BKASH No.</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.bkash_number" id="bkash_number" name="meta[bkash_number]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.bkash_number"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <div class="input-box">
                                <input type="text" v-model="user.email" id="email" name="email" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="email"></ErrorMessage>
                            </div>
                        </div>

                        <strong class="w-100">Bank Details</strong>
                        <div class="form-group">
                            <label for="bank_account_name">A/C Name</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.bank_account_name" id="bank_account_name" name="meta[bank_account_name]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.bank_account_name"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bank_account_number">A/C No.</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.bank_account_number" id="bank_account_number" name="meta[bank_account_number]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.bank_account_number"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.bank_name" id="bank_name" name="meta[bank_name]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.bank_name"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bank_branch">Branch</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.bank_branch" id="bank_branch" name="meta[bank_branch]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.bank_branch"></ErrorMessage>
                            </div>
                        </div>
                        <strong class="w-100">Next of Kin</strong>
                        <div class="form-group">
                            <label for="next_kin_name">Name</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.next_kin_name" id="next_kin_name" name="meta[next_kin_name]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.next_kin_name"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="next_kin_relation">Relation</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.next_kin_relation" id="next_kin_relation" name="meta[next_kin_relation]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.next_kin_relation"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="next_kin_phone_number">Tel:</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.next_kin_phone_number" id="next_kin_phone_number" name="meta[next_kin_phone_number]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.next_kin_phone_number"></ErrorMessage>
                            </div>
                        </div>
                        <strong class="w-100">Nominee</strong>
                        <div class="form-group">
                            <label for="nominee_name">Name</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.nominee_name" id="nominee_name" name="meta[nominee_name]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.nominee_name"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nominee_relation">Relation</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.nominee_relation" id="nominee_relation" name="meta[nominee_relation]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.nominee_relation"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nominee_phone_number">Tel:</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.nominee_phone_number" id="nominee_phone_number" name="meta[nominee_phone_number]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.nominee_phone_number"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <div v-if="user.meta.nominee_image">
                                <img :src="`/uploads/${user.meta.nominee_image}`" class="img-thumbnail" alt="">
                            </div>
                            <label for="nominee_image">Image</label>
                            <div class="input-box">
                                <input type="file" id="nominee_image" name="files[nominee_image]" class="input-text w-100">
                                <ErrorMessage :errors="errors" error-key="meta.nominee_image"></ErrorMessage>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="spacial_note">Spacial Note</label>
                            <div class="input-box">
                                <input type="text" v-model="user.meta.spacial_note" id="spacial_note" name="meta[spacial_note]" class="input-text w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </TabContent>

            <TabContent title="New ID" :before-change="goNext">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus accusantium amet aspernatur autem, est ex exercitationem facere illum maiores necessitatibus optio quae quisquam voluptatibus. Atque id minus nobis placeat voluptas.
            </TabContent>
        </FormWizard>
    </form>
</template>

<script>
    import Profile from "../../services/Profile";
    import ErrorMessage from '../../components/error-message'
    import _ from 'lodash'
    import { FormWizard, TabContent } from 'vue-form-wizard'
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'
    import Product from "../../service/Product";

    export default {
        props: {
            districts: {
                type: Array,
                default: function () {
                    return []
                }
            }
        },
        components: {
            ErrorMessage, FormWizard, TabContent
        },
        data(){
            return {
                errors: {},
                user: {},
                products: []
            }
        },
        mounted(){
            this.getUser()
            Product.joining().then(({ data }) => {
                this.products = data.data;
            })
        },
        methods: {
            isEmpty(obj){
                return _.isEmpty(obj)
            },
            getUser(){
                window.axios.get('/portal/profile').then(({ data }) => {
                    this.user = data.data
                })
            },
            goNext(){
                return new Promise((resolve, reject) => {
                    let obj = new FormData(this.$refs.form)

                    obj.append('step', this.$refs.wizard.activeTabIndex)

                    Profile.upgrade(obj).then(() => {

                        resolve(true)
                    }).catch(({ response }) => {
                        this.errors = response.data.errors
                        reject()
                    })
                })
            },
        }
    }
</script>