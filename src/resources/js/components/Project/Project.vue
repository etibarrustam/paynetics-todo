<template>
        <div>
            <div class="header bg-primary pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center py-4">
                            <div class="col-lg-6 col-7">
                                <h6 class="h2 text-white d-inline-block mb-0">Project</h6>
                            </div>
                            <div class="col-lg-6 col-5 text-right">
                                <a href="#" class="btn btn-sm btn-neutral" @click="newProject">New</a>
                            </div>
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
                                        <h3 class="mb-0">Project</h3>
                                    </div>
                                </div>
                            </div>

                            <!-- Light table -->
                            <div class="table-responsive" id="projectLoading">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="sort">Name</th>
                                        <th scope="col" class="sort">Status</th>
                                        <th scope="col" class="sort">Completion</th>
                                        <th scope="col" class="sort">Create At</th>
                                        <th scope="col" class="sort">Action</th>
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
                                        <td>
                                        <span class="badge badge-dot mr-4">
                                            <span class="status">{{ getStatusName(item.status) }}</span>
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
                                        <td>
                                            <div style="display: inline-flex">
                                                <div>
                                                    <a class="btn btn-default btn-sm" :href="'/task?project_id=' + item.id">
                                                        <i class="far fa-tasks"></i>
                                                        <span><strong>Tasks</strong></span>
                                                    </a>
                                                    <button class="btn btn-primary btn-sm" @click="edit(item.id)">
                                                        <i class="far fa-edit"></i>
                                                        <span><strong>Edit</strong></span>
                                                    </button>
                                                    <button href="#" class="btn btn-danger btn-sm"
                                                            @click="deleteBtn(item.id)">
                                                        <i class="fas fa-trash-alt"></i>
                                                        <span><strong>Delete</strong></span>
                                                    </button>
                                                </div>
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
            </div>
            <vs-dialog v-model="createForm" prevent-close blur>
                <template #header>
                    <h4 class="not-margin">
                        Add New <b>Project</b>
                    </h4>
                </template>
                <form v-on:submit.prevent="createOrUpdate()" id="addProjectForm" ref="resetForm">
                    <div class="form-group">
                        <label class="form-control-label">Name</label>
                        <input class="form-control" placeholder="Name" v-model="project.name"/>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Company Name</label>
                        <input class="form-control" placeholder="Company Name" v-model="project.company_name"/>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Description</label>
                        <textarea class="form-control" placeholder="Description" v-model="project.description"></textarea>
                    </div>
                    <div class="form-group mt--3">
                        <label class="form-control-label">Status</label>
                        <select class="form-control" @change="onChangeStatus($event)" ref="getStatus" v-model="project.status">
                            <option :value="status.value" v-for="status in statuses">
                                {{ status.label }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group mt--3">
                        <label class="form-control-label">Employees</label>
                        <vue-select
                                    :multiple="true"
                                    :options="employees"
                                    label="name"
                                    v-model="project.employees"
                        >
                        </vue-select>
                    </div>
                    <div class="footer-dialog text-center">
                        <button class="btn btn-primary" type="submit" v-if="!project.id">Add New Project</button>
                        <button class="btn btn-primary" type="submit" v-else>Edit Project</button>
                    </div>
                </form>
            </vs-dialog>

            <vs-dialog width="550px" not-center v-model="deleteDialog">
                <template #header>
                    <h4 class="not-margin">
                        <b>Are you sure?</b>
                    </h4>
                </template>
                <div class="con-content">
                    <p>Are you sure you want to Delete?</p>

                </div>
                <template #footer>
                    <div class="con-footer">
                        <button class="btn btn-primary" @click="deleteProject()">
                            Ok
                        </button>
                        <button class="btn btn-light" @click="deleteDialog=false">
                            Cancel
                        </button>
                    </div>
                </template>
            </vs-dialog>
            <pagination v-model="params.current_page" :records="params.total" @paginate="pagination"/>
        </div>
</template>

<script>

import "vue-select/dist/vue-select.css";

import vSelect from "vue-select";
import Pagination from 'vue-pagination-2';

export default {
    name: "Project",
    components: {
        "vue-select": vSelect,
        Pagination
    },
    data() {
        return {
            project: {},
            items: [],
            statuses:[],
            employees:[],
            params: {
                current_page: 1,
                per_page: 20,
                total: 20,
                page: 1
            },
            createForm: false,
            activeTooltip1: false,
            deleteDialog: false,
            dataNotFound : false,
        }
    },
    methods: {
        pagination(page) {
            this.params.page = page;
            this.getProjects();
        },
        newProject() {
            this.resetProject();
            this.createForm =! this.createForm
        },
        getProjects() {
            let loading = this.block("projectLoading");
            this.axios.get("/api/v1/projects", {params: this.params})
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
        createOrUpdate() {
            if (this.project.id) {
                return this.update();
            }
            let loading = this.block("addProjectForm");
            this.axios.post('api/v1/projects', this.project)
                .then(response => {
                    loading.close();

                    if (response.data.code === 1) {
                        this.createForm = false;
                        this.resetProject();
                        this.successNotification('Success');
                        return this.getProjects();
                    }

                    this.errorNotification(response.data.validation_errors);
                })
                .catch(error => {
                    loading.close();
                    this.errorNotification(error.message);
                });
        },
        update() {
            let loading = this.block("addProjectForm");
            this.axios.put("/api/v1/projects/" + this.project.id, this.project)
                .then(response => {
                    loading.close();

                    if (response.data.code === 1) {
                        this.createForm = false;
                        this.resetProject();

                        this.successNotification('Success');
                        return this.getProjects();
                    }

                    this.errorNotification(response.data.validation_errors);
                })
                .catch(error => {
                    this.createForm = false;
                    this.errorNotification(error.message);
                    loading.close();
                });
        },
        onChangeStatus(event) {
            this.project.status = event.target.value;
        },
        deleteBtn(id) {
            if (id == '') {
                this.errorNotification("Something we Wrong..");
            }
            this.deleteDialog = true;
            this.deletePostData.id = id;
        },
        deleteProject() {
            let loading = this.block("deleteLoading");
            this.axios.delete("/api/v1/projects/" + this.deletePostData.id)
                .then(response => {
                    loading.close();

                    if (response.data.code === 1) {
                        this.deleteDialog = false;

                        this.successNotification('Success');
                        return this.getProjects();
                    }

                    this.errorNotification(response.data.validation_errors);
                })
                .catch(error => {
                    loading.close();
                    this.deleteDialog = false;
                    this.errorNotification(error.message);
                });
        },
        edit(id) {
            this.items.forEach((item) => {
                if (item.id === id) {
                    this.project = item;
                }
            });
            this.createForm = true;
        },
        resetProject() {
            this.project = {
                name: null,
                company_name: null,
                description: null,
                status: null,
                duration: null,
                employees: []
            };
        },
        getStatusName(id) {
            let label = '';

            this.statuses.forEach((key, status) => {
                if (id === status.id) {
                    label = status.label;
                }
            });

            return label;
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
        getEmployees() {
            this.axios.get("/api/v1/users")
                .then(response => {
                    if (response.data.code !== 1) {
                        this.errorNotification(response.data.validation_errors);
                    }

                    this.employees = response.data.data;
                })
                .catch(error => {
                    this.errorNotification(error.message);
                });
        },
    },
    mounted() {
        this.resetProject();
        this.getProjects();
        this.getStatuses();
        this.getEmployees();
    }
}
</script>
<style>
.btn i:not(:last-child), .btn svg:not(:last-child) {
    margin-right: unset;
}
</style>
