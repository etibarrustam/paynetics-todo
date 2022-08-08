<template>
    <div>
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-3 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Task</h6>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <a href="#" class="btn btn-sm btn-neutral" @click="newTask">New</a>
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
                                    <h3 class="mb-0">Task</h3>
                                </div>
                                <div class="col">
                                    <div class="form-group mt--3">
                                        <label class="form-control-label">Choose project</label>
                                        <select
                                            class="form-control"
                                            @change="getTasks"
                                            ref="getStatus"
                                            v-model="params.project_id"
                                        >
                                            <option :value="project.id" v-for="project in projects">
                                                {{ project.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Light table -->
                        <div class="table-responsive" id="taskLoading">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort">Task</th>
                                    <th scope="col" class="sort">Status</th>
                                    <th scope="col" class="sort">Due Date</th>
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
                                            <span class="completion mr-2">{{ item.end_at }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: inline-flex">
                                            <div>
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
                    Add New <b>Task</b>
                </h4>
            </template>
            <form v-on:submit.prevent="createOrUpdate()" id="addTaskForm">
                <div class="form-group">
                    <label class="form-control-label">Name</label>
                    <input class="form-control" placeholder="Name" v-model="task.name"/>
                </div>
                <div class="form-group mt--3">
                    <label class="form-control-label">Description</label>
                    <textarea class="form-control" placeholder="Description" v-model="task.description"></textarea>
                </div>
                <div class="form-group mt--3">
                    <label class="form-control-label">Status</label>
                    <select class="form-control" @change="onChangeStatus($event)" ref="getStatus" v-model="task.status">
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
                        v-model="task.employees"
                    >
                    </vue-select>
                </div>
                <div class="form-group mt--3">
                    <label class="form-control-label">Start Date</label>
                    <input class="form-control" placeholder="Start date" type="date" v-model="task.start_at"/>
                </div>
                <div class="form-group mt--3">
                    <label class="form-control-label">End Date</label>
                    <input class="form-control" placeholder="End date" type="date" v-model="task.end_at"/>
                </div>
                <div class="footer-dialog text-center">
                    <button class="btn btn-primary" type="submit" v-if="!task.id">Add New Task</button>
                    <button class="btn btn-primary" type="submit" v-else>Edit Task</button>
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
                    <button class="btn btn-primary" @click="deleteTask()">
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
    name: "Task",
    components: {
        "vue-select": vSelect,
        Pagination
    },
    data() {
        return {
            task: {},
            deletePostData: {
                id: null
            },
            items: [],
            projects: [],
            statuses: [],
            employees:[],
            params: {
                project_id: null,
                current_page: 1,
                per_page: 20,
                total: 20,
                page: 1
            },
            createForm: false,
            editTaskModel: false,
            activeTooltip1: false,
            deleteDialog: false,
            dataNotFound : false
        }
    },
    methods: {
        pagination(page) {
            this.params.page = page;
            this.getTasks();
        },
        newTask() {
            this.resetTask();
            this.createForm =! this.createForm
        },
        getTasks() {
            if (this.employees.length === 0) {
                this.getEmployees();
            }
            let loading = this.block("taskLoading");
            this.axios.get("/api/v1/tasks", {params: this.params})
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
                    this.dataNotFound = true;
                    this.errorNotification(error.message);
                    loading.close();
                })
        },
        createOrUpdate() {
            if (this.task.id) {
                return this.update();
            }
            let loading = this.block("addTaskForm");
            this.axios.post('api/v1/tasks', this.task)
                .then(response => {
                    loading.close();

                    if (response.data.code === 1) {
                        this.createForm = false;
                        this.resetTask();
                        this.successNotification('Success');
                        return this.getTasks();
                    }

                    this.errorNotification(response.data.validation_errors);
                })
                .catch(error => {
                    this.errorNotification(error.message);
                    loading.close();
                });
        },
        update() {
            let loading = this.block("addTaskForm");
            this.axios.put("/api/v1/tasks/" + this.task.id, this.task)
                .then(response => {
                    loading.close();

                    if (response.data.code === 1) {
                        this.createForm = false;
                        this.resetTask();

                        this.successNotification('Success');
                        return this.getTasks();
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
            this.task.status = event.target.value;
        },
        deleteBtn(id) {
            if (id == '') {
                this.errorNotification("Something we Wrong..");
            }
            this.deleteDialog = true;
            this.deletePostData.id = id;
        },
        deleteTask() {
            let loading = this.block("deleteLoading");
            this.axios.delete("/api/v1/tasks/" + this.deletePostData.id)
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
                    this.task = item;
                }
            });
            this.createForm = true;
        },
        resetTask() {
            this.task = {
                name: null,
                project_id: this.$route.query.project_id ? this.$route.query.project_id : null,
                description: null,
                status: null,
                start_at: null,
                end_at: null,
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
            this.axios.get("/api/v1/tasks/statuses")
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
        getProjects() {
            let loading = this.block("taskLoading");
            this.axios.get("/api/v1/projects", {params: {project_id: this.params.project_id}})
                .then(response => {
                    if (response.data.code !== 1) {
                        this.errorNotification(response.data.validation_errors);
                    }

                    this.projects = response.data.data;
                    loading.close()
                })
                .catch(error => {
                    this.errorNotification(error.message);
                    loading.close()
                })
        },
        getEmployees() {
            this.axios.get("/api/v1/users/employees", {params: {project_id: this.params.project_id}})
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
        this.resetTask();
        this.getProjects();
        this.getStatuses();

        if (this.$route.query.project_id) {
            this.params.project_id = this.$route.query.project_id;
            this.task.project_id = this.$route.query.project_id;

            this.getEmployees();
            this.getTasks();
        }
    }
}
</script>
<style>
.btn i:not(:last-child), .btn svg:not(:last-child) {
    margin-right: unset;
}
</style>
