// ===============================|| Blank Layout ||=============================== //
<template>
    <v-app>
        <RouterView />
        <Snackbar />
    </v-app>
</template>
<script setup>
import { RouterView } from 'vue-router';
import Snackbar from '../../components/common/snackbar/Snackbar.vue';
</script>
