<script setup>
// Write dependency import statements here
import {
  ref,
  reactive,
  onMounted,
  watch,
  onBeforeUnmount,
} from "vue";
import { EditIcon, TrashIcon, UsersIcon } from "vue-tabler-icons";
import UserForm from "./UserForm.vue";
import HttpService from "../../services/HttpService.js";
import { useCommon } from "../../composables/useCommon";
import { useformAction } from "../../composables/useformAction";
import { useSnackbarStore } from "../../store/useSnackbarStore";
import { useDatatableStore } from "../../store/useDatatableStore";
import debounce from "lodash.debounce";
// End Dependency Import


// import composables/mixins here
let {
  getUrlParams,
  getURLQueryString,
  headers,
  changeOrderBy,
  applySearch,
  pageChange,
  filterBy
} = useCommon();

const datatableStore = useDatatableStore();
const snackbar = useSnackbarStore();
let { updateData } = useformAction();
// End of composables

// Write data definition statements here
let loading = ref(false);
let dialogOpen = ref(false);
let dialogData = [];

let search = ref("");
let users = reactive([]);
let meta = reactive({
  current_page: 1,
  per_page: 0,
  total: 0,
  last_page: 1
});
let filters = reactive({
  status: 'All'
})
// End of Data definition

// Write Mounted here
onMounted(() => {
  fetchUsers();
});
// End of mounted

watch(datatableStore, (value) => {
  if (datatableStore.$state.reloadDatatable == true) {
    fetchUsers()
  }
  datatableStore.$state.reloadDatatable = false
});

// Write methods here

// Write methods here
function create() {
  dialogOpen.value = true;
  dialogData = [];
}

function edit(data = []) {
  dialogOpen.value = true;
  dialogData = data;
}

function dialogClosed(data = null, id = null) {
  if (data != null) {
    loading.value = true;
    updateData(data, users, id);
    if (!id) {
      meta.total = meta.total + 1
    }
    setTimeout(() => {
      loading.value = false;
    }, 500);
  }
  dialogOpen.value = false;
}

async function fetchUsers() {
  try {
    loading.value = true;
    const { data } = await HttpService.get(`users${getURLQueryString()}`);
    users = data.data;
    meta = data.meta;
    meta.per_page = meta.per_page == 1000 ? -1 : meta.per_page
  } catch (error) {
    console.log("Something went wrong.");
  } finally {
    loading.value = false;
  }
}

async function destroy(item) {
  if (!confirm("Do you want to delete ?")) {
    return false;
  }
  try {
    loading.value = true;
    const { data } = await HttpService.delete(`users/${item.id}`);
    if (data.success == true) {
      users.splice(users.indexOf(item), 1);
      meta.total = meta.total - 1;
      snackbar.success(`User has been deleted successfully !`);
    } else {
      snackbar.error(`User delete failed !`);
    }
  } catch (error) {
    // console.log(error);
    snackbar.error(`User delete failed !`);
  } finally {
    loading.value = false;
  }
}

const debouncedCallback = debounce((args) => {
  applySearch(search.value);
}, 500);

onBeforeUnmount(() => {
  debouncedCallback.cancel();
});

// End of methods
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
        <v-row class="border-b">
          <v-col> <i class="mdi mdi-account-group"></i> <span>Users</span> </v-col>
          <v-col>
            <v-select
              label="Select"
              v-model="filters.status"
              density="compact"
              :items="['All', 'Active', 'Inactive']"
              variant="outlined"
              clearable
              @update:modelValue="filterBy('status', $event)"
            ></v-select>
          </v-col>
          <v-col class="d-flex justify-end">
            <v-btn
              variant="elevated"
              icon="mdi-plus"
              color="primary"
              class="color-red"
              @click.prevent="create()"
            ></v-btn>
          </v-col>
        </v-row>
      </v-card-title>

      <v-row class="pb-3">
        <v-col></v-col>
        <v-col cols="5">
          <v-text-field
            v-model="search"
            @input="debouncedCallback"
            density="compact"
            label="Search"
            prepend-inner-icon="mdi-magnify"
            variant="outlined"
            flat
            hide-details
            single-line
          ></v-text-field>
        </v-col>
      </v-row>

      <v-data-table-server
        class="border"
        v-model:items-per-page="meta.per_page"
        :headers="headers('Name', 'Email', 'Contact', 'Status', 'Action')"
        :items="users"
        :items-length="meta.total"
        :loading="loading"
        @update:items-per-page="pageChange(1, $event)"
        @update:page="pageChange($event, meta.per_page)"
        @update:sort-by="changeOrderBy($event)"
      >
        <template v-slot:loading>
          <v-skeleton-loader type="table-tbody"></v-skeleton-loader>
        </template>
        <template v-if="!loading" v-slot:item="{ item }">
          <tr class="border-b">
            <td>{{ item.full_name }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.contact }}</td>
            <td>
              <v-chip size="small" variant="flat" :color="item.status_badge">{{ item.status_text }}</v-chip>
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
      </v-data-table-server>
    </v-card-item>
  </v-card>
  <!-- Form here -->
  <UserForm
    v-if="dialogOpen"
    :isOpen="dialogOpen"
    :dialogData="dialogData"
    @onCloseDialog="dialogClosed"
  ></UserForm>
</template>
