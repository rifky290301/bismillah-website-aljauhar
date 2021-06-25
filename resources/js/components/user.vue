<template>
  <div class="p-0">
    <div class="card">
      <div class="card-header ui-sortable-handle" style="cursor: move">
        <h3 class="card-title">
          <i class="fas fa-users mr-1"></i>
          Users
        </h3>
        <div class="float-right mr-2">
          <button
            class="btn btn-sm btn-primary"
            v-show="idRole != 3"
            @click="createMode"
          >
            <i class="fas fa-plus-circle"></i> Add New
          </button>
        </div>
        <div class="float-right mr-2">
          <div class="btn-group">
            <button
              class="btn btn-secondary btn-sm dropdown-toggle"
              type="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              Kamar
            </button>
            <div class="dropdown-menu">
              <button
                class="dropdown-item"
                v-for="item in kamar"
                :key="item.index"
                name="table_search"
                @click="searchKamar(item.index)"
              >
                {{ item.index }}
              </button>
            </div>
          </div>
        </div>
        <div class="float-right mr-2">
          <ul class="nav nav-pills ml-auto">
            <li class="nav-item mr-2">
              <template v-if="loading">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  style="
                    margin: auto;
                    background: none;
                    display: block;
                    shape-rendering: auto;
                  "
                  width="30px"
                  height="30px"
                  viewBox="0 0 100 100"
                  preserveAspectRatio="xMidYMid"
                >
                  <circle
                    cx="50"
                    cy="50"
                    r="32"
                    stroke-width="8"
                    stroke="#4b79dc"
                    stroke-dasharray="50.26548245743669 50.26548245743669"
                    fill="none"
                    stroke-linecap="round"
                  >
                    <animateTransform
                      attributeName="transform"
                      type="rotate"
                      dur="1s"
                      repeatCount="indefinite"
                      keyTimes="0;1"
                      values="0 50 50;360 50 50"
                    ></animateTransform>
                  </circle>
                  <circle
                    cx="50"
                    cy="50"
                    r="23"
                    stroke-width="8"
                    stroke="#6ac2f8"
                    stroke-dasharray="36.12831551628262 36.12831551628262"
                    stroke-dashoffset="36.12831551628262"
                    fill="none"
                    stroke-linecap="round"
                  >
                    <animateTransform
                      attributeName="transform"
                      type="rotate"
                      dur="1s"
                      repeatCount="indefinite"
                      keyTimes="0;1"
                      values="0 50 50;-360 50 50"
                    ></animateTransform>
                  </circle>
                </svg>
              </template>
            </li>
            <li class="nav-item">
              <div class="input-group input-group-sm" style="width: 350px">
                <input
                  type="text"
                  name="table_search"
                  v-model="searchWord"
                  class="form-control"
                  placeholder="Cari berdasarkan nama"
                  @keypress="search"
                  @keyup="search"
                  autofocus
                />
              </div>
            </li>
          </ul>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Role</th>
              <th>Kamar</th>
              <th>Nomor HP</th>
              <th>Email</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, index) in pageOfItems" :key="user.id">
              <td>{{ index + 1 }}</td>
              <td>{{ user.name }}</td>
              <td>{{ user.role }}</td>
              <td>{{ user.no_kamar }}</td>
              <td>{{ user.no_telepon }}</td>
              <td>{{ user.email }}</td>
              <td>
                <button
                  class="btn btn-sm btn-info text-white"
                  @click="viewUser(user)"
                >
                  <i class="fa fa-eye"></i> View
                </button>
                <button
                  class="btn btn-sm btn-warning text-white"
                  v-show="idRole != 3"
                  @click="editUser(user)"
                >
                  <i class="fa fa-edit"></i> Edit
                </button>
                <button
                  class="btn btn-sm btn-danger"
                  v-show="idRole != 3"
                  @click="deleteUser(user)"
                >
                  <i class="fa fa-trash"></i> Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <center class="pb-0 pt-1">
          <jw-pagination
            :pageSize="10"
            :items="users"
            @changePage="onChangePage"
            :labels="customLabels"
          ></jw-pagination>
        </center>
      </div>

      <!-- <loading :loading="loading"></loading> -->
    </div>

    <div
      class="modal fade"
      id="viewUser"
      tabindex="-1"
      role="dialog"
      aria-labelledby="viewUserModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row p-2">
              <ul class="col-md-12 alignMe">
                <li><b>Nama</b> {{ user.name }}</li>
                <li><b>Email</b> {{ user.email }}</li>
                <li><b>Nomer HP</b> {{ user.phone }}</li>
                <li><b>Nomer Kamar</b> {{ user.no_kamar }}</li>
                <li><b>Status</b> {{ user.status }}</li>
                <li><b>Instansi</b> {{ user.instansi }}</li>
                <li><b>Alamat</b> {{ user.alamat }}</li>
                <li><b>Tahun masuk</b> {{ user.tahun_masuk }}</li>
                <!-- <p><b>Last Updated:</b> {{ user.updated_at }}</p>
                <p><b>Date Posted:</b> {{ user.created_at }}</p> -->
              </ul>

              <div class="">
                <img :src="img" class="img-circle img-thumbnail" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="createUser"
      tabindex="-1"
      role="dialog"
      aria-labelledby="createUserModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5
              class="modal-title"
              id="createUserModalLabel"
              v-show="!editMode"
            >
              Create User
            </h5>
            <h5 class="modal-title" id="createUserModalLabel" v-show="editMode">
              Edit User
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="!editMode ? createUser() : updateUser()">
            <div class="modal-body">
              <div class="form-group">
                <label> Name </label>
                <input
                  v-model="form.name"
                  type="text"
                  name="name"
                  placeholder="Name"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
              </div>

              <div class="form-group">
                <label> Email </label>
                <input
                  v-model="form.email"
                  type="text"
                  name="email"
                  placeholder="Email"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('email') }"
                />
                <has-error :form="form" field="email"></has-error>
              </div>

              <div class="form-group">
                <label> Phone Number </label>
                <input
                  v-model="form.phone"
                  type="text"
                  name="phone"
                  placeholder="Phone Number"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('phone') }"
                />
                <has-error :form="form" field="phone"></has-error>
              </div>

              <div class="form-group" v-show="idRole == 1">
                <label> Choose Role </label>
                <b-form-select
                  v-model="form.role"
                  :options="roles"
                  text-field="name"
                  value-field="id"
                ></b-form-select>
                <has-error :form="form" field="role"></has-error>
              </div>

              <div class="form-group">
                <label> Password </label>
                <input
                  v-model="form.password"
                  type="password"
                  name="password"
                  placeholder="Password"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button
                type="button"
                class="btn btn-lg btn-danger"
                data-dismiss="modal"
              >
                Close
              </button>
              <!-- <b-button variant="primary" v-if="!load" class="btn-lg" disabled>
                <b-spinner small type="grow"></b-spinner>
                {{ action }}
              </b-button> -->
              <button
                type="submit"
                v-if="load"
                v-show="!editMode"
                class="btn btn-lg btn-primary"
              >
                Save User
              </button>
              <button
                type="submit"
                v-if="load"
                v-show="editMode"
                class="btn btn-lg btn-success"
              >
                Update User
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const customLabels = {
  first: "<<",
  last: ">>",
  previous: "<",
  next: ">",
};
export default {
  data() {
    return {
      customLabels,
      pageOfItems: [],
      action: "",
      searchWord: "",
      loading: false,
      editMode: false,
      load: true,
      img: "/img/avatar.jpg",
      user: {},
      users: [],
      roles: [],
      permissions: [],
      kamar: {},
      idRole: "",
      form: new Form({
        id: "",
        name: "",
        phone: "",
        password: "",
        email: "",
        permissions: [],
        role: 3,
      }),
    };
  },
  methods: {
    search() {
      this.loading = true;
      axios
        .get("/search/user?s=" + this.searchWord)
        .then((response) => {
          this.loading = false;
          this.users = response.data.users;
        })
        .catch(() => {
          this.loading = false;
          toast.fire({
            icon: "error",
            title: "search failed",
          });
        });
    },
    searchKamar(nomor) {
      this.loading = true;
      axios
        .get("/search-kamar/user?s=" + nomor)
        .then((response) => {
          this.loading = false;
          this.users = response.data.users;
        })
        .catch(() => {
          this.loading = false;
          toast.fire({
            icon: "error",
            title: "search failed",
          });
        });
    },
    createMode() {
      this.editMode = false;
      $("#createUser").modal("show");
    },

    deleteUser(user) {
      swal
        .fire({
          title: "Are you sure?",
          text: user.name + " will be deleted permanently!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.value) {
            axios
              .delete("/delete/user/" + user.id)
              .then(() => {
                this.$toastr.s("user create succefully", "Created");
                Fire.$emit("loadUser");
              })
              .catch(() => {
                toast.fire({
                  icon: "error",
                  title:
                    user.name + " was unable to be remove, tyr again later",
                });
              });
          }
        });
    },

    editUser(user) {
      this.editMode = true;
      this.form.reset();
      this.form.fill(user);
      if (user.roles[0].id == "undefined") {
        this.form.role = 3;
      } else {
        this.form.role = user.roles[0].id;
      }
      this.form.permissions = user.userPermissions;
      $("#createUser").modal("show");
    },
    getUsers() {
      this.loading = true;
      axios
        .get("/getAllUsers")
        .then((response) => {
          this.loading = false;
          this.users = response.data.users;
          this.idRole = response.data.idRole;
          this.kamar = response.data.kamar;
        })
        .catch(() => {
          this.loading = false;
          this.$toastr.e("Cannot load users", "Error");
        });
    },
    viewUser(user) {
      $("#viewUser").modal("show");
      // this.img = "http://localhost:8000/img/" + user.photo;
      this.user = user;
    },
    getRoles() {
      axios.get("/getAllRoles").then((response) => {
        this.roles = response.data.roles;
      });
    },
    getPermissions() {
      axios.get("/getAllPermissions").then((response) => {
        this.permissions = response.data.permissions;
      });
    },

    createUser() {
      this.action = "Creating user ...";
      this.load = false;
      this.form
        .post("/account/create")
        .then((response) => {
          this.load = true;
          this.$toastr.s("user create succefully", "Created");
          Fire.$emit("loadUser");
          $("#createUser").modal("hide");
          this.form.reset();
        })
        .catch(() => {
          this.load = true;
          this.$toastr.e("Cannot create user, try again", "Error");
        });
    },

    updateUser() {
      this.action = "Update user ...";
      this.load = false;
      this.form
        .put("/account/update/" + this.form.id)
        .then((response) => {
          this.load = true;
          this.$toastr.s("user information updated succefully", "Created");
          Fire.$emit("loadUser");
          $("#createUser").modal("hide");
          this.form.reset();
        })
        .catch(() => {
          this.load = true;
          this.$toastr.e("Cannot update user information, try again", "Error");
        });
    },
    onChangePage(pageOfItems) {
      // update page of items
      this.pageOfItems = pageOfItems;
    },
  },
  created() {
    this.getUsers();
    this.getRoles();
    this.getPermissions();
    Fire.$on("loadUser", () => {
      this.getUsers();
    });
  },
};
</script>
