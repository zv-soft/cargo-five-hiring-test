<template>
<div>
    <v-system-bar height="50" color="secondary">
    <v-icon color="white" @click.stop="menuDrawer = !menuDrawer">mdi-menu</v-icon>
</v-system-bar>
<v-navigation-drawer
      v-model="menuDrawer"
      absolute
      temporary
      @change="close()"
    >
      <v-list-item>
        <v-list-item-avatar>
          <v-img src="https://randomuser.me/api/portraits/men/77.jpg"></v-img>
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title>{{user.name}}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list dense>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link :to="item.link"
          @click="menuDrawer=false"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
</div>
</template>
<script>
import { mapGetters } from "vuex";
import router from '../../../router';


export default {
  name: "MenuDrawer",

  data: () => ({
    group: null,
    menuDrawer:false,
    items: [
        { title: 'Home', icon: 'mdi-view-dashboard', link:'/Dashboard' },
        { title: 'Cargar Contrato', icon: 'mdi-plus', link:'/LoadContract'  },
        { title: 'Ver Contratos', icon: 'mdi-clipboard-flow', link:'/ViewContracts'  },
    ],
  }),
    methods:{
  },


  computed: {
    ...mapGetters({
      user: "login/user",
    }),
  },
};
</script>
