<template>
  <v-snackbar
    v-for="(single, index) in snackbar.getSnakbars.filter(s => s.show)"
    :key="index"
    v-model="single.show"
    :timeout="single.timeout"
    :location="'top right'"
    variant="elevated"
    :style="`top: ${index * 80}px`"
  >
    <p :class="'text-' + single.label"> {{ single.title }} </p>
    <p>{{ single.message }}</p>
    <template v-slot:actions>
      <v-icon @click="single.show = false" icon="mdi-close" />
    </template>
  </v-snackbar>
</template>
<script setup>
import { ref, watch } from "vue";
import { useSnackbarStore } from "../../../store/useSnackbarStore";
const snackbar = useSnackbarStore();

watch(snackbar, (value) => {
  // when a snackbar timed out, then
  snackbar.removeTimedoutSnackbars()
});
</script>
