<template>
    <div>
        <template v-if="isAdmin">
            <AdminSidebar></AdminSidebar>
        </template>
        <template v-else>
            <Sidebar></Sidebar>
        </template>
        <div class="main-content" id="panel">
            <Navbar></Navbar>
            <router-view></router-view>
         </div>
    </div>
</template>

<script>

import Navbar from "./Navbar";
import Sidebar from "./Sidebar";
import Footer from "./Footer";
import AdminSidebar from "./AdminSidebar";

export default {
    name: "Layout",
    components: {Footer, Sidebar, AdminSidebar, Navbar},
    data(){
        return{
            preloader:false,
            name:'',
            email: '',
            isAdmin: false
        }
    },
    methods:{
        getUserInfo(){
            this.axios.get("api/v1/user/data")
                .then(response => {
                    if (response.data.code === 1) {
                        let item = response.data.data;
                        this.name = item.name;
                        this.email = item.email;
                        this.isAdmin = item.is_admin ? item.is_admin : false;

                        return;
                    }

                    this.errorNotification(response.data.validation_errors);
                })
                .catch(error => {
                    this.errorNotification(error.message);
                })
        }
    },
    beforeMount() {
        this.axios
        .get('api/v1/auth/check')
        .then(response => {
            if (response.data.code !== 1){
                return this.$router.push('login');
            }
        })
        .catch(error => {
            return this.$router.push('login');
        })
    },
    mounted() {
        this.getUserInfo();
    }
}
</script>

<style scoped>
 .fade {
     transition: opacity .15s linear;
 }
.alert-dismissible {
    padding-right: 3.85rem;
}
.alert {
    position: relative;
    padding: 0.75rem 1.25rem;
    margin-bottom: unset;
    border: unset;
    border-radius: unset;
    margin-left: 250px !important;
}
 @media (max-width: 1199.98px){
     .alert {
         margin-left: 0px !important;
     }
 }
 .spinner-border {
     width: 1rem;
     height: 1rem;
 }
</style>
