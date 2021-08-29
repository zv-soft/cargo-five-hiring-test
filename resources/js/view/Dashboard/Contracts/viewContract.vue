<template>
<v-app>
    <v-overlay :value="loader">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <MenuDrawer></MenuDrawer>
        <v-col
        ><v-card :color="colorBase" class="pa-10 white--text d-flex justify-end"
          ><h1>Rutas del Contrato</h1></v-card
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
      :items="contract.rate"
      :search="search"
    >
    <template v-slot:[`item.name`]>
        <span >{{contract.name}}</span>
    </template>
    <template v-slot:[`item.date`]>
        <span >{{contract.date}}</span>
    </template>
    <template v-slot:[`item.twenty`]="{item}">
        <v-chip color="blue lighten-4" >$ {{item.twenty}}</v-chip>
    </template>
     <template v-slot:[`item.forty`]="{item}">
        <v-chip color="blue lighten-4" >$ {{item.forty}}</v-chip>
    </template>
     <template v-slot:[`item.fortyhc`]="{item}">
        <v-chip color="blue lighten-4" >$ {{item.fortyhc}}</v-chip>
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
            {
            text: 'Nombre',
            align: 'start',
            value: 'name',
            },
            { text: 'Fecha', value: 'date' },
            { text: 'Origen', value: 'origin' },
            { text: 'Destino', value: 'destination' },
            { text: 'Moneda', value: 'currency' },
            { text: 'Tarifa 20', value: 'twenty' },
            { text: 'Tarifa 40', value: 'forty' },
            { text: 'Tarifa 40 HC', value: 'fortyhc' },
        ],
        }
    },

    created(){
        this.getDataFromProps()
    },

    computed: {
    ...mapGetters({
      contract: "contract/contract",
    }),
  },

  methods:{

      getDataFromProps()
      {
        if (this.$route.params.id && typeof this.$route.params.id == "string" ) {
            //Obtenemos el ID del contrato para buscarlo en la DDBB

            this.getContract(this.$route.params.id);
      } else {
            console.log("Error al recuperar el ID de contrato");
            this.$router.push('ViewContract');
      }

      },

      getContract(_id)
      {
            this.$store.dispatch('contract/getContractByID',_id)
      }
  }


}
</script>
