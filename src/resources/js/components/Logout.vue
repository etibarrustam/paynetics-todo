<template>

</template>

<script>
export default {
    name: "Logout",
    mounted() {
        localStorage.removeItem('token');
        this.axios.get('api/v1/logout')
            .then(response => {
                if (response.data.code === 1){
                    return document.location.href = '/login';
                }

                return this.errorNotification(error.response.validation_errors);
            })
            .catch(error => {
                this.errorNotification(error.message);
            })
    }
}
</script>

<style scoped>

</style>
