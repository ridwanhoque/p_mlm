import swal from "sweetalert";
import Vue from 'vue'

export default {
    methods: {
        warning(obj){
            obj = $.extend({
                title: "Are you sure!",
                text: "Delete this data?"
            }, obj);

            return new Promise((resolve, reject) => {
                swal({
                    title: obj.title,
                    text: obj.text,
                    dangerMode: true,
                    buttons: true
                }).then((willSuccess) => {
                    if(willSuccess){
                        resolve()
                    }
                })
            })
        }
    }
}

export const Bus = new Vue();