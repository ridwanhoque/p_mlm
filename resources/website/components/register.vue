<template>
    <form method="post" id="login-form" @submit.prevent="register">
        <fieldset class="col2-set">
            <div class="col-2 registered-users">
                <div class="content">
                    <strong>Personal Information</strong>
                    <ul class="form-list">
                        <li>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="first_name">First Name<em class="required">*</em></label>
                                    <div class="input-box">
                                        <input type="text" name="first_name" id="first_name" class="input-text required-entry" title="First name">
                                        <p class="text-danger" v-if="errors.hasOwnProperty('first_name')">{{ errors['first_name'][0] }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name">Last Name<em class="required">*</em></label>
                                    <div class="input-box">
                                        <input type="text" name="last_name" id="last_name" class="input-text required-entry validate-last_name" title="Email Address">
                                        <p class="text-danger" v-if="errors.hasOwnProperty('last_name')">{{ errors['last_name'][0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <label for="father_name">Father's Name</label>
                            <div class="input-box">
                                <input type="text" id="father_name" name="father_name" class="input-text" title="Father's Name">
                                <p class="text-danger" v-if="errors.hasOwnProperty('father_name')">{{ errors['father_name'][0] }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="date_of_birth">Date of Birth<em class="required">*</em></label>
                                    <div class="input-box">
                                        <input type="text" autocomplete="off" name="date_of_birth" id="date_of_birth" class="input-text date required-entry date" title="Date of Birth">
                                        <p class="text-danger" v-if="errors.hasOwnProperty('date_of_birth')">{{ errors['date_of_birth'][0] }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="age">Age</label>
                                    <div class="input-box">
                                        <input type="text" autocomplete="off" name="age" id="age" class="input-text" title="Age">
                                        <p class="text-danger" v-if="errors.hasOwnProperty('age')">{{ errors['age'][0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <label for="nid_number">NID</label>
                            <div class="input-box">
                                <input type="text" id="nid_number" name="nid_number" class="input-text" title="Father's Name">
                                <p class="text-danger" v-if="errors.hasOwnProperty('nid_number')">{{ errors['nid_number'][0] }}</p>
                            </div>
                        </li>
                        <li>
                            <label for="nid_image">NID/Passport</label>
                            <div class="input-box">
                                <input type="file" id="nid_image" accept="image/*" name="nid_image" class="input-text">
                                <p class="text-danger" v-if="errors.hasOwnProperty('nid_image')">{{ errors['nid_image'][0] }}</p>
                            </div>
                        </li>
                    </ul>
                    <br>
                    <strong>Communication</strong>
                    <ul class="form-list">
                        <li>
                            <label for="present_address">Present Address<em class="required">*</em></label>
                            <div class="input-box">
                                <input type="text" id="present_address" name="present_address" class="input-text" title="Present Address ">
                                <p class="text-danger" v-if="errors.hasOwnProperty('present_address')">{{ errors['present_address'][0] }}</p>
                            </div>
                        </li>
                        <li>
                            <label for="phone_number">Mobile Number 1<em class="required">*</em></label>
                            <div class="input-box">
                                <input type="text" name="phone_number" id="phone_number" class="input-text required-entry validate-phone_number">
                                <p class="text-danger" v-if="errors.hasOwnProperty('phone_number')">{{ errors['phone_number'][0] }}</p>
                            </div>
                        </li>
                        <li>
                            <label for="bkash_number">BKASH No</label>
                            <div class="input-box">
                                <input type="text" name="bkash_number" id="bkash_number" class="input-text required-entry">
                                <p class="text-danger" v-if="errors.hasOwnProperty('bkash_number')">{{ errors['bkash_number'][0] }}</p>
                            </div>
                        </li>
                        <li>
                            <label for="email">Email Address<em class="required">*</em></label>
                            <div class="input-box">
                                <input type="text" id="email" name="email" class="input-text required-entry validate-email" title="Email Address">
                                <p class="text-danger" v-if="errors.hasOwnProperty('email')">{{ errors['email'][0] }}</p>
                            </div>
                        </li>
                        <li>
                            <label for="reference_id">Reference ID</label>
                            <div class="input-box">
                                <input type="text" id="reference_id" name="reference_id" class="input-text required-entry validate-reference_id">
                                <p class="text-danger" v-if="errors.hasOwnProperty('reference_id')">{{ errors['reference_id'][0] }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="password">Password <em class="required">*</em></label>
                                    <div class="input-box">
                                        <input type="password" name="password" id="password" class="input-text required-entry">
                                        <p class="text-danger" v-if="errors.hasOwnProperty('password')">{{ errors['password'][0] }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation">Confirm Password<em class="required">*</em></label>
                                    <div class="input-box">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="input-text">
                                        <p class="text-danger" v-if="errors.hasOwnProperty('password_confirmation')">{{ errors['password_confirmation'][0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <label for="spacial_note">Spacial Note</label>
                            <div class="input-box">
                                <input type="text" id="spacial_note" name="spacial_note" class="input-text">
                                <p class="text-danger" v-if="errors.hasOwnProperty('spacial_note')">{{ errors['spacial_note'][0] }}</p>
                            </div>
                        </li>
                    </ul>

                    <div class="buttons-set">
                        <button type="submit" class="button login" title="Register" name="send" id="send2"><span>Register</span></button>
                        <a href="/login" class="forgot-word">Back to login</a>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</template>

<script>
    import swal from 'sweetalert'
    export default {
        data(){
            return {
                errors: {}
            }
        },
        methods: {
            register({ target }){
                swal('Processing...');

                window.axios.post('/register', new FormData(target)).then(({ data }) => {
                    swal('Done');
                    setTimeout(() => {
                        location.reload()
                    }, 2000);

                    this.errors = {}
                }).catch(({ response }) => {
                    swal.close()
                    this.errors = response.data.errors;
                })
            }
        }
    }
</script>