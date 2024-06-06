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

let routines = ref([]);
let subjects = ref([]);
let teachers = ref([]);
let days = [];
let meta = ref({});
let formId = ref(null);
let form = reactive(
  new Form({
    subject_id: "",
    teacher_id: "",
    day_id: "",
    room_no: "",
    from: "",
    to: "",
  })
);
// End of Data definition

// Write Mounted here
onMounted(() => {
  fetchVariables(), fetchRoutines();
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
      routines.unshift(data);
      return;
    }
    let collectionItem = routines[routines.findIndex((item) => item.id == id)];
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
    console.log(form.data());
    return;
    loading.value = true;
    let id = formId.value;
    let { data } = await HttpService[!id ? "post" : "put"](
      !id ? `routines` : `routines/${id}`,
      form.data()
    );
    snackbar.success(
      `Routine has been ${id ? "updated" : "created"} successfully!`
    );
    updateData(data.data, "routines", formId.value);
    dialogStatus.value = false;
    loading.value = false;
  } catch (error) {
    // this.setFormErrors(error);
    snackbar.error(`Failed to create Routine !`);
  }
}

function loadItems(queries) {
  console.log(queries);
  fetchRoutines();
}

async function fetchRoutines() {
  loading.value = true;
  const { data } = await HttpService.get("routines");
  routines = data.data;
  // console.log(routines);
  meta = data.meta;
  loading.value = false;
}

async function fetchVariables() {
  const { data } = await HttpService.get("routines/get/subject-teacher-day");
  teachers = data.data.teachers;
  subjects = data.data.subjects;
  days = data.data.days;
  console.log(teachers);
}

async function destroy(item) {
  if (!confirm("Do you want to delete ?")) {
    return false;
  }
  try {
    loading.value = true;
    const { data } = await HttpService.delete(`routines/${item.id}`);
    if (data.success == true) {
      routines.splice(routines.indexOf(item), 1);
      snackbar.success(`Routine has been deleted successfully !`);
    } else {
      // snackbar.success(`Routine has been ${id ? 'updated' : 'created'} successfully !`)
    }
  } catch (error) {
    console.log(error);
    // flash('Failed to create batch !', 'danger', false)
  } finally {
    loading.value = false;
  }
}
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
          <v-col> My Routines/ ToDo </v-col>
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
              <th class="text-subtitle-1 font-weight-bold">Subject</th>
              <th class="text-subtitle-1 font-weight-bold">Room No.</th>
              <th class="text-subtitle-1 font-weight-bold">Time</th>
              <th class="text-subtitle-1 font-weight-bold">Status</th>
              <th class="text-subtitle-1 font-weight-bold">Action</th>
            </tr>
          </thead>
          <tbody>
            <template v-if="!loading && routines.length > 0">
              <tr v-for="(item, key) in routines" :key="key" class="month-item">
                <td>
                  <v-checkbox color="primary"></v-checkbox>
                </td>
                <td>
                  <div class="">
                    <h6 class="text-subtitle-1 font-weight-bold">
                      {{ item.subject.title }}
                    </h6>
                    <div class="text-13 mt-1 text-muted">
                      <!-- Teacher Name: {{teachers[item.teacher_id-1].full_name }} -->
                      Teacher Name: {{ item.teacher.user.full_name }}
                    </div>
                  </div>
                </td>
                <td>
                  <div class="">
                    <div class="text-h5 mt-1">
                      {{ item.room_no }}
                    </div>
                  </div>
                </td>
                <td>
                  <div class="">
                    <div class="text-h5 mt-1">
                      {{ item.from }}
                    </div>
                    <h6 class="text-13 font-weight-bold">
                      {{ item.to }}
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
    title="Add New Routine"
  >
    <template #default>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="6">
              <v-select
                v-model="form.subject_id"
                variant="outlined"
                label="Subject*"
                :items="subjects"
                item-title="title"
                item-value="id"
                required
              >
              </v-select>
            </v-col>
            <v-col cols="6">
              <v-combobox
                v-model="form.teacher_id"
                variant="outlined"
                :items="teachers"
                item-title="full_name"
                item-value="id"
                label="Select a teacher"
              >
              </v-combobox>
            </v-col>
            <v-col cols="6">
              <v-select
                clearable
                chips
                v-model="form.day_id"
                variant="outlined"
                label="Day*"
                :items="days"
                item-title="name"
                item-value="id"
                required
              >
              </v-select>
            </v-col>
            <v-col cols="12" sm="6">
              <v-text-field
                v-model="form.room_no"
                variant="outlined"
                label="Class Room No. *"
                type="text"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6">
              <v-text-field
                v-model="form.from"
                variant="outlined"
                label="Class Start*"
                type="time"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6">
              <v-text-field
                v-model="form.to"
                variant="outlined"
                label="Class End *"
                type="time"
                required
              ></v-text-field>
            </v-col>
          </v-row>
        </v-container>
        <small>*indicates required field</small>
      </v-card-text>
    </template>
  </Dialog>
</template>
