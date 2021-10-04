export default {
    loadingStatus(state, status) {
        state.app.isLoading = status
    },

    setAuthUser(state, user){
        state.user = user
    }
}