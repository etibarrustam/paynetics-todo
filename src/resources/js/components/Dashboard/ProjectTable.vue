<template>
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Project</h3>
                        </div>
                        <div class="col text-right">
                            <router-link to="/project" class="btn btn-sm btn-primary">See all</router-link>
                        </div>
                    </div>
                </div>
                <!-- Light table -->
                <div class="table-responsive" id="projectLoading">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort">Project</th>
                            <th scope="col" class="sort">Status</th>
                            <th scope="col" class="sort">Completion</th>
                            <th scope="col" class="sort">Create At</th>
                        </tr>
                        </thead>
                        <tbody class="list" v-for="item in items" :key="item.name">
                            <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">
                                            {{ item.name }}
                                        </span>
                                    </div>
                                </div>
                            </th>
                            <td>
                                <span class="badge badge-dot mr-4">
                                    {{ item.status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="completion mr-2">{{ item.completion }} %</span>
                                    <div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" v-if="item.status == 0" role="progressbar"  v-bind:style="{ width: '25%' }"></div>
                                            <div class="progress-bar bg-success" v-if="item.status == 1" role="progressbar"  v-bind:style="{ width: '50%' }"></div>
                                            <div class="progress-bar bg-danger" v-if="item.status == 2" role="progressbar"  v-bind:style="{ width: '75%' }"></div>
                                            <div class="progress-bar bg-info" v-if="item.status == 3" role="progressbar"  v-bind:style="{ width: '100%' }"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="completion mr-2">{{ item.created_at }}</span>
                                </div>
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
</template>

<script>
export default {
    name: "ProjectTable",
    data(){
        return{
            items:{},
            statuses:[],
            dataNotFound : false
        }
    },
    methods:{
        getProjects(){
            let loading = this.block("projectLoading")
            this.axios.get("/api/v1/projects")
                .then(response =>{
                    loading.close();

                    if (response.data.code === 1) {
                        this.items = response.data.data;
                        return;
                    }

                    this.errorNotification(response.data.validation_errors);
                })
                .catch(error =>{
                    loading.close();
                    this.dataNotFound = true;
                    this.errorNotification(error.message);
                })
        },
        getStatuses() {
            this.axios.get("/api/v1/projects/statuses")
                .then(response => {
                    if (response.data.code !== 1) {
                        this.errorNotification(response.data.validation_errors);
                    }

                    this.statuses = response.data.data;
                })
                .catch(error => {
                    this.errorNotification(error.message);
                });
        },
    },
    mounted() {
        this.getProjects();
        this.getStatuses();
    }
}
</script>

