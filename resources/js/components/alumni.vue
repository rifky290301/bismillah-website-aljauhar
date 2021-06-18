<template>
  <div class="p-0">
    <div class="card">
      <div class="card-header ui-sortable-handle" style="cursor: move">
        <h3 class="card-title">
          <i class="fas fa-users mr-1"></i>
          Alumni
        </h3>
        <div class="card-tools">
          <ul class="nav nav-pills ml-auto">
            <li class="nav-item mr-1">
              <button class="btn btn-sm btn-primary" @click="createMode">
                <i class="fas fa-plus-circle"></i> Add New
              </button>
            </li>
            <li class="nav-item">
              <div class="input-group mt-0 input-group-sm" style="width: 350px">
                <input
                  type="text"
                  name="table_search"
                  v-model="searchWord"
                  class="form-control float-right"
                  placeholder="Search by name, email"
                  @keypress="search"
                  @keyup="search"
                  autofocus
                />

                <div class="input-group-append">
                  <button type="submit" class="btn btn-default" @click="search">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
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
              <th>Nama</th>
              <th>Tahun Masuk</th>
              <th>Tahun Keluar</th>
              <th>Nomor HP</th>
              <th>Nomor Kamar</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, index) in users" :key="user.id">
              <td>{{ index + 1 }}</td>
              <td>{{ user.nama }}</td>
              <td>{{ user.tahun_masuk }}</td>
              <td>{{ user.tahun_keluar }}</td>
              <td>{{ user.no_hp }}</td>
              <td>{{ user.no_kamar }}</td>
              <td>
                <button
                  class="text-white btn btn-sm btn-info"
                  @click="viewUser(user)"
                >
                  <i class="fa fa-eye"></i> View
                </button>
                <button
                  class="text-white btn btn-sm btn-warning"
                  @click="editUser(user)"
                >
                  <i class="fa fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-danger" @click="deleteUser(user)">
                  <i class="fa fa-trash"></i> Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <loading :loading="loading"></loading>
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
            <div class="row">
              <div class="col-md-6">
                <p><b>Nama:</b> {{ user.nama }}</p>
                <p><b>Tahun Masuk:</b> {{ user.tahun_masuk }}</p>
                <p><b>Tahun Keluar:</b> {{ user.tahun_keluar }}</p>
                <p><b>Nomor HP:</b> {{ user.no_hp }}</p>
                <p><b>Nomor Kamar:</b> {{ user.no_kamar }}</p>
              </div>

              <div class="col-md-6">
                <img :src="img" class="img-circle" />
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
              Tambahkan Data Alumni
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
                <label> Nama </label>
                <input
                  v-model="form.nama"
                  type="text"
                  name="nama"
                  placeholder="Nama"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('nama') }"
                />
                <has-error :form="form" field="nama"></has-error>
              </div>

              <div class="form-group">
                <label> Tahun Masuk </label>
                <input
                  v-model="form.tahun_masuk"
                  type="text"
                  name="tahun_masuk"
                  placeholder="Tahun Masuk"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('tahun_masuk') }"
                />
                <has-error :form="form" field="tahun_masuk"></has-error>
              </div>
              <div class="form-group">
                <label> Tahun Keluar </label>
                <input
                  v-model="form.tahun_keluar"
                  type="text"
                  name="tahun_keluar"
                  placeholder="Tahun Keluar"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('tahun_keluar') }"
                />
                <has-error :form="form" field="tahun_keluar"></has-error>
              </div>
              <div class="form-group">
                <label> Nomor HP </label>
                <input
                  v-model="form.no_hp"
                  type="text"
                  name="no_hp"
                  placeholder="Nomor HP"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('no_hp') }"
                />
                <has-error :form="form" field="no_hp"></has-error>
              </div>
              <div class="form-group">
                <label> Nomor Kamar </label>
                <input
                  v-model="form.no_kamar"
                  type="text"
                  name="no_kamar"
                  placeholder="Nomor Kamar"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('no_kamar') }"
                />
                <has-error :form="form" field="no_kamar"></has-error>
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
              <b-button variant="primary" v-if="!load" class="btn-lg" disabled>
                <b-spinner small type="grow"></b-spinner>
                {{ action }}
              </b-button>
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
export default {
  data() {
    return {
      action: "",
      searchWord: "",
      loading: false,
      editMode: false,
      load: true,
      img: "http://localhost:8000/img/avatar.jpg",
      user: {},
      users: [],
      roles: [],
      permissions: [],
      form: new Form({
        id: "",
        nama: "",
        tahun_masuk: "",
        tahun_keluar: "",
        no_hp: "",
        no_kamar: "",
      }),
    };
  },
  methods: {
    search() {
      this.loading = true;
      axios
        .get("/alumni/search?s=" + this.searchWord)
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
          text: user.nama + " akan dihapus!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "delete",
        })
        .then((result) => {
          if (result.value) {
            axios
              .delete("/alumni/" + user.id)
              .then(() => {
                this.$toastr.s("Data berhasil dihapus", "Delete");
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
      $("#createUser").modal("show");
    },
    getUsers() {
      this.loading = true;
      axios
        .get("/getAllAlumni")
        .then((response) => {
          this.loading = false;
          this.users = response.data.users;
        })
        .catch(() => {
          this.loading = false;
          this.$toastr.e("Cannot load users", "Error");
        });
    },
    viewUser(user) {
      $("#viewUser").modal("show");
      this.img = "http://localhost:8000/img/" + user.photo;
      this.user = user;
    },

    createUser() {
      this.action = "Menambahkan data ...";
      this.load = false;
      this.form
        .post("/alumni")
        .then((response) => {
          this.load = true;
          this.$toastr.s("Data berhasil ditambahkan", "Created");
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
      this.action = "Update data ...";
      this.load = false;
      this.form
        .put("/alumni/" + this.form.id)
        .then((response) => {
          this.load = true;
          this.$toastr.s("Data berhasil di update", "Update");
          Fire.$emit("loadUser");
          $("#createUser").modal("hide");
          this.form.reset();
        })
        .catch(() => {
          this.load = true;
          this.$toastr.e("Cannot update user information, try again", "Error");
        });
    },
  },
  created() {
    this.getUsers();
    Fire.$on("loadUser", () => {
      this.getUsers();
    });
  },
};
</script>
