<template>
    <div>
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Client</h6>
                        </div>
<!--                        <div class="col-lg-6 col-5 text-right">-->
<!--                            <a href="#" class="btn btn-sm btn-neutral" @click="newClient">New</a>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col">
                    <div class="card" id="deleteLoading">
                        <!-- Card header -->
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Client</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Light table -->
                        <div class="table-responsive" id="clientLoading">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort">Name</th>
                                    <th scope="col" class="sort">Email</th>
                                </tr>
                                </thead>
                                <tbody class="list" v-for="item in items" :key="item.id">
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{ item.name }}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="budget">
                                        {{ item.email }}
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-if="dataNotFound">
                                <tr class="text-center">
                                    <td colspan="10">No Data Display</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Client",
    data() {
        return {
            items: [],
            activeTooltip1: false,
            dataNotFound : false
        }
    },
    methods: {
        getUsers() {
            let loading = this.block("clientLoading");
            this.axios.get("/api/v1/users")
                .then(response => {
                    loading.close();

                    if (response.data.code === 1) {
                        this.items = response.data.data;
                        if(response.data.per_page) {
                            this.params.per_page = response.data.per_page;
                        }
                        if(response.data.current_page) {
                            this.params.current_page = response.data.current_page;
                        }
                        if(response.data.total) {
                            this.params.total = response.data.total;
                        }

                        return;
                    }

                    this.dataNotFound = true;

                    this.errorNotification(response.data.validation_errors);
                })
                .catch(error => {
                    loading.close();
                    this.dataNotFound = true;
                    this.errorNotification(error.message);
                })
        },
    },
    mounted() {
        this.getUsers();
    }
}
</script>
<style>
.btn i:not(:last-child), .btn svg:not(:last-child) {
    margin-right: unset;
}
</style>
