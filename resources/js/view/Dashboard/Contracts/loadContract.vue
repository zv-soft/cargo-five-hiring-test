<template>
  <v-app style="background-color=blue">
    <v-overlay :value="loader">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <MenuDrawer></MenuDrawer>
    <v-main class="mt-5 pa-6">
      <v-col
        ><v-card :color="colorBase" class="pa-10 white--text d-flex justify-end"
          ><h1>Cargar Contratos</h1></v-card
        >
      </v-col>

      <v-card class="pa-15 ma-15">
        <v-form ref="form" v-model="valid" lazy-validation class="w-100">
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="data.name"
                outlined
                :rules="ruleName"
                prepend-icon="mdi-card-text"
                placeholder="Nombre"
              >
              </v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-menu
                ref="menu"
                v-model="menu"
                :close-on-content-click="false"
                :return-value.sync="data.date"
                transition="scale-transition"
                offset-y
                min-width="auto"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="data.date"
                    outlined
                    :rules="ruleDate"
                    label="Fecha"
                    prepend-icon="mdi-calendar"
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker v-model="data.date" scrollable>
                  <v-spacer></v-spacer>
                  <v-btn text color="primary" @click="menu = false">
                    Cancel
                  </v-btn>
                  <v-btn
                    text
                    color="primary"
                    @click="$refs.menu.save(data.date)"
                  >
                    OK
                  </v-btn>
                </v-date-picker>
              </v-menu>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" md="8">
              <v-file-input
                placeholder="Seleccione el Archivo"
                v-model="data.file"
                :rules="rulesFile"
                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                outlined
                required
              ></v-file-input> </v-col
          ></v-row>
          <v-row class="d-flex justify-content-end">
            <v-col cols="12" class="d-flex justify-end">
              <v-btn
                @click="subirArchivo()"
                class="white--text"
                :color="colorBase"
                >Cargar</v-btn
              >
            </v-col>
          </v-row>
        </v-form>
      </v-card>
    </v-main>
    <v-snackbar
      v-model="dialog.open"
      :color="dialog.color"
      :timeout="4000"
      :top="true"
      :right="true"
    >
      {{ dialog.message }}
      <v-icon class="ml-2" small @click="dialog.open = false">mdi-close</v-icon>
    </v-snackbar>
  </v-app>
</template>
<script>
import MenuDrawer from "../Components/Dreawer.vue";
import { mapGetters } from "vuex";
export default {
  components: {
    MenuDrawer,
  },
  data() {
    return {
      dialog: {
        message: null,
        color: null,
        open: false,
      },
      colorBase: "#031a50",
      menu: false,
      loader: false,
      valid: false,
      data: {
        name: null,
        date: null,
        file: null,
      },
      ruleName: [(v) => !!v || "El Nombre es Requerido"],
      ruleDate: [(v) => !!v || "La fecha es requerida"],
      rulesFile: [(v) => !!v || "El Archivo es Requerido"],
    };
  },

  methods: {
    subirArchivo() {
      if (this.$refs.form.validate()) {
        this.loader = true;
        let formData = new FormData();
        console.log(this.data.name)
        formData.append("file", this.data.file);
        formData.append("name", this.data.name);
        formData.append("date", this.data.date);
        this.$store.dispatch("contract/store", formData).then((response) => {
          this.loader = false;
          this.dialog = {
            message: response.message,
            color: response.color,
            open: true,
          };
            if(response.content)
            {
                setTimeout(() => {
                     this.$router.push( { path:'ViewContract/'+response.content })
                }, 1000);

            }

          this.$refs.form.reset();
        });
      }
    },
  },

  mounted() {

  },

  computed: {

  },
};
</script>
