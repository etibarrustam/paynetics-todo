<template>
    <div class="text-center">
        <!-- Main content -->
        <div class="main-content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "Auth",
    beforeMount() {
        this.axios
        .get("api/v1/auth/check")
        .then(response => {
            if (response.data.code === 1){
                return this.$router.push('dashboard');
            }

            this.$router.push('login');
        });
    }
}
</script>

<style>
.main-content{
    background-color: #172b4d;
}
</style>
