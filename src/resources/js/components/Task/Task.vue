<template>
    <div>
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
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
                            </div>
                        </div>

                        <!-- Light table -->
                        <div class="table-responsive" id="taskLoading">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort">Task</th>
                                    <th scope="col" class="sort">Responsible User</th>
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
                                    <td class="budget">
                                        {{ item.description }}
                                    </td>
                                    <td>
                                        <span class="badge badge-dot mr-4">
<!--                                            <i class="bg-danger" v-if="item.status == status.pending"></i>-->
<!--                                            <i class="bg-success" v-if="item.status == status.completed"></i>-->
                                            <span class="status">{{ item.status }}</span>
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
                    <input class="form-control" placeholder="Responsible User" v-model="task.description"/>
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
                    <label class="form-control-label">Start Date</label>
                    <input class="form-control" placeholder="due date" type="date" v-model="task.start_at"/>
                </div>
                <div class="form-group mt--3">
                    <label class="form-control-label">End Date</label>
                    <input class="form-control" placeholder="due date" type="date" v-model="task.end_at"/>
                </div>
                <div class="footer-dialog text-center">
                    <button class="btn btn-primary" type="submit" v-if="!task.id">Add New Task</button>
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
                    <button class="btn btn-primary" @click="deleteTask()">
                        Ok
                    </button>
                    <button class="btn btn-light" @click="deleteDialog=false">
                        Cancel
                    </button>
                </div>
            </template>
        </vs-dialog>
    </div>
</template>

<script>
export default {
    name: "Dashboard",
    data() {
        return {
            task: {},
            deletePostData: {
                id: null
            },
            items: [],
            statuses: [],
            createForm: false,
            editTaskModel: false,
            activeTooltip1: false,
            deleteDialog: false,
            dataNotFound : false
        }
    },
    methods: {
        newTask() {
            console.log('clicked', this.createForm);
            this.resetTask();
            this.createForm =! this.createForm
        },
        getTasks() {
            let loading = this.block("taskLoading");
            this.axios.get("/api/v1/tasks")
                .then(response => {
                    this.items = response.data.data;
                    loading.close();
                    this.dataNotFound = false;
                })
                .catch(error => {
                    this.items = []
                    this.dataNotFound = true;
                    loading.close()
                })
        },
        createOrUpdate() {
            if (this.task.id) {
                return this.update();
            }
            let Loading = this.block("addTaskForm");
            this.axios.post('api/v1/tasks', this.task)
                .then(response => {
                    if (response.data.code === 1) {
                        this.resetTask();
                        Loading.close();
                        this.createFrom = false;
                        this.getTasks();
                    } else {
                        this.errorNotification('Error');
                        Loading.close()
                    }
                })
                .catch(error => {
                    // this.errorNotification(error.response.data.message)
                    Loading.close()
                });
        },
        updateTask() {
            let Loading = this.block("editTaskForm");
            this.axios.put("/api/v1/tasks/" + this.task.id, this.task)
                .then(response => {
                    this.resetTask();
                    this.editTaskModel = false;
                    // this.successNotification(response.data.message);
                    Loading.close();
                    this.getTasks();
                })
                .catch(error => {
                    this.editTaskModel = false;
                    this.errorNotification(error.response.data.message);
                    Loading.close()
                });
        },
        onChangeStatus(event) {
            this.task.status = event.target.value;
        },
        onEditChangeStatus(event) {
            this.editPostData.status = event.target.value;
        },
        deleteBtn(id) {
            if (id == '') {
                this.errorNotification("Something we Wrong..");
            }
            this.deleteDialog = true;
            this.deletePostData.id = id;
        },
        deleteTask() {
            let Loading = this.block("deleteLoading");
            this.axios.delete("/api/v1/delete/task/" + this.deletePostData.id)
                .then(response => {
                    if (response.data.status === true) {
                        this.deleteDialog = false;
                        this.successNotification(response.data.message)
                        this.getTask();
                        Loading.close();
                    } else {
                        this.deleteDialog = false;
                        this.errorNotification(response.data.message)
                        Loading.close();
                    }
                })
                .catch(error => {
                    this.deleteDialog = false;
                    Loading.close();
                    this.errorNotification(error.response.data.message)
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
        getStatuses() {
            this.axios.get("/api/v1/projects/statuses")
                .then(response => {
                    this.statuses = response.data.data;
                })
                .catch(error => {
                    console.log(error.response.data)
                });
        },
        resetTask() {
            this.task = {
                name: null,
                project_id: null,
                description: null,
                status: null,
                start_at: null,
                end_at: null
            };
        }
    },
    mounted() {
        this.resetTask();
        this.getTasks();
        this.getStatuses();
    }
}
</script>
<style>
.btn i:not(:last-child), .btn svg:not(:last-child) {
    margin-right: unset;
}
</style>
