<script setup>
// Write dependency import statements here
import { ref, reactive, computed, onMounted, watch } from "vue";
import { useDate } from "vuetify";
import HttpService from "../../services/HttpService.js";
import AuthService from "../../services/AuthService.js";
import { useformAction } from "../../composables/useformAction";
import Form from "../../services/Form";
import { useSnackbarStore } from "../../store/useSnackbarStore";
// End Dependency Import

// emits here
const emit = defineEmits(["onCloseDialog"]);

// props here
const props = defineProps({
  isOpen: Boolean,
  dialogData: {
    default: [],
  },
});

// import composables/mixins here
let { _initForm } = useformAction();
const snackbar = useSnackbarStore();
// End of composables

// Write data definition statements here
let loading = ref(false);
let formId = ref(null);
let form = reactive(
  new Form({
    full_name: "",
    email: "",
    contact: "",
    password: "",
  })
);
// validation rules
let rules = reactive({
  full_name: "required",
  email: "required|email",
  password: "required|min:6",
});

let dialogStatus = ref(false);
dialogStatus.value = props.isOpen;
if (dialogStatus.value === true) {
  beforeOpenDialog(props.dialogData);
}

// Write methods here
function beforeOpenDialog(event) {
  _initForm(event, form, formId, rules);
}

async function onSubmitForm(event) {
  try {
    const { valid, errors } = await event;
    if (!valid) return false;

    loading.value = true;
    let id = formId.value;
    let { data } = await HttpService[!id ? "post" : "put"](
      !id ? `users` : `users/${id}`,
      form.data()
    );
    dialogStatus.value = false;
    loading.value = false;
    snackbar.success(
      `User has been ${id ? "updated" : "created"} successfully!`
    );
    emit("onCloseDialog", data.data, formId.value);
  } catch (error) {
    console.log(error);
    emit("onCloseDialog");
    // this.setFormErrors(error);
    snackbar.error(`Failed to create User !`);
  }
}

function handleDialogAction(action = "close") {
  if (action == "close") {
    dialogStatus.value = false;
    emit("onCloseDialog");
  } else if (action == "clickOutside") {
    return false;
  }
}
</script>
<template>
  <v-dialog
    v-model="dialogStatus"
    :maxWidth="'50%'"
    animateClick="handleDialogAction('clickOutside')"
    :persistent="true"
    :scrim="'dark'"
  >
    <v-card>
      <v-card-title>
        Add New User
        <v-icon
          icon="mdi-close"
          class="text-dark float-end cursor-pointer"
          size="small"
          border
          @click="handleDialogAction('close')"
        ></v-icon>
      </v-card-title>
      <v-form @submit.prevent="onSubmitForm">
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  variant="outlined"
                  v-model="form.full_name"
                  :rules="rules.full_name"
                  label="Full Name*"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="form.email"
                  :rules="rules.email"
                  variant="outlined"
                  label="Email *"
                  type="email"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="form.contact"
                  variant="outlined"
                  label="Contact No *"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="form.password"
                  :rules="rules.password"
                  variant="outlined"
                  label="Create password *"
                  type="password"
                  required
                ></v-text-field>
              </v-col>


              <v-col cols="12" sm="6">
                <v-file-input
                  label="File input"
                  chips
                  multiple
                  show-size
                  counter
                  variant="outlined"
                ></v-file-input>
              </v-col>


            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue-darken-1"
            variant="text"
            @click="handleDialogAction('close')"
          >
            Close
          </v-btn>
          <v-btn color="blue-darken-1" variant="text" type="submit">
            Save
          </v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
</template>
