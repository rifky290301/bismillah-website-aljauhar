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
                <label> Biografi </label>

                <ckeditor
                  v-model="form.biografi"
                  value="Tulis biografi"
                  aria-placeholder="Tulis biografi"
                ></ckeditor>
                <has-error :form="form" field="biografi"></has-error>
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
                <v-th sortKey="nama">Nama</v-th>
                <th>Biografi</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody slot="body" slot-scope="{ displayData }">
              <tr v-for="(row, index) in displayData" :key="row.id">
                <td>{{ index + 1 }}</td>

                <td>{{ row.nama }}</td>
                <td v-html="row.biografi"></td>

                <td>
                  <div style="width: 9rem" class="">
                    <button
                      class="text-white btn btn-sm btn-warning"
                      v-show="idRole != 3"
                      @click="editBiografi(row)"
                    >
                      <i class="fa fa-edit"></i>
                    </button>
                    <button
                      v-show="idRole != 3"
                      class="btn btn-sm btn-danger"
                      @click="deleteBiografi(row)"
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
      form: new Form({
        id: "",
        nama: "",
        biografi: "",
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
          title: "Are you sure?",
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
    onChangePage(pageOfItems) {
      this.pageOfItems = pageOfItems;
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