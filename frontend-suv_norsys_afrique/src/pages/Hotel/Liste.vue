<template>
  <div class="row">
    <div class="col-12">
      <card title="Liste des Hôtels">
        <p-button type="info" class="addbutton"
                  outline
                  @click.native.prevent="ajouterHotel">
          Ajouter Un Hôtel
        </p-button>
        <div class="table table-responsive">
          <table id="datatable">
            <thead>
            <tr>
              <th>#</th>
              <th>Nom</th>
              <th>Adresse</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="hotel in hotels" v-bind:key="hotel.id">
              <td>{{ hotel.id }}</td>
              <td>{{ hotel.nom }}</td>
              <td>{{ hotel.adresse }}</td>
              <td>
                <button class="btn btn-info btn-sm" @click="modifier(hotel.id)">
                  <i class="fa fa-edit"></i>
                </button>
                |
                <button class="btn btn-danger btn-sm" @click.prevent="supprimer(hotel.id)">
                  <i class="fa fa-trash"></i>
                </button>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </card>
    </div>
  </div>
</template>

<script>
import "jquery/dist/jquery.min.js";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";
import axios from "axios";
import NotificationTemplate from "@/pages/Notifications/NotificationTemplate";

export default {
  data() {
    return {
      hotels: []
    }
  },
  mounted() {
    this.getHotels()
  },
  methods: {
    datatable() {
      this.$nextTick(() => {
        $("#datatable").DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "filter": true,
          "autoWidth": false,
          "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
          },
          buttons: [
            "copy", "csv", "excel", "pdf", "print"
          ]
        })
      });
    },
    getHotels() {
      axios.get('/hotels').then((response) => {
        this.hotels = response.data
        this.datatable()
      })
    },
    ajouterHotel() {
      this.$router.push({path: '/hotel/ajouter'});
    },
    modifier(id) {
      this.$router.push("/hotel/modifier/" + id);
    },
    supprimer(id) {
      axios.delete("hotel/supprimer/" + id, id).then(response => {
        this.$router.go(0);
        this.$notify({
          title: 'hôtel supprimé avec succès',
          text: 'hôtel evenement supprimé avec succès',
          type: 'danger',
          template: NotificationTemplate,
          icon: 'fa fa-trash',
          horizontalAlign: 'center',
        })
      });
    }
  }
}
</script>

<style scoped>

</style>
