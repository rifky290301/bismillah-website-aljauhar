<template>
  <div class="p-0">
    <div class="card">
      <div class="card-header ui-sortable-handle" style="cursor: move">
        <h3 class="card-title">
          <i class="fas fa-users mr-1"></i>
          Data Santri Sekarang
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
      <div class="card-body table-responsive p-0">
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
              <v-th sortKey="nama" defaultSort="asc">Nama</v-th>
              <v-th sortKey="no_hp">Nomor HP</v-th>
              <v-th sortKey="tahun_masuk">Masuk</v-th>
              <v-th sortKey="no_kamar">Kamar</v-th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody slot="body" slot-scope="{ displayData }">
            <tr v-for="(user, index) in displayData" :key="user.id">
              <!-- <tr v-for="(number, item) in users | filterBy nama in 'nama' | limitBy count offset" :key="user.id"> -->
              <td>{{ index + 1 }}</td>
              <td>
                <img
                  :src="'upload/santri/' + user.photo"
                  style="height: 30px"
                />
              </td>
              <td>{{ user.nama }}</td>
              <td>{{ user.no_hp }}</td>
              <td>{{ user.tahun_masuk }}</td>
              <td>{{ user.no_kamar }}</td>
              <td>
                <div style="width: 9rem" class="">
                  <button
                    class="text-white btn btn-sm btn-warning"
                    v-show="idRole != 3"
                    @click="editUser(user)"
                  >
                    <i class="fa fa-edit"></i>
                  </button>
                  <button
                    v-show="idRole != 3"
                    class="btn btn-sm btn-danger"
                    @click="deleteUser(user)"
                  >
                    <i class="fa fa-trash"></i>
                  </button>
                  <button
                    class="text-white btn btn-sm btn-info"
                    @click="viewUser(user)"
                  >
                    <i class="fa fa-eye"></i>
                  </button>
                  <button
                    v-show="idRole != 3"
                    class="btn btn-sm btn-success"
                    @click="upPhoto(user)"
                  >
                    <i class="fa fa-image"></i>
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
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="uploadImg"
      tabindex="-1"
      role="dialog"
      aria-labelledby="viewUserModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Upload Foto Alumni
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
          <div class="modal-body">
            <template>
              <Upload
                multiple
                type="drag"
                :action="/photo-santri/ + idUser"
                :headers="{ 'x-csrf-token': token }"
                name="photo"
              >
                <div style="padding: 20px 0">
                  <Icon
                    type="ios-cloud-upload"
                    size="52"
                    style="color: #3399ff"
                  ></Icon>
                  <p>Click or drag files here to upload</p>
                </div>
              </Upload>
            </template>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
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
                <li><b>Nomor HP</b> {{ user.no_hp }}</li>
                <li><b>Nomor Kamar</b> {{ user.no_kamar }}</li>
                <li><b>Status</b> {{ user.status }}</li>
                <li><b>Instanasi</b> {{ user.instansi }}</li>
                <li><b>Prodi</b> {{ user.prodi }}</li>
                <li><b>Alamat</b> {{ user.alamat }}</li>
                <li><b>Tahun Masuk</b> {{ user.tahun_masuk }}</li>
              </div>

              <div class="">
                <img :src="img" class="img-thumbnail" />
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
              Tambahkan Data Santri Sekarang
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
                <label> Status </label>
                <div class="input-group mb-3">
                  <select
                    id="inputGroupSelect02"
                    class="custom-select"
                    v-model="form.status"
                    type="text"
                    name="status"
                  >
                    <option selected disabled>Choose...</option>
                    <option value="sekolah">sekolah</option>
                    <option value="kuliah">kuliah</option>
                    <option value="kerja">kerja</option>
                    <option value="mencari pekerjaan">mencari pekerjaan</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label> Instansi </label>
                <input
                  v-model="form.instansi"
                  type="text"
                  name="instansi"
                  placeholder="Instansi"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('instansi') }"
                />
                <has-error :form="form" field="instansi"></has-error>
              </div>
              <div class="form-group">
                <label> Prodi </label>
                <input
                  v-model="form.prodi"
                  type="text"
                  name="prodi"
                  placeholder="Prodi"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('prodi') }"
                />
                <has-error :form="form" field="prodi"></has-error>
              </div>
              <div class="form-group">
                <label> Alamat </label>
                <input
                  v-model="form.alamat"
                  type="text"
                  name="alamat"
                  placeholder="Alamat"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('alamat') }"
                />
                <has-error :form="form" field="alamat"></has-error>
              </div>
              <div class="form-group">
                <label> Tanggal Masuk </label>
                <input
                  v-model="form.tahun_masuk"
                  type="date"
                  name="tahun_masuk"
                  placeholder="Tahun Masuk"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('tahun_masuk') }"
                />
                <has-error :form="form" field="tahun_masuk"></has-error>
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
      idRole: "",
      tahunMasuk: {},
      token: "",
      idUser: "",
      form: new Form({
        id: "",
        nama: "",
        no_hp: "",
        no_kamar: "",
        status: "",
        instansi: "",
        prodi: "",
        alamat: "",
        tahun_masuk: "",
      }),
      filters: {
        title: {
          value: "",
          keys: [
            "nama",
            "no_hp",
            "no_kamar",
            "status",
            "instansi",
            "prodi",
            "alamat",
            "tahun_masuk",
          ],
        },
      },
    };
  },
  methods: {
    dataPerHalaman(input) {
      this.dataPerPage = input;
    },
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
      this.token = window.Laravel.csrfToken;
      this.editMode = false;
      $("#createUser").modal("show");
      this.form.reset();
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
              .delete("/santri/" + user.id)
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
        .get("/getAllsantri")
        .then((response) => {
          this.loading = false;
          this.users = response.data.santri;
          this.idRole = response.data.idRole;
          // this.tahunMasuk = response.data.tahun_masuk;
        })
        .catch(() => {
          this.loading = false;
          this.$toastr.e("Cannot load users", "Error");
        });
    },
    viewUser(user) {
      $("#viewUser").modal("show");
      if (user.photo == null) {
        this.img = baseUrl + "/img/default-image.png";
      } else {
        this.img = baseUrl + "/upload/santri/" + user.photo;
      }
      this.user = user;
    },

    createUser() {
      this.form
        .post("/santri")
        .then((response) => {
          this.load = true;
          this.$toastr.s("Data santri berhasil ditambahkan", "Created");
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
      this.form
        .put("/santri/" + this.form.id)
        .then((response) => {
          this.load = true;
          this.$toastr.s("Data berhasil di ubah", "Updated");
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

    upPhoto(user) {
      $("#uploadImg").modal("show");
      this.idUser = user.id;
      this.token = window.Laravel.csrfToken;
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
