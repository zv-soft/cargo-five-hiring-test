<template>
<v-app>
    <v-overlay :value="loader">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <MenuDrawer></MenuDrawer>
        <v-col
        ><v-card :color="colorBase" class="pa-10 white--text d-flex justify-end"
          ><h1>Lista de Contratos</h1></v-card
        >
      </v-col>
<v-container>

    <v-card-title>
        <v-row class="d-flex justify-content-end">
        <v-card class=" pa-4" color="transparent" elevation="0" width="400" >

      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        solo
        single-line
        hide-details
      ></v-text-field>
        </v-card>
        </v-row>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="contract"
      :search="search"
    >
    <template v-slot:[`item.actions`]="{item}">
        <router-link
        :to="'/ViewContract/'+item.id"
        >
       <v-btn class="primary">Ver Detalles <v-icon>mdi-eye</v-icon></v-btn>
        </router-link>
    </template>

    </v-data-table>
</v-container>
</v-app>

</template>
<script>
    import MenuDrawer from "../Components/Dreawer.vue";
    import { mapGetters } from "vuex";
export default {
    components:{
        MenuDrawer,
    },

    data() {
    return {
            loader:false,
            colorBase: "#031a50",

            search: '',

            headers: [
                { text: 'Nombre',   align: 'start', value: 'name', },
                { text: 'Fecha',    value: 'date' },
                { text: 'actions',  value: 'actions', searchable:false,   align: 'end',},
            ],
        }
    },

    created(){
        this.getContract()
    },

    computed: {
    ...mapGetters({
      contract: "contract/listContracts",
    }),
  },

  methods:{

      getContract()
      {
            this.$store.dispatch('contract/getAll')
      }
  }


}
</script>
