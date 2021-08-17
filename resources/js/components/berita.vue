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
                  placeholder="Masukkan judul artikel"
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
                <v-th sortKey="judul">Judul</v-th>
                <th>Artikel</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody slot="body" slot-scope="{ displayData }">
              <tr v-for="(row, index) in displayData" :key="row.id">
                <td>{{ index + 1 }}</td>

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

      form: new Form({
        id: "",
        judul: "",
        isi: "",
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
          this.load = true;
          this.$toastr.s("Berita berhasil diubah", "Created");
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
          title: "apakah kamu yakin?",
          text: berita.judul + "akan dihapus secara permanen!",
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
                this.$toastr.s("Berita berhasil dibuat", "Created");
                Fire.$emit("loadUser");
              })
              .catch(() => {
                this.$toastr.e("Gagal menghapus", "Error");
              });
          }
        });
    },
    onChangePage(pageOfItems) {
      this.pageOfItems = pageOfItems;
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