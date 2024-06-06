<template>
  <div class="logo">
    <RouterLink to="/">
      <img src="@/assets/images/logos/logodark.png" class="logo-dark" />
      <!-- <img src="@/assets/images/logos/educity-fav.png" class="hidden-sm hidden-md hidden-lg" /> -->
    </RouterLink>
  </div>
</template>
<script setup>
import { ref } from "vue";
import { RouterLink } from "vue-router";
const primary = ref("rgb(var(--v-theme-primary))");
const secondary = ref("rgb(var(--v-theme-secondary))");
</script>
