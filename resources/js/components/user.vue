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
            <i class="fas fa-plus-circle"></i> Tambah data
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
              Show
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <button class="dropdown-item" @click="dataPerHalaman(5)">
                5
              </button>
              <button class="dropdown-item" @click="dataPerHalaman(10)">
                10
              </button>
              <button class="dropdown-item" @click="dataPerHalaman(20)">
                20
              </button>
              <button class="dropdown-item" @click="dataPerHalaman(50)">
                50
              </button>
            </div>
          </div>
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
            <div
              style="overflow-y: auto; max-height: 50vh"
              class="dropdown-menu dropdown-menu-right"
            >
              <button
                class="dropdown-item"
                v-for="n in 25"
                :key="n"
                name="table_search"
                @click="searchKamar(n)"
              >
                {{ n }}
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
              <div class="input-group input-group-sm">
                <input
                  type="text"
                  name="table_search"
                  v-model="filters.title.value"
                  class="form-control"
                  placeholder="Search"
                  autofocus
                />
              </div>
            </li>
          </ul>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="table-responsive-md">
        <v-table
          :data="users"
          :filters="filters"
          :currentPage.sync="currentPage"
          :pageSize="dataPerPage"
          :hideSortIcons="false"
          @totalPagesChanged="totalPages = $event"
          class="table"
        >
          <thead slot="head">
            <tr>
              <th>#</th>
              <th>Profil</th>
              <v-th sortKey="name">Name</v-th>
              <v-th defaultSort="asc" sortKey="no_kamar">Kamar</v-th>
              <v-th sortKey="no_telepon">Nomor HP</v-th>
              <v-th sortKey="email">Email</v-th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody slot="body" slot-scope="{ displayData }">
            <tr v-for="(user, index) in displayData" :key="user.id">
              <td>{{ index + 1 }}</td>
              <td>
                <img
                  :src="'upload/profil/' + user.photo"
                  style="height: 30px"
                />
              </td>
              <td>{{ user.name }}</td>
              <td>{{ user.no_kamar }}</td>
              <td>{{ user.no_telepon }}</td>
              <td>{{ user.email }}</td>
              <td>
                <div style="width: 8rem" class="">
                  <button
                    class="btn btn-sm btn-info text-white"
                    @click="viewUser(user)"
                  >
                    <i class="fa fa-eye"></i>
                  </button>
                  <button
                    class="btn btn-sm btn-warning text-white"
                    v-show="idRole != 3"
                    @click="editUser(user)"
                  >
                    <i class="fa fa-edit"></i>
                  </button>
                  <button
                    class="btn btn-sm btn-danger"
                    v-show="idRole != 3"
                    @click="deleteUser(user)"
                  >
                    <i class="fa fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </v-table>
        <center class="d-flex justify-content-center mb-2">
          <smart-pagination
            :currentPage.sync="currentPage"
            :totalPages="totalPages"
          />
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
            <div class="d-flex justify-content-between">
              <button
                type="button"
                class="btn btn-lg btn-danger"
                data-dismiss="modal"
              >
                Batal
              </button>

              <button
                type="submit"
                v-show="!editMode"
                class="btn btn-lg btn-primary"
              >
                Simpan
              </button>
              <button
                type="submit"
                v-show="editMode"
                class="btn btn-lg btn-success"
              >
                Ubah
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // smart table
      dataPerPage: 10,
      currentPage: 1,
      totalPages: 0,
      // smart table
      pageOfItems: [],
      searchWord: "",
      loading: false,
      editMode: false,
      img: "",
      user: {},
      users: [],
      roles: [],
      permissions: [],
      // kamar: {},
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
      filters: {
        title: {
          value: "",
          keys: ["nomor", "name", "phone", "password", "email"],
        },
      },
    };
  },
  methods: {
    dataPerHalaman(input) {
      this.dataPerPage = input;
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
      this.form.reset();
    },

    deleteUser(user) {
      swal
        .fire({
          title: "Apakah kamu yakin ?",
          text: user.name + " akan dihapus !",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Hapus",
        })
        .then((result) => {
          if (result.value) {
            axios
              .delete("/delete/user/" + user.id)
              .then(() => {
                this.$toastr.s("user berhasil dihapus", "Deleted");
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
          // this.kamar = response.data.kamar;
        })
        .catch(() => {
          this.loading = false;
          this.$toastr.e("Cannot load users", "Error");
        });
    },
    viewUser(user) {
      $("#viewUser").modal("show");
      this.img = baseUrl + "/upload/profil/" + user.photo;
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
      this.form
        .post("/account/create")
        .then((response) => {
          this.$toastr.s("User berhasil ditambahkan", "Created");
          Fire.$emit("loadUser");
          $("#createUser").modal("hide");
          this.form.reset();
        })
        .catch(() => {
          this.$toastr.e("User gagal ditambahkan, coba lagi", "Error");
        });
    },

    updateUser() {
      this.form
        .put("/account/update/" + this.form.id)
        .then((response) => {
          this.$toastr.s("Data beerhasil di ubah", "Updated");
          Fire.$emit("loadUser");
          $("#createUser").modal("hide");
          this.form.reset();
        })
        .catch(() => {
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
