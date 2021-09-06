<template>
  <div class="">
    <div class="row">
      <div class="col-md-12">
        <div
          class="card card-outline"
          :class="!editMode ? 'card-primary' : 'card-success'"
        >
          <div class="card-header">
            <h3 class="card-title" v-if="!editMode">Membuat Testimoni</h3>
            <h3 class="card-title" v-if="editMode">Edit Testimoni</h3>
          </div>

          <form
            @submit.prevent="!editMode ? createTestimoni() : updateTestimoni()"
          >
            <div class="card-body">
              <div class="form-group">
                <label> Nama </label>
                <input
                  v-model="form.nama"
                  type="text"
                  name="judul"
                  placeholder="Masukkan nama"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('nama') }"
                />
                <has-error :form="form" field="nama"></has-error>
              </div>
              <div class="form-group">
                <label> Testimoni </label>

                <ckeditor
                  v-model="form.testimoni"
                  value="Tulis testimoni"
                  aria-placeholder="Tulis testimoni"
                ></ckeditor>
                <has-error :form="form" field="testimoni"></has-error>
              </div>
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

    <div class="card">
      <div class="container-fluid">
        <div class="card-body table-responsive p-0">
          <v-table
            :data="testimonis"
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
                <th>Foto</th>
                <v-th sortKey="nama">Nama</v-th>
                <th>Testimoni</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody slot="body" slot-scope="{ displayData }">
              <tr v-for="(row, index) in displayData" :key="row.id">
                <td>{{ index + 1 }}</td>
                <td>
                  <img
                    :src="'upload/testimoni/' + row.photo"
                    style="height: 8rem"
                  />
                </td>
                <td>{{ row.nama }}</td>
                <td v-html="row.testimoni"></td>

                <td>
                  <div style="width: 9rem" class="">
                    <button
                      class="text-white btn btn-sm btn-warning"
                      @click="editTestimoni(row)"
                    >
                      <i class="fa fa-edit"></i>
                    </button>
                    <button
                      class="btn btn-sm btn-danger"
                      @click="deleteTestimoni(row)"
                    >
                      <i class="fa fa-trash"></i>
                    </button>
                    <button
                      class="btn btn-sm btn-success"
                      @click="upPhoto(row)"
                    >
                      <i class="fa fa-image"></i>
                    </button>
                    <button
                      class="btn btn-sm btn-primary"
                      @click="publisTestimoni(row)"
                    >
                      <i v-if="row.publish == false" class="fa fa-star"></i>
                      <i
                        v-if="row.publish == true"
                        class="fa fa-star text-warning"
                      ></i>
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
              Upload Foto Testimoni
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
                :action="/photo-testimoni/ + idTestimoni"
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
  </div>
</template>

<script>
export default {
  data() {
    return {
      // smart table
      dataPerPage: 5,
      currentPage: 1,
      totalPages: 0,
      // smart table
      pageOfItems: [],
      testimoni: {},
      testimonis: [],
      loading: false,
      editMode: false,
      idTestimoni: "",
      token: "",
      isi: "",
      form: new Form({
        id: "",
        nama: "",
        testimoni: "",
        publish: "",
      }),
      filters: {
        title: {
          value: "",
          keys: ["nama"],
        },
      },
    };
  },
  methods: {
    createMode() {
      this.editMode = false;
      this.form.reset();
    },

    createTestimoni() {
      this.form
        .post("/testimoni")
        .then((response) => {
          this.load = true;
          this.$toastr.s("testimoni berhasil dibuat", "Created");
          this.form.reset();
        })
        .catch(() => {
          this.load = true;
          this.$toastr.e("Cannot create user, try again", "Error");
        });
      this.getTestimoni();
    },

    editTestimoni(testimoni) {
      this.editMode = true;
      this.form.reset();
      this.form.fill(testimoni);
    },

    updateTestimoni() {
      this.form
        .put("/testimoni/" + this.form.id)
        .then((response) => {
          this.load = true;
          this.$toastr.s("Testimoni berhasil diubah", "Updated");
          Fire.$emit("loadUser");
          this.form.reset();
        })
        .catch(() => {
          this.load = true;
          this.$toastr.e("Tidak dapat mengupdate, coba lagi", "Error");
        });
      this.editMode = false;
    },

    getTestimoni() {
      this.loading = true;
      axios
        .get("/getAllTestimoni")
        .then((response) => {
          this.loading = false;
          this.testimonis = response.data.testimoni;
        })
        .catch(() => {
          this.loading = false;
          this.$toastr.e("Gagal mengambil data", "Error");
        });
    },

    deleteTestimoni(testimoni) {
      swal
        .fire({
          title: "Are you sure?",
          text: testimoni.nama + "akan dihapus secara permanen!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Delete",
        })
        .then((result) => {
          if (result.value) {
            axios
              .delete("/testimoni/" + testimoni.id)
              .then(() => {
                this.$toastr.s("testimoni berhasil dibuat", "Created");
                Fire.$emit("loadUser");
              })
              .catch(() => {
                this.$toastr.e("Gagal menghapus", "Error");
              });
          }
        });
    },

    publisTestimoni(row) {
      this.form.nama = row.nama;
      this.form.testimoni = row.testimoni;
      this.form.publish = !row.publish;
      this.form
        .put("/testimoni/" + row.id)
        .then((response) => {
          this.$toastr.s("Testimoni berhasil diubah", "Updated");
          Fire.$emit("loadUser");
          this.form.reset();
        })
        .catch(() => {
          this.$toastr.e("Tidak dapat di publish, coba lagi", "Error");
        });
    },
    onChangePage(pageOfItems) {
      this.pageOfItems = pageOfItems;
    },

    upPhoto(testimoni) {
      $("#uploadImg").modal("show");
      this.idTestimoni = testimoni.id;
      this.token = window.Laravel.csrfToken;
    },
  },
  created() {
    this.getTestimoni();
    Fire.$on("loadUser", () => {
      this.getTestimoni();
    });
  },
};
</script>