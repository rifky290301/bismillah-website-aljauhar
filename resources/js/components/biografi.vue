<template>
  <div class="">
    <div class="row">
      <div class="col-md-8">
        <div class="card" :class="!editMode ? 'card-primary' : 'card-success'">
          <div class="card-header">
            <h3 class="card-title" v-if="!editMode">Membuat Biografi</h3>
            <h3 class="card-title" v-if="editMode">Edit Biografi</h3>
          </div>

          <!-- <form @submit.prevent="createArtikel()"> -->
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
                <froala
                  id=""
                  :tag="'textarea'"
                  :config="config"
                  cols="30"
                  rows="10"
                  v-model="form.biografi"
                  type="text"
                  name="isi"
                  placeholder="Masukkan isi biografi"
                  class="form-control"
                  :class="{ 'is-invaild': form.errors.has('biografi') }"
                >
                </froala>
                <has-error :form="form" field="biografi"></has-error>
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
      <div class="col-md-6" v-for="biografi in pageOfItems" :key="biografi.id">
        <div class="card card-secondary">
          <div class="card-header">
            <label> Nama </label>
            <p>{{ biografi.nama }}</p>
          </div>
          <div class="card-body">
            <label> Biografi </label>
            <p v-html="biografi.biografi"></p>
          </div>
          <div class="card-footer">
            <div class="d-inline">{{ biografi.created_by }}</div>
            <div class="d-inline float-right">
              <button
                class="btn btn-sm btn-warning text-white"
                @click="editBiografi(biografi)"
              >
                <i class="fa fa-edit"></i> Edit
              </button>
              <button
                class="btn btn-sm btn-danger text-white"
                @click="deleteBiografi(biografi)"
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
        :items="biografis"
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

    createBiografi() {
      this.action = "Creating user ...";
      this.load = false;
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