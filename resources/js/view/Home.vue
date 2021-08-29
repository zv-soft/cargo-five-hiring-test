<template>
  <div class="container">
    <div class="row justify-content-center">
      <v-row class="d-flex justify-center pa-3">
      <v-col class="w-100"><h1>Cargo Five</h1></v-col>
      <v-col class="d-flex justify-end">
          <router-link to="login">
            <v-btn :color="colorBase" class="white--text">
            <v-icon>mdi-account-tie</v-icon> Login
            </v-btn>
          </router-link>

        </v-col>
      </v-row>

    </div>
        <v-row class="d-flex justify-center pa-3">
            <h1  class="text-title">Bienvenidos</h1>
        </v-row>
  </div>
</template>

<script>
export default {
    data() {
    return {
     colorBase:'#031a50'
    };
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
<style>
.text-title{
    font-size: 70px;
    font-weight: bold;
}
</style>
