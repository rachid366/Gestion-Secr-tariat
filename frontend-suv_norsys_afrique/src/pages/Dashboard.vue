<template>
  <div>
    <div class="row">
      <div class="col-md-3">
        <stats-card>
          <div class="icon-big text-center" slot="header" :class="`icon-${user.type}`">
            <i :class="user.icon"></i></div>
          <div class="numbers" slot="content">
            <p>{{user.title}}</p>
            {{nbUsers}}
          </div>
          <div class="stats row" slot="footer">
            <div class="col-md-6">
              <i :class="user.footerIcon"></i>
            </div>
            <div class="col-md-6 text-right">
              <router-link :to="{path:'/utilisateurs'}" style="color: #424141">
                {{user.footerText}}
              </router-link>
            </div>
          </div>
        </stats-card>
      </div>
      <div class="col-md-3">
        <stats-card>
          <div class="icon-big text-center" slot="header" :class="`icon-${client.type}`">
            <i :class="client.icon"></i></div>
          <div class="numbers" slot="content">
            <p>{{client.title}}</p>
            {{nbClients}}
          </div>
          <div class="stats row" slot="footer">
            <div class="col-md-6">
              <i :class="client.footerIcon"></i>
            </div>
            <div class="col-md-6 text-right">
              <router-link :to="{path:'/clientvisiteur'}" style="color: #424141">
                {{client.footerText}}
              </router-link>
            </div>
          </div>
        </stats-card>
      </div>
      <div class="col-md-3">
        <stats-card>
          <div class="icon-big text-center" slot="header" :class="`icon-${event.type}`">
            <i :class="event.icon"></i></div>
          <div class="numbers" slot="content">
            <p>{{event.title}}</p>
            {{nbEvents}}
          </div>
          <div class="stats row" slot="footer">
            <div class="col-md-6">
              <i :class="event.footerIcon"></i>
            </div>
            <div class="col-md-6 text-right">
              <router-link :to="{path:'/event'}" style="color: #424141">
                {{event.footerText}}
              </router-link>
            </div>
          </div>
        </stats-card>
      </div>
      <div class="col-md-3">
        <stats-card>
          <div class="icon-big text-center" slot="header" :class="`icon-${activite.type}`">
            <i :class="activite.icon"></i></div>
          <div class="numbers" slot="content">
            <p>{{activite.title}}</p>
            {{nbActivities}}
          </div>
          <div class="stats row" slot="footer">
            <div class="col-md-6">
              <i :class="activite.footerIcon"></i>
            </div>
            <div class="col-md-6 text-right">
              <router-link :to="{path:'/activites'}" style="color: #424141">
                {{activite.footerText}}
              </router-link>
            </div>
          </div>
        </stats-card>
      </div>
    </div>

    <!--Charts-->
    <div class="row">

      <div class="col-12">
      </div>

      <div class="col-md-6 col-12">
        <chart-card title="Nombre des événements"
                    sub-title="le pourcentage des événements selon le type"
                    :chart-data="eventType.data"
                    chart-type="Pie">
          <span slot="footer">
            <i class="ti-list"></i>
            <router-link :to="{path:'/event'}" style="color: #676363">
              Voir la liste des événements
            </router-link>
          </span>
          <div slot="legend">
            <i class="fa fa-circle text-info"></i> Campus
            <i class="fa fa-circle text-warning"></i> Visite Client
          </div>
        </chart-card>
      </div>
      <div class="col-md-6 col-12">
        <chart-card title="Activité / Collaborateur"
                    sub-title="Nombre de collaborateurs par activité"
                    :chart-data="activityUser.data"
                    :chart-options="activityUser.options"
                    chart-type="Bar">
          <span slot="footer">
            <i class="ti-list"></i>
            <router-link :to="{path:'/TAF'}" style="color: #676363">
              Voir la liste des activités finales
            </router-link>
          </span>
        </chart-card>
      </div>
      <div class="col-md-12">
        <chart-card title="Événements par mois"
                    sub-title="Nombre d'événements par mois"
                    :chart-data="activityChart.data"
                    :chart-options="activityChart.options"
        >
          <span slot="footer">
            <i class="ti-list"></i>
            <router-link :to="{path:'/event'}" style="color: #676363">
              Voir la liste des événements
            </router-link>
          </span>
          <div slot="legend">
            <i class="fa fa-circle text-info"></i> événments Campus
            <i class="fa fa-circle text-warning"></i> événments Visite Client
          </div>
        </chart-card>
      </div>

    </div>

  </div>
</template>
<script>
import { StatsCard, ChartCard } from "@/components/index";
import Chartist from 'chartist';
import axios from "axios";
export default {
  components: {
    StatsCard,
    ChartCard
  },
  /**
   * Chart data used to render stats, charts. Should be replaced with server data
   */
  beforeCreate() {
    if (localStorage.getItem("token") == null) {
      this.$router.push("/login");
    }
  },
  mounted() {
    this.getUtilisateurs();
    this.getEvenements();
    this.getActivities();
    this.getClients();
  },
  methods: {
    getUtilisateurs() {
      axios.get('/utilisateurs').then((response) => {
        this.utilisateurs = response.data
        this.nbUsers = this.utilisateurs.length
      })
    },
    getEvenements() {
      axios.get('/evenement/list').then((response) => {
        this.evenements = response.data
        this.nbEvents = this.evenements.length
        for (let i=0;i<this.evenements.length;i++){
          if (this.evenements[i].Type.nom === 'Campus'){
            this.campus.push(this.evenements[i])
          }
          else if (this.evenements[i].Type.nom === 'Visite Client'){
            this.visiteClient.push(this.evenements[i])
          }
        }
        this.nbCampus = this.campus.length
        this.nbVisite = this.visiteClient.length
        console.log(this.eventType.data.series)
      })
    },
    getActivities() {
      axios.get('/activites').then((response) => {
        this.activities = response.data
        this.nbActivities = this.activities.length
      })
    },
    getClients() {
      axios.get('clientvisiteur/liste').then((response) => {
        this.clients = response.data
        this.nbClients =  this.clients.length
      })
    }
  },
  data() {
    let campus = [];
    let visiteClient = [];
    return {
      data: [1.2],
      campus,
      visiteClient,
      clients:[],
      activities: [],
      evenements: [],
      utilisateurs: [],
      nbUsers: "",
      nbEvents: "",
      nbActivities: "",
      nbClients: "",
      nbCampus: "",
      nbVisite: "",
      user: {
        title: "Nombre des Collaborateurs",
        icon: "ti-user",
        type: "success",
        footerText: "Voir la liste",
        footerIcon: "ti-list"
      },
      event: {
        title: "Nombre des événements",
        icon: "ti-calendar",
        type: "warning",
        footerText: "Voir la liste",
        footerIcon: "ti-list"
      },
      activite: {
        title: "Nombre des activités",
        icon: "ti-medall",
        type: "info",
        footerText: "Voir la liste",
        footerIcon: "ti-list"
      },
      client: {
        title: "Nombre des clients",
        icon: "ti-stats-up",
        type: "danger",
        footerText: "Voir la liste",
        footerIcon: "ti-list"
      },

      eventType: {
        data: {
          labels: ["33,33%", "66,66%"],
          series: [1, 2]
        },
        options: {}
      },
      activityChart: {
        data: {
          labels: [
            "Janvier",
            "Février",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juillet",
            "Août",
            "Septembre",
            "Octobre",
            "Novembre",
            "Décembre"
          ],
          series: [
            [ , , 1],
            [, , , , , 2, , , , , , ]
          ]
        },
        options: {
          seriesBarDistance: 10,
          axisX: {
            showGrid: false
          },
          height: "245px"
        }
      },
      activityUser: {
        data: {
          labels: [
           "activité XXX",
            "activité YYY",
            "activité ZZZ"
          ],
          series: [
            [2, 2 , 3]
          ]
        },
        options: {
          seriesBarDistance: 10,
          axisX: {
            showGrid: false
          },
          height: "245px",
        }
      },
     };
  }
};
</script>
<style>
</style>
