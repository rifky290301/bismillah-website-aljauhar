<template>
  <div class="">
    <div class="row">
      <div class="col-md-8">
        <div class="card" :class="!editMode ? 'card-primary' : 'card-success'">
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
                <froala
                  id=""
                  :tag="'textarea'"
                  :config="config"
                  cols="30"
                  rows="10"
                  v-model="form.isi"
                  type="text"
                  name="isi"
                  placeholder="Masukkan isi artikel"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('isi') }"
                >
                </froala>
                <has-error :form="form" field="isi"></has-error>
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
      <div class="col-md-6" v-for="berita in pageOfItems" :key="berita.id">
        <div class="card card-secondary">
          <div class="card-header">
            <label> Judul </label>
            <p>{{ berita.judul }}</p>
          </div>
          <div class="card-body">
            <label> Isi </label>
            <p v-html="berita.isi"></p>
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
                @click="deleteBerita(berita)"
              >
                <i class="fa fa-trash"></i> Delete
              </button>
              <!-- <a class="btn btn-sm btn-secondary text-white" :href="'berita/edit/' + berita.id"> -->
              <a
                :href="'berita/edit/' + berita.id"
                class="btn btn-sm btn-secondary text-white"
              >
                <i class="fa fa-image"></i>
                <span v-if="!berita.dokumentasi">Tambah Gambar</span>
                <span v-else>Lihat Berita</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <center class="pb-0 pt-1">
      <jw-pagination
        :pageSize="4"
        :items="beritas"
        @changePage="onChangePage"
        :labels="customLabels"
      ></jw-pagination>
    </center>
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
      berita: {},
      beritas: [],
      loading: false,
      editMode: false,

      form: new Form({
        id: "",
        judul: "",
        isi: "",
      }),

      config: {
        placeholder: "Edit Me",
        events: {
          "froalaEditor.focus": function (e, editor) {
            console.log(editor.selection.get());
          },
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
      this.load = false;
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
          this.load = true;
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