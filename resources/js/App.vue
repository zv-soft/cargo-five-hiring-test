<template>
  <v-app>
    <router-view :auth="auth" :authenticated="authenticated"></router-view>
    <notifications
      group="loggedIn"
      position="top right"
      animation-type="velocity"
    />
    <v-snackbar
      v-model="notificationData.activator"
      :color="notificationData.color"
      :timeout="10000"
      :top="true"
      :right="true"
    >
      {{ notificationData.message }}
      <v-icon class="ml-2" small @click="notificationData.activator = false"
        >mdi-close</v-icon
      >
    </v-snackbar>
  </v-app>
</template>

<script>
import AuthService from "./Auth/AuthService";
const auth = new AuthService();
const { authenticated, authNotifier } = auth;
export default {
  data() {
    authNotifier.on("authChange", (authState) => {
      this.authenticated = authState.authenticated;
    });
    return {
      auth,
      authenticated,
      animation: {
        enter: {
          opacity: [1, 0],
          translateX: [0, -300],
          scale: [1, 0.2],
        },
        leave: {
          opacity: 0,
          height: 0,
        },
      },
      notificationData: { color: "", message: "", activator: false },
    };
  },
};
</script>

