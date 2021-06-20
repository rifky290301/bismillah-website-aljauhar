<template>
  <div class="">
    <div class="row">
      <div class="col-md-8">
        <div class="card" :class="!editMode ? 'card-primary' : 'card-success'">
          <div class="card-header">
            <h3 class="card-title" v-if="!editMode">Membuat Bertia</h3>
            <h3 class="card-title" v-if="editMode">Edit Bertia</h3>
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
                <textarea
                  id=""
                  cols="30"
                  rows="10"
                  v-model="form.isi"
                  type="text"
                  name="isi"
                  placeholder="Masukkan isi berita"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('isi') }"
                >
                </textarea>
                <has-error :form="form" field="isi"></has-error>
              </div>
              <div class="form-group">
                <input type="file" name="dokumentasi" @change="upload" />
              </div>
              <button
                type="submit"
                v-show="!editMode"
                class="btn btn-lg btn-primary"
              >
                Save
              </button>
              <button
                type="submit"
                v-show="editMode"
                class="btn btn-lg btn-success"
              >
                Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="row d-flex">
      <div class="col-md-6" v-for="berita in beritas" :key="berita.id">
        <div class="card card-secondary">
          <div class="card-header">
            <label> Judul </label>
            <p>{{ berita.judul }}</p>
          </div>
          <div class="card-body">
            <label> Isi </label>
            <p>{{ berita.isi }}</p>
          </div>

          <div class="card-footer">
            <div class="d-inline">{{ berita.created_by }}</div>
            <div class="d-inline float-right">
              <button
                class="btn btn-sm btn-warning text-white"
                @click="editBerita(berita)"
              >
                <i class="fa fa-edit"></i> Edit
              </button>
              <button
                class="btn btn-sm btn-danger text-white"
                @click="deleteArtikel(berita)"
              >
                <i class="fa fa-trash"></i> Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      berita: {},
      beritas: [],
      loading: false,
      editMode: false,
      dokumentasi: null,
      form: new Form({
        id: "",
        judul: "",
        isi: "",
        dokumentasi: "",
      }),
    };
  },
  methods: {
    upload(e) {
      let files = e.target.files[0];
      this.dokumentasi = files;
    },

    createMode() {
      this.editMode = false;
      this.form.reset();
    },

    createBerita() {
      this.form.append("dokumentasi", this.dokumentasi);
      console.log(this.form);
      // this.load = false;
      // this.form
      //   .post("/berita")
      //   .then((response) => {
      //     this.load = true;
      //     this.$toastr.s("Berita berhasil dibuat", "Created");
      //     Fire.$emit("loadUser");
      //     this.form.reset();
      //   })
      //   .catch(() => {
      //     this.load = true;
      //     this.$toastr.e("Gagal membuat berita, coba lagi", "Error");
      //   });
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
          this.$toastr.s("user information updated succefully", "Created");
          Fire.$emit("loadUser");
          this.form.reset();
        })
        .catch(() => {
          this.load = true;
          this.$toastr.e("Cannot update user information, try again", "Error");
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
          title: "Are you sure?",
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
  },
  created() {
    this.getBerita();
    Fire.$on("loadUser", () => {
      this.getBerita();
    });
  },
};
</script>