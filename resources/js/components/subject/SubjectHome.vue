<script setup>
// Write dependency import statements here
import { ref, reactive, computed, onMounted, watch } from "vue";
import { useDate } from "vuetify";
import { EditIcon, TrashIcon } from "vue-tabler-icons";
import Dialog from "@/components/shared/Dialog.vue";
import HttpService from "../../services/HttpService.js";
import { useCommon } from "../../composables/useCommon";
import { useformAction } from "../../composables/useformAction";
import Form from "../../services/Form";
import AuthService from "../../services/AuthService";
import { useSnackbarStore } from "../../store/useSnackbarStore";
// End Dependency Import

// import composables/mixins here
let { _initForm } = useformAction();
let { getUrlParams } = useCommon();
const snackbar = useSnackbarStore();
// End of composables

// Write data definition statements here
let loading = ref(false);
let dialogStatus = ref(false);
let dialogData = [];

let subjects = ref([]);
let meta = ref({});
let formId = ref(null);
let form = reactive(
  new Form({
    title: "",
    code: "",
    credit:"",
    subject_type: ""
  })
);
// End of Data definition

// Write Mounted here
onMounted(() => {
  fetchSubjects()
});
// End of mounted

// Write methods here
function beforeOpenDialog(event) {
  _initForm(event, form, formId);
  // console.log(form.data());
}

function onCloseDialog() {
  dialogStatus.value = false;
}

function updateData(data, key, id) {
  try {
    if (!id) {
      subjects.unshift(data);
      return;
    }
    let collectionItem = subjects[subjects.findIndex((item) => item.id == id)];
    for (let key in data) {
      collectionItem[key] = data[key];
    }
  } catch (e) {
    console.log(e);
  }
}

function create() {
  dialogStatus.value = true;
  dialogData = [];
}

function edit(data) {
  dialogStatus.value = true;
  dialogData = data;
}

async function onSubmitForm() {
  try {
    loading.value = true;
    let id = formId.value;
    let { data } = await HttpService[!id ? "post" : "put"](
      !id ? `subjects` : `subjects/${id}`,
      form.data()
    );
    updateData(data.data, "subjects", formId.value);
    dialogStatus.value = false;
    loading.value = false;
    snackbar.success(
      `Subject has been ${id ? "updated" : "created"} successfully!`
    );
  } catch (error) {
    // this.setFormErrors(error);
    snackbar.error(`Failed to create Subject !`);
  }
}

function loadItems(queries) {
  console.log(queries);
  fetchSubjects()
}

async function fetchSubjects() {
  loading.value = true;
  const { data } = await HttpService.get("subjects");
  subjects = data.data;
  meta = data.meta;
  loading.value = false;
}

async function destroy(item) {
  if (!confirm("Do you want to delete ?")) {
    return false;
  }
  try {
    loading.value = true;
    const { data } = await HttpService.delete(`subjects/${item.id}`);
    if (data.success == true) {
      subjects.splice(subjects.indexOf(item), 1);
      snackbar.success(`Subject has been deleted successfully !`);
    } else {
      // snackbar.success(`Subject has been ${id ? 'updated' : 'created'} successfully !`)
    }
  } catch (error) {
    console.log(error);
    // flash('Failed to create batch !', 'danger', false)
  } finally {
    loading.value = false;
  }
}
// End of methods

const headers = [
  { title: 'Title', key: 'title'},
  { title: 'Description', key: 'code' },
  { title: 'Start Time', key: 'credit' },
  { title: 'Start Date', key: 'subject_type' },
  { title: 'Status', key: 'status' },
  // { title: 'Action', key: 'action' },
]
let itemsPerPage = ref(5)
let totalItems = ref(7)
let search = ref('')
</script>

<template>
  <template>
    <v-skeleton-loader
      boilerplate
      class="mx-auto"
      elevation="2"
      max-width="360"
      type="card-avatar, article, actions"
    ></v-skeleton-loader>
  </template>

  <v-card elevation="10" class="month-table" variant="elevated">
    <v-card-item class="pa-6">
      <v-card-title class="text-h5 pt-sm-2 pb-7">
        <v-row>
          <v-col> My Subjects/ ToDo </v-col>
          <v-col class="d-flex justify-end">
            <v-btn @click="create" icon="mdi-plus" color="primary"></v-btn>
          </v-col>
        </v-row>
      </v-card-title>
      <v-skeleton-loader :loading="loading" type="table-tbody">
        <v-table class="w-100">
          <thead>
            <tr>
              <th class="text-subtitle-1 font-weight-bold"></th>
              <th class="text-subtitle-1 font-weight-bold">Subject Details</th>
              <th class="text-subtitle-1 font-weight-bold">Time</th>
              <th class="text-subtitle-1 font-weight-bold">Priority</th>
              <th class="text-subtitle-1 font-weight-bold">Action</th>
            </tr>
          </thead>
          <tbody>
            <template v-if="!loading && subjects.length > 0">
              <tr v-for="(item, key) in subjects" :key="key" class="month-item">
                <td>
                  <v-checkbox color="primary"></v-checkbox>
                </td>
                <td>
                  <div class="">
                    <h6 class="text-subtitle-1 font-weight-bold">
                      {{ item.title }}
                    </h6>
                    <div class="text-13 mt-1 text-muted">
                      {{ item.code }}
                    </div>
                  </div>
                </td>
                <td>
                  <div class="">
                    <div class="text-h5 mt-1">
                      {{ item.credit }}
                    </div>
                    <h6 class="text-13 font-weight-bold">
                      {{ item.subject_type }}
                    </h6>
                  </div>
                </td>
                <td>
                  <v-chip
                    class="text-body-1 bg-primary"
                    color="white"
                    size="small"
                  >
                    {{ item.status_text }}
                  </v-chip>
                </td>
                <td>
                  <v-menu>
                    <template v-slot:activator="{ props }">
                      <v-btn
                        elevation="0"
                        icon="mdi-dots-vertical"
                        v-bind="props"
                      ></v-btn>
                    </template>
                    <v-list density="compact">
                      <v-list-item
                        :value="'Edit'"
                        color="primary"
                        @click.prevent="edit(item)"
                      >
                        <v-list-item-title class="text-14 d-flex align-center">
                          <v-avatar rounded="0">
                            <v-icon :icon="EditIcon"></v-icon>
                          </v-avatar>
                          Edit
                        </v-list-item-title>
                      </v-list-item>
                      <v-list-item
                        :value="'Delete'"
                        color="primary"
                        @click="destroy(item)"
                      >
                        <v-list-item-title class="text-14 d-flex align-center">
                          <v-avatar rounded="0">
                            <v-icon :icon="TrashIcon" color="red"></v-icon>
                          </v-avatar>
                          Delete
                        </v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </td>
              </tr>
            </template>
          </tbody>
        </v-table>
      </v-skeleton-loader>
    </v-card-item>
  </v-card>

  <Dialog
    @dialogOpening="beforeOpenDialog"
    @dialogSubmit="onSubmitForm"
    @dialogClosed="onCloseDialog"
    v-if="dialogStatus"
    :isActive="dialogStatus"
    :dialogData="dialogData"
    :maxWidth="'50%'"
    title="Add New Subject"
  >
    <template #default>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12">
              <v-text-field
                variant="outlined"
                v-model="form.title"
                label="Subject Title *"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6">
              <!--
                <v-date-picker v-model="form.start_date" locale="fa-EN" color="primary" show-adjacent-months width="auto">
                </v-date-picker>
              -->
              <v-text-field
                v-model="form.code"
                variant="outlined"
                label="Subject code *"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6">
              <v-text-field
                v-model="form.credit"
                variant="outlined"
                label="Total credit *"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6">
              <v-select
                v-model="form.subject_type"
                variant="outlined"
                label="Subject type *"
                :items="[
                  { key: 'Theoretical', value: 1 },
                  { key: 'Practical', value: 2 }
                ]"
                item-title="key"
                item-value="value"
                required
              >
              </v-select>
            </v-col>
            <v-col cols="12" sm="6">
              <v-select
                v-model="form.status"
                variant="outlined"
                label="Status *"
                :items="[
                  { key: 'Active', value: 1 },
                  { key: 'Inactive', value: 2 }
                ]"
                item-title="key"
                item-value="value"
                required
              >
              </v-select>
            </v-col>
          </v-row>
        </v-container>
        <small>*indicates required field</small>
      </v-card-text>
    </template>
  </Dialog>
</template>../../composables/useCommon.js../../composables/useformAction.js../../services/Form.js../../services/AuthService.js../../store/useSnackbarStore.js
