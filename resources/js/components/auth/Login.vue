<script setup>
import { ref, reactive, onMounted } from "vue";
import Logo from "@/layouts/full/logo/Logo.vue";
import AuthService from "../../services/AuthService";
import HttpService from "../../services/HttpService.js";
import Form from "../../services/Form";
import { useSnackbarStore } from "../../store/useSnackbarStore.js";
import { useRoute, useRouter } from "vue-router";

// Write data definition statements here
const route = useRoute();
const router = useRouter();
const snackbar = useSnackbarStore();

let loading = ref(false);

let form = reactive(
  new Form({
    email: "admin@educitybd.com",
    password: "123456",
    checkbox: true,
  })
);

onMounted(() => {
  hasAccessToken();
});

async function onLogin() {
  try {
    loading.value = true;
    let { data } = await HttpService.post(`login`, form.data(), false);
    if (data.loggedin) {
      snackbar.success("You already have an active session !");
      router.push("/app/dashboard");
      return;
    }
    if (data.data.token) {
      AuthService.setToken(data.data.token, data.data.expires_at);
      snackbar.success("Login successful !");
      router.push(route.query?.redirect ?? "/app/dashboard");
    } else {
      snackbar.error("Login failed !");
    }
  } catch (error) {
    // this.setFormErrors(error);
    snackbar.error("Login failed !");
  } finally {
    loading.value = false;
  }
}

async function hasAccessToken() {
  try {
    loading.value = true;
    if (AuthService.getToken().token) {
      let { data } = await AuthService.validateToken();
      if (data.success == true) {
        snackbar.success("You already have an active session !");
        router.push("/app/dashboard");
      }
    }
  } catch (error) {
    if (error.response.status == 401) {
      AuthService.deleteToken();
    }
  } finally {
    loading.value = false;
  }
}
</script>

<template>
  <div class="authentication">
    <v-container fluid class="pa-3">
      <v-row class="h-100vh d-flex justify-center align-center">
        <v-col cols="12" lg="4" xl="3" class="d-flex align-center">

          <v-card
            class="mx-auto pa-3 pb-2"
            elevation="8"
            max-width="550"
            rounded="lg"
          >
            <div class="d-flex justify-center py-3 mb-2">
              <Logo />
            </div>
            <div class="text-center mb-3">
              <h1 style="font-size: 1.3rem;">অ্যাকাউন্টে প্রবেশ করুন</h1>
            </div>
            <div class="text-body-1 text-center mb-3">
              পড়াশোনার পরিকল্পনাকে আরো গুঁছিয়ে তুলুন ।
            </div>
            <hr class="my-5" />
            <v-text-field
              density="compact"
              placeholder="আপনার ইমেইল লিখুন"
              prepend-inner-icon="mdi-email-outline"
              variant="outlined"
              label="ইমেইল"
              v-model="form.email"
              hide-details="auto"
              class="mb-6"
            ></v-text-field>

            <v-text-field
              type="password"
              density="compact"
              placeholder="৮ সংখ্যার একটি পাসওয়ার্ড লিখুন"
              label="পাসওয়ার্ড লিখুন"
              prepend-inner-icon="mdi-lock-outline"
              variant="outlined"
              v-model="form.password"
              hide-details="auto"
              class="mb-4"
            ></v-text-field>

            <div class="text-right">
              <RouterLink
                to="/app/forget-password"
                class="text-primary text-decoration-none text-body-1 opacity-1 font-weight-medium py-0"
              >
                পাসওয়ার্ড ভুলে গেছেন ?
              </RouterLink>
            </div>

            <v-checkbox
              v-model="form.checkbox"
              color="primary"
              density="compact"
              hide-details="auto"
              class="py-2"
            >
              <template v-slot:label class="text-body-1">
                Remeber this device
              </template>
            </v-checkbox>

            <v-btn @click.prevent="onLogin" color="primary" size="large" block flat>
              লগইন
            </v-btn>

            <v-card-text class="text-left">
              <h6
                class="text-h6 mt-3 text-center"
              >
                একাউন্ট না থাকলে
                <RouterLink to="register" class="text-primary text-decoration-none"> রেজিস্ট্রেশন&nbsp;</RouterLink>
                করুন
              </h6>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
