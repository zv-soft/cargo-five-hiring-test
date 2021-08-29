<template>
  <div class="container">
    <div class="row justify-content-center">
      <v-main>
        <v-row class="d-flex justify-content-center mt-10">
          <v-col cols="12" sm="6" md="6">
            <v-card class="pa-10">
                 <v-form>
              <v-row>

                <v-text-field
                  label="Usuario"
                  placeholder="Usuario"
                  v-model="data.email"
                ></v-text-field>
              </v-row>
              <v-row>
                <v-text-field
                  label="Contraseña"
                  placeholder="Contraseña"
                  v-model="data.password"
                  type="password"
                ></v-text-field>
              </v-row>

              <v-row class="d-flex justify-content-end">
                <v-btn @click="doLogin()" color="primary"> Ingresar </v-btn>
              </v-row>
                 </v-form>
            </v-card>
          </v-col>
        </v-row>
      </v-main>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        email: null,
        password: null,
      },
    };
  },
  mounted() {
    console.log("Component mounted.");
  },

  methods: {
    doLogin() {
      this.$store.dispatch("login/signInWithLaravelPassport", JSON.stringify(this.data)).then((respone)=>{
        //   this.$router.push('Dashboard')
              this.$nextTick(function () {
                                        window.location.href = "/dashboard";
                                    });
      }).catch(()=>{

      });
    },
  },
};
</script>
