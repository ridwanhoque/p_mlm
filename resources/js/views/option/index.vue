<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Site Options</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <app-loader></app-loader>
                    <div class="tile-body">
                        <form @submit.prevent="update">
                            <div class="row">
                                <div class="col-3">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link active" id="v-pills-website-tab" data-toggle="pill" href="#v-pills-website" role="tab" aria-controls="v-pills-website" aria-selected="true">Website</a>
                                        <a class="nav-link" id="v-pills-social-tab" data-toggle="pill" href="#v-pills-social" role="tab" aria-controls="v-pills-social" aria-selected="false">Social Links</a>
                                        <a class="nav-link" id="v-pills-contact-tab" data-toggle="pill" href="#v-pills-contact" role="tab" aria-controls="v-pills-contact" aria-selected="false">Contact</a>
                                        <a class="nav-link" id="v-pills-delivery-tab" data-toggle="pill" href="#v-pills-delivery" role="tab" aria-controls="v-pills-delivery" aria-selected="false">Delivery</a>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-website" role="tabpanel" aria-labelledby="v-pills-website-tab">
                                            <div class="form-group">
                                                <label for="website_name">Website Name</label>
                                                <input type="text" :value="option.get('website_name')" name="text[website_name]" class="form-control" id="website_name">
                                            </div>
                                            <div class="form-group">
                                                <div>
                                                    <img v-if="option.has('website_logo')" :src="`/uploads/${option.get('website_logo')}`" class="img-thumbnail" alt="Website Logo">
                                                </div>
                                                <label for="website_logo">Website Logo</label>
                                                <input type="file" name="files[website_logo]" class="form-control" id="website_logo">
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-social" role="tabpanel" aria-labelledby="v-pills-social-tab">
                                            <div class="form-group">
                                                <label for="facebook_link">Facebook Link</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-facebook"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" :value="option.get('facebook_link')" name="text[facebook_link]" class="form-control" id="facebook_link">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="twitter_link">Twitter Link</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-twitter"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" :value="option.get('twitter_link')" name="text[twitter_link]" class="form-control" id="twitter_link">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="youtube_link">Youtube Link</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-youtube"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" :value="option.get('youtube_link')" name="text[youtube_link]" class="form-control" id="youtube_link">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="linkedin_link">LinkedIn Link</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-linkedin"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" :value="option.get('linkedin_link')" name="text[linkedin_link]" class="form-control" id="linkedin_link">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-contact" role="tabpanel" aria-labelledby="v-pills-contact-tab">
                                            <div class="form-group">
                                                <label for="contact_address">Address</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-map-marker"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" :value="option.get('contact_address')" name="text[contact_address]" class="form-control" id="contact_address">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="contact_phone_number">Phone Number</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-phone"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" :value="option.get('contact_phone_number')" name="text[contact_phone_number]" class="form-control" id="contact_phone_number">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="contact_email">Email</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-envelope"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" :value="option.get('contact_email')" name="text[contact_email]" class="form-control" id="contact_email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade " id="v-pills-delivery" role="tabpanel" aria-labelledby="v-pills-delivery-tab">
                                            <div class="form-group">
                                                <label for="delivery_inside_dhaka">Delivery Inside Dhaka</label>
                                                <input type="text" :value="option.get('delivery_inside_dhaka')" name="text[delivery_inside_dhaka]" class="form-control" id="delivery_inside_dhaka">
                                            </div>
                                            <div class="form-group">
                                                <label for="delivery_outside_dhaka">Delivery Outside Dhaka</label>
                                                <input type="text" :value="option.get('delivery_outside_dhaka')" name="text[delivery_outside_dhaka]" class="form-control" id="delivery_outside_dhaka">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-9 offset-3">
                                    <div class="form-group">
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SiteOption from "../../services/Option";
    import ErrorMessage from '../../components/error-message'

    export default {
        data(){
            return {
                option: new SiteOption()
            }
        },
        components: {
            ErrorMessage
        },
        methods: {
            update({ target }){
                SiteOption.update(target)
            },
        }
    }
</script>