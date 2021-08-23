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

          <!-- <form @submit.prevent="createArtikel()"> -->
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
                <v-th sortKey="nama">Judul</v-th>
                <th>Artikel</th>
                <th v-show="idRole == 3">Dibuat</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody slot="body" slot-scope="{ displayData }">
              <tr v-for="(row, index) in displayData" :key="row.id">
                <td>{{ index + 1 }}</td>

                <td>{{ row.judul }}</td>
                <td v-html="row.isi"></td>
                <td v-show="idRole == 3">{{ row.user.name }}</td>

                <td>
                  <div style="width: 9rem" class="">
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
                    <button
                      class="btn btn-sm btn-primary"
                      @click="publisArtikel(row)"
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
      artikel: {},
      artikels: [],
      loading: false,
      editMode: false,
      idRole: "",
      isi: "",
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
          title: "Are you sure?",
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
          this.$toastr.s("Artikel telah di publish", "Updated");
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
  },
  created() {
    this.getArtikel();
    Fire.$on("loadUser", () => {
      this.getArtikel();
    });
  },
};
</script>