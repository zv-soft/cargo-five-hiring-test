<template >
  <v-content>
  <MenuDrawer></MenuDrawer>
     <v-row class="d-flex justify-center pa-3">
            <h1  class="text-title">Dentro del Dashboard</h1>
            <v-img height="500" contain src="/images/dashboard.png"></v-img>
        </v-row>
  </v-content>
</template>
<script>
  import MenuDrawer from './Components/Dreawer.vue'
export default {
    components:{
        MenuDrawer,
    },

    data(){
        return{

        }
    }
}
</script>
