<template>
  <div class="">
    <div class="row">
      <div class="col-md-12">
        <div
          class="card card-outline"
          :class="!editMode ? 'card-primary' : 'card-success'"
        >
          <div class="card-header">
            <h3 class="card-title" v-if="!editMode">Membuat Berita</h3>
            <h3 class="card-title" v-if="editMode">Edit Berita</h3>
          </div>

          <form @submit.prevent="!editMode ? createBerita() : updateBerita()">
            <div class="card-body">
              <div class="form-group">
                <label> Judul </label>
                <input
                  v-model="form.judul"
                  type="text"
                  name="judul"
                  placeholder="Masukkan judul berita"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('judul') }"
                />
                <has-error :form="form" field="judul"></has-error>
              </div>
              <div class="form-group">
                <label> Isi </label>
                <ckeditor v-model="form.isi" value="Tulis biografi"></ckeditor>
                <has-error :form="form" field="isi"></has-error>
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
            :data="beritas"
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
                <th>Gambar</th>
                <v-th sortKey="judul">Judul</v-th>
                <th>Berita</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody slot="body" slot-scope="{ displayData }">
              <tr v-for="(row, index) in displayData" :key="row.id">
                <td>{{ index + 1 }}</td>

                <td>
                  <img
                    :src="'upload/berita/' + row.dokumentasi"
                    style="height: 8rem"
                  />
                </td>
                <td>{{ row.judul }}</td>
                <td v-html="row.isi"></td>
                <td>
                  <div style="width: 9rem" class="">
                    <button
                      class="text-white btn btn-sm btn-warning"
                      @click="editBerita(row)"
                    >
                      <i class="fa fa-edit"></i>
                    </button>
                    <button
                      class="btn btn-sm btn-danger"
                      @click="deleteBerita(row)"
                    >
                      <i class="fa fa-trash"></i>
                    </button>
                    <!-- <a
                      class="btn btn-sm text-white btn-info"
                      :href="'berita/edit/' + row.id"
                    >
                      <i class="fa fa-eye"></i>
                    </a> -->
                    <button
                      class="btn btn-sm btn-success"
                      @click="upPhoto(row)"
                    >
                      <i class="fa fa-image"></i>
                    </button>
                    <button
                      class="btn btn-sm btn-primary"
                      @click="publisBerita(row)"
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
              Upload Foto Berita
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
                :action="/photo-berita/ + idBerita"
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
      dataPerPage: 10,
      currentPage: 1,
      totalPages: 0,
      // smart table
      pageOfItems: [],
      berita: {},
      beritas: [],
      loading: false,
      editMode: false,
      gambarBerita: "",
      idBerita: "",
      token: "",
      form: new Form({
        id: "",
        judul: "",
        isi: "",
        publish: "",
      }),
      filters: {
        title: {
          value: "",
          keys: ["judul", "isi"],
        },
      },
    };
  },
  methods: {
    createMode() {
      this.editMode = false;
      this.form.reset();
    },

    createBerita() {
      this.form
        .post("/berita")
        .then((response) => {
          this.load = true;
          this.$toastr.s("Berita berhasil dibuat", "Created");
          Fire.$emit("loadUser");
          $("#createUser").modal("hide");
          this.form.reset();
        })
        .catch(() => {
          this.load = true;
          this.$toastr.e("gagal membuat berita, coba lagi", "Error");
        });
    },

    editBerita(berita) {
      this.editMode = true;
      this.form.reset();
      this.form.fill(berita);
    },

    updateBerita() {
      this.form
        .put("/berita/" + this.form.id)
        .then((response) => {
          this.$toastr.s("Berita berhasil diubah", "Updated");
          Fire.$emit("loadUser");
          this.form.reset();
        })
        .catch(() => {
          this.$toastr.e("Tidak dapat mengupdate, coba lagi", "Error");
        });
      this.editMode = false;
    },

    getBerita() {
      this.loading = true;
      axios
        .get("/getAllBerita")
        .then((response) => {
          this.loading = false;
          this.beritas = response.data.beritas;
        })
        .catch(() => {
          this.loading = false;
          this.$toastr.e("Gagal mengambil data", "Error");
        });
    },

    deleteBerita(berita) {
      swal
        .fire({
          title: "Apakah kamu yakin?",
          text: berita.judul + "akan dihapus!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Delete",
        })
        .then((result) => {
          if (result.value) {
            axios
              .delete("/berita/" + berita.id)
              .then(() => {
                this.$toastr.s("Berita berhasil dibuat", "Deleted");
                Fire.$emit("loadUser");
              })
              .catch(() => {
                this.$toastr.e("Gagal menghapus", "Error");
              });
          }
        });
    },

    publisBerita(row) {
      this.form.judul = row.judul;
      this.form.isi = row.isi;
      this.form.publish = !row.publish;
      this.form
        .put("/berita/" + row.id)
        .then((response) => {
          this.$toastr.s("Berita berhasil diubah", "Updated");
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

    upPhoto(berita) {
      $("#uploadImg").modal("show");
      this.idBerita = berita.id;
      this.token = window.Laravel.csrfToken;
    },
  },

  created() {
    this.getBerita();
    Fire.$on("loadUser", () => {
      this.getBerita();
    });
  },
};
</script>