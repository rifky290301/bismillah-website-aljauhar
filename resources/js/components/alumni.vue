<template>
  <div class="p-0">
    <div class="card">
      <div class="card-header ui-sortable-handle" style="cursor: move">
        <h3 class="card-title">
          <i class="fas fa-users mr-1"></i>
          Data Alumni
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
            <div class="dropdown-menu dropdown-menu-right">
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
          <div class="btn-group">
            <button
              class="btn btn-secondary btn-sm dropdown-toggle"
              type="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              Tahun Masuk
            </button>
            <div class="dropdown-menu">
              <button
                class="dropdown-item"
                v-for="item in tahunMasuk"
                :key="item.index"
                name="table_search"
                @click="searchTahun(item.index)"
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
                  placeholder="Search by name, email"
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
              <th>Nama</th>
              <th>Tahun Masuk</th>
              <th>Tahun Keluar</th>
              <th>Nomor HP</th>
              <th>Nomor Kamar</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, index) in pageOfItems" :key="user.id">
              <!-- <tr v-for="(number, item) in users | filterBy nama in 'nama' | limitBy count offset" :key="user.id"> -->
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
                  v-show="idRole != 3"
                  @click="editUser(user)"
                >
                  <i class="fa fa-edit"></i> Edit
                </button>
                <button
                  v-show="idRole != 3"
                  class="btn btn-sm btn-danger"
                  @click="deleteUser(user)"
                >
                  <i class="fa fa-trash"></i> Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <center class="card-footer pb-0 pt-1">
        <jw-pagination
          :pageSize="10"
          :items="users"
          @changePage="onChangePage"
          :labels="customLabels"
        ></jw-pagination>
      </center>
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
              <div class="col-md-12 alignMe">
                <li><b>Nama</b> {{ user.nama }}</li>
                <li><b>Tahun Masuk</b> {{ user.tahun_masuk }}</li>
                <li><b>Tahun Keluar</b> {{ user.tahun_keluar }}</li>
                <li><b>Nomor HP</b> {{ user.no_hp }}</li>
                <li><b>Nomor Kamar</b> {{ user.no_kamar }}</li>
                <li><b>Pekerjaan</b> {{ user.no_kamar }}</li>
                <li><b>Status</b> {{ user.status }}</li>
                <li><b>Motto</b> {{ user.motto }}</li>
              </div>

              <div class="">
                <!-- <img :src="img" class="img-thumbnail" /> -->
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
              <div class="form-group">
                <label> Pekerjaan </label>
                <input
                  v-model="form.pekerjaan"
                  type="text"
                  name="pekerjaan"
                  placeholder="Pekerjaan"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('pekerjaan') }"
                />
                <has-error :form="form" field="pekerjaan"></has-error>
              </div>
              <div class="form-group">
                <label> Status </label>
                <div class="input-group mb-3">
                  <select
                    id="inputGroupSelect02"
                    class="custom-select"
                    v-model="form.status"
                    type="text"
                    name="status"
                  >
                    <option selected>Choose...</option>
                    <option value="Sudah menikah">Sudah menikah</option>
                    <option value="Belum menikah">Belum menikah</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label> Motto </label>
                <input
                  v-model="form.motto"
                  type="text"
                  name="motto"
                  placeholder="Motto"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('motto') }"
                />
                <has-error :form="form" field="motto"></has-error>
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
                Save
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
      img: "/img/logo.png",
      user: {},
      users: [],
      roles: [],
      permissions: [],
      idRole: "",
      kamar: {},
      tahunMasuk: {},
      form: new Form({
        id: "",
        nama: "",
        tahun_masuk: "",
        tahun_keluar: "",
        no_hp: "",
        no_kamar: "",
        pekerjaan: "",
        status: "",
        motto: "",
        photo: "",
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

    searchKamar(nomor) {
      this.loading = true;
      axios
        .get("/alumni-kamar/search?s=" + nomor)
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

    searchTahun(nomor) {
      this.loading = true;
      axios
        .get("/alumni-tahun/search?s=" + nomor)
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
          this.idRole = response.data.idRole;
          this.kamar = response.data.kamar;
          this.tahunMasuk = response.data.tahun_masuk;
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
    onChangePage(pageOfItems) {
      this.pageOfItems = pageOfItems;
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
