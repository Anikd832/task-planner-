import { getCurrentInstance } from "vue";
export function useformAction() {
  function _initForm(data, form, formId, rules = null) {
    form.reset();
    formId.value = null;
    if (data) {
      formId.value = data.id;
      for (let key in form.data()) {
        form[key] = data[key] || data[key] !== "null" ? data[key] : "";
      }
    }
    if (rules) {
      for (let key in rules) {
        let key_name = "";
        let makeRules = [];
        rules[key].split("|").map((rule) => {
          key_name = key
              .split("_")
              .map((item) => {
                return item[0].toUpperCase() + item.substring(1);
              })
              .join(" ");
          switch (rule) {
            case 'required':
              makeRules.push((v) => !!v || key_name + " is required");
              break;
            case 'email':
              makeRules.push((v) => /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(v) || key_name + " must be a valid email");
              break;
          }

          if (rule.split(":").length > 1) {
            switch (rule.split(":")[0]) {
              case 'min':
                makeRules.push((v) => v.length >= rule.split(":")[1] || key_name + " length must be " + rule.split(":")[1]);
                break;
              case 'max':
                makeRules.push((v) => v.length <= rule.split(":")[1] || key_name + " length not more than " + rule.split(":")[1]);
                break;
            }
          }
        });
        rules[key] = makeRules;
        console.log(rules);
      }
    }
  }

  function setFormErrors(error, flashModal = true) {
    loading = false;
    if (error.response.status === 422) {
      $refs.form.setErrors(error.response.data.errors);
      return;
    }
    if (flashModal) {
      flashSwal(error.response.data.message, "Oops...", "error");
      return;
    }
    flash(error.response.data.message, "danger");
  }

  function updateData(data, target, id) {
    if (!id) {
      target.unshift(data);
      return;
    }
    let collectionItem = target[target.findIndex((item) => item.id == id)];
    for (let key in data) {
      collectionItem[key] = data[key];
    }
  }

  return {
    _initForm,
    setFormErrors,
    updateData,
  };
}
