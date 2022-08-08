<template>
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Search form -->
                <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
                    <div class="form-group mb-0">
                        <div class="input-group input-group-alternative input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input class="form-control" placeholder="Search" type="text">
                        </div>
                    </div>
                    <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </form>
                <!-- Navbar links -->
                <ul class="navbar-nav align-items-center  ml-md-auto ">
                    <li class="nav-item d-xl-none">
                        <!-- Sidenav toggler -->
                        <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav align-items-center  ml-auto ml-md-0" >
                    <li class="nav-item dropdown" id="profileInfoLoading">
                        <a class="nav-link pr-0" href="#" role="button">
                            <div class="media align-items-center">
                                <vs-avatar circle>
                                    <img v-bind:src="profileInfo.image">
                                </vs-avatar>
                                <div class="media-body  ml-2  d-none d-lg-block">
                                    <span class="mb-0 text-sm  font-weight-bold">{{ profileInfo.name }}</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>

export default {
    name: "Navbar",
    data(){
        return{
            profileInfo:{
                name : null
            },
        }
    },
    methods:{
        getProfileInfo(){
            this.axios.get("/api/v1/user/data")
                .then(response =>{
                    if (response.data.code === 1) {
                        let data = response.data.data;
                        this.profileInfo.name = data.name ? data.name : "----- ------";

                        return;
                    }

                    this.errorNotification(response.data.validation_errors);
                })
                .catch(error =>{
                    this.errorNotification(error.message);
                })
        },
    },
    mounted() {
        this.getProfileInfo();
    }
}
</script>
