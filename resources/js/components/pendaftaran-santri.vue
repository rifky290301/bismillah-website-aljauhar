<template>
  <div class="p-0">
    <div class="card">
      <div class="card-header ui-sortable-handle" style="cursor: move">
        <h3 class="card-title">
          <i class="fas fa-user-plus mr-1"></i>
          Pendaftaran Santri
        </h3>
        <div class="float-right">
          <template v-if="loading">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              style="
                margin: auto;
                background: none;
                display: block;
                shape-rendering: auto;
              "
              width="30px"
              height="30px"
              viewBox="0 0 100 100"
              preserveAspectRatio="xMidYMid"
            >
              <circle
                cx="50"
                cy="50"
                r="32"
                stroke-width="8"
                stroke="#4b79dc"
                stroke-dasharray="50.26548245743669 50.26548245743669"
                fill="none"
                stroke-linecap="round"
              >
                <animateTransform
                  attributeName="transform"
                  type="rotate"
                  dur="1s"
                  repeatCount="indefinite"
                  keyTimes="0;1"
                  values="0 50 50;360 50 50"
                ></animateTransform>
              </circle>
              <circle
                cx="50"
                cy="50"
                r="23"
                stroke-width="8"
                stroke="#6ac2f8"
                stroke-dasharray="36.12831551628262 36.12831551628262"
                stroke-dashoffset="36.12831551628262"
                fill="none"
                stroke-linecap="round"
              >
                <animateTransform
                  attributeName="transform"
                  type="rotate"
                  dur="1s"
                  repeatCount="indefinite"
                  keyTimes="0;1"
                  values="0 50 50;-360 50 50"
                ></animateTransform>
              </circle>
            </svg>
          </template>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Status</th>
              <th>Nomor HP</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, index) in pendaftar" :key="user.id">
              <td>{{ index + 1 }}</td>
              <td>{{ user.nama_lengkap }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.status }}</td>
              <td>{{ user.no_telepon }}</td>
              <td>
                <button
                  class="text-white btn btn-sm btn-info"
                  @click="viewUser(user)"
                >
                  <i class="fa fa-eye"></i>
                </button>
                <button
                  v-show="idRole != 3"
                  class="btn btn-sm btn-danger"
                  @click="deleteUser(user)"
                >
                  <i class="fa fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div
      class="modal fade"
      id="viewUser"
      tabindex="-1"
      role="dialog"
      aria-labelledby="viewUserModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row p-2">
              <div class="col-md-12 alignMe mb-3">
                <li><b>Nama</b> {{ user.nama_lengkap }}</li>
                <li><b>Nama panggilan</b> {{ user.nama_panggilan }}</li>
                <li><b>Tempat lahir</b> {{ user.tempat_lahir }}</li>
                <li><b>Tanggal lahir</b> {{ user.tanggal_lahir }}</li>
                <li><b>Email</b> {{ user.email }}</li>
                <li><b>Status</b> {{ user.status }}</li>
                <li><b>Instansi</b> {{ user.tempat_status }}</li>
                <li><b>Orang Tua/Wali</b> {{ user.orang_tua_wali }}</li>
                <li>
                  <b>Pekerjaan Orang Tua/Wali</b>
                  {{ user.pekerjaan_orang_tua_wali }}
                </li>
                <li><b>Desa Kelurahan</b> {{ user.desa_kelurahan }}</li>
                <li><b>Kecamatan</b> {{ user.kecamatan }}</li>
                <li><b>Kabupaten/Kota</b> {{ user.kabupaten_kota }}</li>
                <li><b>Kodepos</b> {{ user.kodepos }}</li>
                <li><b>Nomer Telepon</b> {{ user.no_telepon }}</li>
                <li>
                  <b>Nomor Telepon Keluarga</b> {{ user.no_telepon_keluarga }}
                </li>
                <li>
                  <b>Ukuran Jas Almamater</b> {{ user.ukuran_jas_almamater }}
                </li>
              </div>

              <div class="col-md-6">
                <img :src="img_foto" class="img-thumbnail" />
              </div>

              <div class="col-md-6">
                <img :src="img_bukti" class="img-thumbnail" />
              </div>
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
    // untuk loading pada tombol
    return {
      loading: false,
      img_foto: "",
      img_bukti: "",
      user: {},
      pendaftar: [],
    };
  },

  methods: {
    deleteUser(user) {
      this.loading = true;
      swal
        .fire({
          title: "Apakah kamu yakin?",
          text: user.nama_lengkap + " akan dihapus secara permanen!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.value) {
            axios
              .delete("/pendaftar/" + user.id)
              .then(() => {
                this.$toastr.s("Data berhasil dihapus", "Delete");
                Fire.$emit("loadUser");
              })
              .catch(() => {
                toast.fire({
                  icon: "error",
                  title:
                    user.nama_lengkap +
                    " was unable to be remove, tyr again later",
                });
              });
          }
          this.loading = false;
          this.getPendaftar();
        });
    },

    getPendaftar() {
      axios
        .get("/getAllPendaftar")
        .then((response) => {
          this.pendaftar = response.data.pendaftaranSantri;
          // console.log(this.pendaftar);
        })
        .catch(() => {
          this.$toastr.e("Cannot load users", "Error");
        });
    },
    viewUser(user) {
      $("#viewUser").modal("show");
      if (user.pas_foto == null) {
        this.img_foto = baseUrl + "/img/default-image.png";
      } else {
        this.img_foto = baseUrl + "/upload/pendaftar/" + user.pas_foto;
      }
      if (user.bukti_pembayaran == null) {
        this.img_bukti = baseUrl + "/img/default-image.png";
      } else {
        this.img_bukti =
          baseUrl + "/upload/pembayaran/" + user.bukti_pembayaran;
      }
      this.user = user;
    },
  },

  created() {
    Fire.$on("loadUser", () => {});
    this.getPendaftar();
  },
};
</script>

<style>
.left-column {
  text-align: right;
  font-weight: bold;
}
</style>