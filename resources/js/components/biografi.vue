<template>
  <div class="">
    <div class="row">
      <div class="col-md-12">
        <div
          class="card card-outline"
          :class="!editMode ? 'card-primary' : 'card-success'"
        >
          <div class="card-header">
            <h3 class="card-title" v-if="!editMode">Membuat Biografi</h3>
            <h3 class="card-title" v-if="editMode">Edit Biografi</h3>
          </div>

          <form
            @submit.prevent="!editMode ? createBiografi() : updateBiografi()"
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
                <label> Jabatan </label>
                <input
                  v-model="form.jabatan"
                  type="text"
                  name="jabatan"
                  placeholder="Masukkan jabatan"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('jabatan') }"
                />
                <has-error :form="form" field="jabatan"></has-error>
              </div>
              <div class="form-group">
                <label> Biografi </label>
                <div class="row">
                  <div class="col-md-8">
                    <ckeditor
                      v-model="form.biografi"
                      value="Tulis biografi"
                      aria-placeholder="Tulis biografi"
                    ></ckeditor>
                    <has-error :form="form" field="biografi"></has-error>
                  </div>
                  <div v-if="!editMode" class="col-md-4">
                    <img
                      src="img/default-image.png"
                      class="img-fluid"
                      alt="biografi AL JAUHAR"
                    />
                  </div>
                  <div v-else class="col-md-4">
                    <div v-if="gambarBiografi.photo">
                      <div class="custom-image-hover">
                        <img
                          :src="'upload/biografi/' + gambarBiografi.photo"
                          class="img-fluid"
                          alt="biografi AL JAUHAR"
                        />
                        <button
                          type="button"
                          class="btn btn-success"
                          @click="upPhoto(gambarBiografi)"
                        >
                          Ubah gambar
                        </button>
                      </div>
                    </div>
                    <div v-else>
                      <template>
                        <Upload
                          multiple
                          type="drag"
                          :action="/photo-biografi/ + gambarBiografi.id"
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
                  </div>
                </div>
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
            :data="biografis"
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
                <v-th sortKey="jabatan">Jabatan</v-th>
                <th style="min-width: 13cm">Biografi</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody slot="body" slot-scope="{ displayData }">
              <tr v-for="(row, index) in displayData" :key="row.id">
                <td>{{ index + 1 }}</td>
                <td>
                  <img
                    :src="'upload/biografi/' + row.photo"
                    style="width: 9rem"
                  />
                </td>
                <td>{{ row.nama }}</td>
                <td>{{ row.jabatan }}</td>
                <td v-html="row.biografi"></td>

                <td>
                  <div style="width: 6.5rem" class="">
                    <button
                      class="text-white btn btn-sm btn-warning"
                      @click="editBiografi(row)"
                    >
                      <i class="fa fa-edit"></i>
                    </button>
                    <button
                      class="btn btn-sm btn-danger"
                      @click="deleteBiografi(row)"
                    >
                      <i class="fa fa-trash"></i>
                    </button>
                    <button
                      class="btn btn-sm btn-primary"
                      @click="publisBiografi(row)"
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
              Upload Foto Biografi
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
                :action="/photo-biografi/ + idBiografi"
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
      biografi: {},
      biografis: [],
      loading: false,
      editMode: false,
      isi: "",
      gambarBiografi: "",
      idBiografi: "",
      token: "",
      form: new Form({
        id: "",
        nama: "",
        biografi: "",
        jabatan: "",
        publish: "",
      }),
      filters: {
        title: {
          value: "",
          keys: ["nama", "jabatan", "biografi"],
        },
      },
    };
  },
  methods: {
    createMode() {
      this.editMode = false;
      this.form.reset();
    },

    createBiografi() {
      this.form
        .post("/biografi")
        .then((response) => {
          this.load = true;
          this.$toastr.s("Biografi berhasil dibuat", "Created");
          this.form.reset();
        })
        .catch(() => {
          this.load = true;
          this.$toastr.e("Cannot create user, try again", "Error");
        });
      this.getBiografi();
    },

    editBiografi(biografi) {
      this.editMode = true;
      this.form.reset();
      this.form.fill(biografi);
      this.gambarBiografi = biografi;
      this.token = window.Laravel.csrfToken;
    },

    updateBiografi() {
      this.form
        .put("/biografi/" + this.form.id)
        .then((response) => {
          this.load = true;
          this.$toastr.s("Biografi berhasil diubah", "Updated");
          Fire.$emit("loadUser");
          this.form.reset();
        })
        .catch(() => {
          this.load = true;
          this.$toastr.e("Tidak dapat mengupdate, coba lagi", "Error");
        });
      this.editMode = false;
    },

    getBiografi() {
      this.loading = true;
      axios
        .get("/getAllBiografi")
        .then((response) => {
          this.loading = false;
          this.biografis = response.data.biografis;
        })
        .catch(() => {
          this.loading = false;
          this.$toastr.e("Gagal mengambil data", "Error");
        });
    },

    deleteBiografi(biografi) {
      swal
        .fire({
          title: "Apakah kamu yakin?",
          text: biografi.nama + "akan dihapus secara permanen!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Delete",
        })
        .then((result) => {
          if (result.value) {
            axios
              .delete("/biografi/" + biografi.id)
              .then(() => {
                this.$toastr.s("Biografi berhasil dibuat", "Created");
                Fire.$emit("loadUser");
              })
              .catch(() => {
                this.$toastr.e("Gagal menghapus", "Error");
              });
          }
        });
    },

    publisBiografi(row) {
      this.form.nama = row.nama;
      this.form.jabatan = row.jabatan;
      this.form.biografi = row.biografi;
      this.form.publish = !row.publish;
      this.form
        .put("/biografi/" + row.id)
        .then((response) => {
          this.$toastr.s("Biografi berhasil diubah", "Updated");
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

    upPhoto(biografi) {
      $("#uploadImg").modal("show");
      this.idBiografi = biografi.id;
      this.token = window.Laravel.csrfToken;
    },
  },
  created() {
    this.getBiografi();
    Fire.$on("loadUser", () => {
      this.getBiografi();
    });
  },
};
</script>