<template>
  <v-container fluid grid-list-lg>
    <v-layout row wrap justify-center>
      <v-flex xs12 sm6 md4 lg3 v-for="note in notes" :key="note.id">
        <v-card>
          <v-card-title primary-title>
            <div>
              <h3 class="headline mb-0">{{note.title}}</h3>
              <div v-html="note.content"></div>
            </div>
          </v-card-title>

          <v-card-actions>
            <v-btn :to="`/${note.id}`" flat color="orange">View</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
    <v-btn fab bottom right color="blue" dark fixed @click="dialog = !dialog">
      <v-icon>add</v-icon>
    </v-btn>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Create A Note</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-layout wrap>
                <v-flex xs12>
                  <v-text-field label="Title" v-model="note.title" :rules="titleRules" required></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-textarea label="Content" v-model="note.content"></v-textarea>
                </v-flex>
              </v-layout>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click="dialog = false; note = {}">Close</v-btn>
          <v-btn color="blue darken-1" flat @click="createNote">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import { EventBus } from "../event-bus.js";
export default {
  props: ["query"],
  data: () => ({
    notes: [],
    note: {
      title: "",
      content: ""
    },
    valid: true,
    titleRules: [
      v => !!v || "Title is required",
      v => (v && v.length <= 225) || "Title must be less than 225 characters"
    ],
    dialog: false
  }),

  mounted() {
    console.log(this.$route.params);
    this.getNotes(this.$route.params.query);
    EventBus.$on("search", query => {
      this.getNotes(query);
    });
  },
  methods: {
    getNotes(query = "") {
      axios.get(`/api/notes?q=${query}`).then(response => {
        this.notes = response.data;
      });
    },
    createNote() {
      axios.post("/api/notes", this.note).then(response => {
        this.notes.push(response.data);
        this.dialog = false;
        this.note = {};
      });
    }
  }
};
</script>

<style>
</style>
