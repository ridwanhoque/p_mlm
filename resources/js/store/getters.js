import _ from 'lodash'

export default {
    isAuthenticated(state){
        return !_.isEmpty(state.user)
    },
    fullName(state){
        return state.user.name;
    },
    role(state){
        return state.user.role;
    },
    // Roles
    isAdmin(state, getters){

        return window.jQuery.inArray(getters.role, ['admin', 'sub-admin']);
    },
    isCustomer(state, getters){

        return window.jQuery.inArray(getters.role, ['general', 'registered', 'un-registered']);
    }
}