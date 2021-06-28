<template>
  <div class="">
    <div class="row">
      <div class="col-md-8">
        <div class="card" :class="!editMode ? 'card-primary' : 'card-success'">
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
      <div class="col-md-6" v-for="artikel in pageOfItems" :key="artikel.id">
        <div class="card card-secondary">
          <div class="card-header">
            <label> Judul </label>
            <p>{{ artikel.judul }}</p>
          </div>
          <div class="card-body">
            <label> Isi </label>
            <p v-html="artikel.isi"></p>
          </div>
          <div class="card-footer">
            <div class="d-inline">{{ artikel.created_by }}</div>
            <div class="d-inline float-right">
              <button
                class="btn btn-sm btn-warning text-white"
                @click="editArtikel(artikel)"
              >
                <i class="fa fa-edit"></i> Edit
              </button>
              <button
                class="btn btn-sm btn-danger text-white"
                @click="deleteArtikel(artikel)"
              >
                <i class="fa fa-trash"></i> Delete
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <center class="pb-0 pt-1">
      <jw-pagination
        :pageSize="4"
        :items="artikels"
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
      artikel: {},
      artikels: [],
      loading: false,
      editMode: false,
      isi: "",
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

    createArtikel() {
      this.action = "Creating user ...";
      this.load = false;
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
      this.loading = true;
      axios
        .get("/getAllArtikel")
        .then((response) => {
          this.loading = false;
          this.artikels = response.data.artikels;
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