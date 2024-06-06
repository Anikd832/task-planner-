<script setup>
import { ref, reactive, watch } from "vue";
const emit = defineEmits(["dialogOpening", "dialogSubmit", "dialogClosed"]);
const props = defineProps({
  title: String,
  dialog: Boolean,
  isOpen: Boolean,
  maxWidth: {
    type: String,
    default: "50%",
  },
  dialogData: {
    default: [],
  },
});

let dialogStatus = ref(false);
dialogStatus.value = props.isOpen;
if (dialogStatus.value === true) {
  emit("dialogOpening", props.dialogData);
}

function handleDialogAction(action = "close") {
  if (action == "save") {
    dialogStatus.value = false;
    emit("dialogSubmit");
  } else if (action == "close") {
    dialogStatus.value = false;
    emit("dialogClosed");
  } else if (action == "clickOutside") {
    return false;
  }
}
</script>
<template>
  <v-dialog
    v-model="dialogStatus"
    :max-width="maxWidth"
    animateClick="handleDialogAction('clickOutside')"
    :persistent="true"
    :scrim="'dark'"
  >
    <v-card>
      <v-card-title>
        {{ title }}
        <v-icon
          icon="mdi-close"
          class="text-dark float-end cursor-pointer"
          size="small"
          border
          @click="handleDialogAction('close')"
        ></v-icon>
      </v-card-title>
      <slot></slot>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          color="blue-darken-1"
          variant="text"
          @click="handleDialogAction('close')"
        >
          Close
        </v-btn>
        <v-btn
          color="blue-darken-1"
          variant="text"
          @click="handleDialogAction('save')"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
