<template>
  <v-app id="keep">
    <!-- <v-navigation-drawer v-model="drawer" fixed clipped class="grey lighten-4" app>
      <v-list dense class="grey lighten-4">
        <template v-for="(item, i) in items">
          <v-layout v-if="item.heading" :key="i" row align-center>
            <v-flex xs6>
              <v-subheader v-if="item.heading">{{ item.heading }}</v-subheader>
            </v-flex>
            <v-flex xs6 class="text-xs-right">
              <v-btn small flat>edit</v-btn>
            </v-flex>
          </v-layout>
          <v-divider v-else-if="item.divider" :key="i" dark class="my-3"></v-divider>
          <v-list-tile v-else :key="i" @click>
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title class="grey--text">{{ item.text }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>
    </v-navigation-drawer>-->
    <v-toolbar color="orange" app absolute clipped-left>
      <!-- <v-toolbar-side-icon @click="drawer = !drawer"></v-toolbar-side-icon> -->
      <router-link class="title" to="/">
        <span class="ml-3 mr-5">
          Notes
          <span class="font-weight-light">App</span>
        </span>
      </router-link>
      <v-form @submit.prevent="search">
        <v-text-field
          solo-inverted
          flat
          hide-details
          label="Search"
          prepend-inner-icon="search"
          v-model="query"
        ></v-text-field>
      </v-form>
      <v-spacer></v-spacer>
    </v-toolbar>
    <v-content class="grey lighten-4">
      <transition name="fade" mode="out-in" transition="slide-x-transition">
        <router-view />
      </transition>
    </v-content>
  </v-app>
</template>

<script>
import { EventBus } from "../event-bus";
export default {
  data: () => ({
    drawer: false,
    items: [
      { icon: "lightbulb_outline", text: "Notes" },
      { divider: true },
      { icon: "archive", text: "Archive" },
      { icon: "delete", text: "Trash" },
      { divider: true },
      { icon: "settings", text: "Settings" },
      { icon: "chat_bubble", text: "Trash" },
      { icon: "help", text: "Help" },
      { icon: "phonelink", text: "App downloads" },
      { icon: "keyboard", text: "Keyboard shortcuts" }
    ],
    query: ""
  }),
  props: {
    source: String
  },
  methods: {
    search() {
      this.$router.push({
        path: "/",
        params: {
          query: this.query
        }
      });
      EventBus.$emit("search", this.query);
    }
  }
};
</script>

<style>
#keep .v-navigation-drawer__border {
  display: none;
}
.fade-enter-active,
.fade-leave-active {
  transition-duration: 0.3s;
  transition-property: opacity;
  transition-timing-function: ease;
}

.fade-enter,
.fade-leave-active {
  opacity: 0;
}

.title {
  text-decoration: none;
  color: #fff;
  font-size: 2rem;
}
</style>
