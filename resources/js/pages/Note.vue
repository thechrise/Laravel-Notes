<template>
  <v-container fluid fill-height>
    <v-layout>
      <v-flex xs12 sm12 offset-md2 md8>
        <v-card>
          <v-card-text>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-text-field v-model="note.title" :rules="titleRules" label="Title" required></v-text-field>
              <v-textarea v-model="note.content" label="Content"></v-textarea>
              <v-btn :disabled="!valid" color="primary" @click="saveNote">Save</v-btn>
              <v-btn outline color="error" @click="deleteNote">Delete</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>

    <v-snackbar v-model="notification.show">
      {{ notification.message }}
      <v-btn color="pink" flat @click="notification.show = false">Close</v-btn>
    </v-snackbar>
  </v-container>
</template>

<script>
export default {
  props: ["id"],
  data: () => ({
    note: {},
    valid: true,
    titleRules: [
      v => !!v || "Title is required",
      v => (v && v.length <= 225) || "Title must be less than 225 characters"
    ],
    notification: {
      show: false,
      message: ""
    }
  }),
  mounted() {
    axios
      .get(`/api/notes/${this.id}`)
      .then(response => {
        this.note = response.data;
      })
      .catch(error => {
        this.$router.push("/");
      });
  },
  methods: {
    saveNote() {
      axios
        .put(`/api/notes/${this.$route.params.id}`, this.note)
        .then(response => {
          this.notification.message = response.data;
          this.notification.show = true;
        });
    },
    deleteNote() {
      axios.delete(`/api/notes/${this.$route.params.id}`).then(response => {
        this.$router.push("/");
      });
    }
  }
};
</script>

<style>
</style>
