<script setup>
import { ref, reactive, computed, watch } from "vue";
const checkbox = ref(true);
import Logo from "@/layouts/full/logo/Logo.vue";
import Form from "../../services/Form";

let form = reactive(
  new Form({
    full_name: "",
    email: "",
    password: "",
    password_confirmation: "",
  })
);
let passwordVisible = ref(false);
</script>

<template>
  <div class="authentication">
    <v-container fluid class="pa-2">
      <v-row class="h-100vh d-flex justify-center align-center">
        <v-col cols="12" lg="4" xl="4" class="d-flex align-center">
          <v-card
            class="mx-auto pa-3 pb-2"
            elevation="8"
            max-width="550"
            rounded="lg"
          >
            <div class="d-flex justify-center py-3 mb-3">
              <Logo />
            </div>
            <div class="text-center mb-3">
              <h1 style="font-size: 1.3rem;">এডুসিটি স্টাডিপ্ল্যানার অ্যাকাউন্ট তৈরি করুন</h1>
            </div>
            <div class="text-body-1 text-center mb-3">
              আপনার পড়াশোনার পরিকল্পনা হোক এডুসিটি স্টাডি প্ল্যানারের সাথে ।
            </div>
            <hr class="my-4" />

            <v-text-field
              density="compact"
              placeholder="আপনার পূর্ণ নাম লিখুন"
              variant="outlined"
              label="পূর্ণ নাম"
              v-model="form.full_name"
              hide-details="auto"
              class="mb-5"
            ></v-text-field>

            <v-text-field
              density="compact"
              placeholder="আপনার ইমেইল লিখুন"
              prepend-inner-icon="mdi-email-outline"
              variant="outlined"
              label="ইমেইল"
              v-model="form.email"
              hide-details="auto"
              class="mb-5"
            ></v-text-field>

            <v-text-field
              :append-inner-icon="passwordVisible ? 'mdi-eye-off' : 'mdi-eye'"
              :type="passwordVisible ? 'text' : 'password'"
              density="compact"
              placeholder="৮ সংখ্যার একটি পাসওয়ার্ড লিখুন"
              label="পাসওয়ার্ড লিখুন"
              prepend-inner-icon="mdi-lock-outline"
              variant="outlined"
              @click:append-inner="passwordVisible = !passwordVisible"
              v-model="form.password"
              hide-details="auto"
              class="mb-5"
            ></v-text-field>

            <v-text-field
              density="compact"
              placeholder="পাসওয়ার্ড নিশ্চিত করুন"
              label="কনফার্ম পাসওয়ার্ড"
              variant="outlined"
              v-model="form.password_confirmation"
              hide-details="auto"
              class="mb-5"
            ></v-text-field>

            <v-btn to="/" color="primary" size="large" block flat>
              Sign Up
            </v-btn>

            <v-card-text class="text-left">
              <h6
                class="text-h6 mt-3 text-center"
              >
                ইতোমধ্যে একাউন্ট করে থাকলে
                <RouterLink to="/app/login" class="text-primary text-decoration-none">
                  &nbsp;লগইন
                </RouterLink>
                করুন
              </h6>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
