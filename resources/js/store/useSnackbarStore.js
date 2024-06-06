import { defineStore } from "pinia";
export const useSnackbarStore = defineStore("snackbar", {
  state: () => {
    return {
      snackbars: [],
    };
  },
  getters: {
    // automatically infers the return type as a number
    getSnakbars(state) {
      return state.snackbars;
    },
  },
  actions: {
    success(message = "Operation successful !", title = "Success !") {
      this.snackbars.unshift({
        show: true,
        title: title,
        message: message,
        label: "success",
        timeout: 4000
      });
    },
    error(message = "Operation failed !", title = "Oops !") {
      this.snackbars.unshift({
        show: true,
        title: title,
        message: message,
        label: "danger",
        timeout: 4000
      });
    },
    removeTimedoutSnackbars() {
      for (let bar of this.snackbars) {
        if (bar.show == false) {
          this.snackbars.splice(this.snackbars.indexOf(bar), 1);
        }
      }
    }
  },
});
