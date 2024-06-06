import { defineStore } from "pinia";
export const useDatatableStore = defineStore("datatableStore", {
  state: () => {
    return {
      reloadDatatable: false,
    };
  },
  getters: {},
  actions: {},
});
