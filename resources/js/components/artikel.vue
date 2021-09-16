<template>
  <div class="">
    <div class="row">
      <div class="col-md-12">
        <div
          class="card card-outline"
          :class="!editMode ? 'card-primary' : 'card-success'"
        >
          <div class="card-header">
            <h3 class="card-title" v-if="!editMode">Membuat artikel</h3>
            <h3 class="card-title" v-if="editMode">Edit Artikel</h3>
          </div>

          <form @submit.prevent="!editMode ? createArtikel() : updateArtikel()">
            <div class="card-body">
              <div class="form-group">
                <label> Judul </label>
                <input
                  v-model="form.judul"
                  type="text"
                  name="judul"
                  placeholder="Masukkan judul artikel"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('judul') }"
                />
                <has-error :form="form" field="judul"></has-error>
              </div>
              <div class="form-group" v-show="idRole == 3">
                <label>Stataus</label>
                <div class="input-group mb-3">
                  <select
                    class="custom-select"
                    id="inputGroupSelect01"
                    v-model="form.publish"
                  >
                    <option value="" selected disabled>--pilih status--</option>
                    <option value="faforit">Terkini</option>
                    <option value="publish">Publish</option>
                    <option value="not">Not publish</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label> Isi </label>
                <div class="row">
                  <div class="col-md-8">
                    <ckeditor
                      v-model="form.isi"
                      value="Tulis biografi"
                    ></ckeditor>
                    <has-error :form="form" field="isi"></has-error>
                  </div>
                  <div v-if="!editMode" class="col-md-4">
                    <img
                      src="img/default-image.png"
                      class="img-fluid"
                      alt="Artikel AL JAUHAR"
                    />
                  </div>
                  <div v-else class="col-md-4">
                    <div v-if="gambarArtikel.gambar">
                      <div class="custom-image-hover">
                        <img
                          :src="'upload/gambar-artikel/' + gambarArtikel.gambar"
                          class="img-fluid"
                          alt="Artikel AL JAUHAR"
                        />
                        <button
                          type="button"
                          class="btn btn-success"
                          @click="upGambar(gambarArtikel)"
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
                          :action="/gambar-artikel/ + gambarArtikel.id"
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
            :data="artikels"
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
                <th v-show="idRole == 3">Dibuat</th>
                <th v-show="idRole == 3">Status</th>
                <th style="min-width: 13cm">Artikel</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody slot="body" slot-scope="{ displayData }">
              <tr v-for="(row, index) in displayData" :key="row.id">
                <td>{{ index + 1 }}</td>
                <td>
                  <img
                    :src="'upload/gambar-artikel/' + row.gambar"
                    style="width: 9rem"
                  />
                </td>
                <td>{{ row.judul }}</td>
                <td v-show="idRole == 3">{{ row.user.name }}</td>
                <td v-show="idRole == 3">{{ row.publish }}</td>
                <td v-html="row.isi"></td>

                <td>
                  <div style="width: 5rem" class="">
                    <button
                      class="text-white btn btn-sm btn-warning"
                      @click="editArtikel(row)"
                    >
                      <i class="fa fa-edit"></i>
                    </button>
                    <button
                      class="btn btn-sm btn-danger"
                      @click="deleteArtikel(row)"
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
              Upload gambar artikel
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
                :action="/gambar-artikel/ + idArtikel"
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
      artikel: {},
      artikels: [],
      loading: false,
      editMode: false,
      idRole: "",
      idArtikel: "",
      isi: "",
      gambarArtikel: "",
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
          keys: ["judul"],
        },
      },
    };
  },
  methods: {
    createMode() {
      this.editMode = false;
      this.form.reset();
    },

    createArtikel() {
      this.form
        .post("/artikel")
        .then((response) => {
          this.load = true;
          this.$toastr.s("Artikel berhasil dibuat", "Created");
          Fire.$emit("loadUser");
          $("#createUser").modal("hide");
          this.form.reset();
        })
        .catch(() => {
          this.load = true;
          this.$toastr.e("Cannot create user, try again", "Error");
        });
    },

    editArtikel(artikel) {
      this.editMode = true;
      this.form.reset();
      this.form.fill(artikel);
      this.gambarArtikel = artikel;
      this.token = window.Laravel.csrfToken;
    },

    updateArtikel() {
      this.form
        .put("/artikel/" + this.form.id)
        .then((response) => {
          this.load = true;
          this.$toastr.s("Artikel berhasil diubah", "Updated");
          Fire.$emit("loadUser");
          this.form.reset();
        })
        .catch(() => {
          this.load = true;
          this.$toastr.e("Tidak dapat mengupdate, coba lagi", "Error");
        });
      this.editMode = false;
    },

    getArtikel() {
      axios
        .get("/getAllArtikel")
        .then((response) => {
          this.loading = false;
          this.artikels = response.data.artikels;
          this.idRole = response.data.idRole;
        })
        .catch(() => {
          this.loading = false;
          this.$toastr.e("Gagal mengambil data", "Error");
        });
    },

    deleteArtikel(artikel) {
      swal
        .fire({
          title: "Apakah kamu yakin?",
          text: artikel.judul + "akan dihapus secara permanen!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Delete",
        })
        .then((result) => {
          if (result.value) {
            axios
              .delete("/artikel/" + artikel.id)
              .then(() => {
                this.$toastr.s("Artikel berhasil dibuat", "Created");
                Fire.$emit("loadUser");
              })
              .catch(() => {
                this.$toastr.e("Gagal menghapus", "Error");
              });
          }
        });
    },

    publisArtikel(row) {
      this.form.judul = row.judul;
      this.form.isi = row.isi;
      this.form.publish = !row.publish;
      this.form
        .put("/artikel/" + row.id)
        .then((response) => {
          this.$toastr.s("Artikel telah diubah", "Updated");
          Fire.$emit("loadUser");
          this.form.reset();
        })
        .catch(() => {
          this.$toastr.e("Tidak dapat mempublish, coba lagi", "Error");
        });
    },

    onChangePage(pageOfItems) {
      this.pageOfItems = pageOfItems;
    },

    upGambar(artikel) {
      $("#uploadImg").modal("show");
      this.idArtikel = artikel.id;
      this.token = window.Laravel.csrfToken;
    },
  },
  created() {
    this.getArtikel();
    Fire.$on("loadUser", () => {
      this.getArtikel();
    });
  },
};
</script>