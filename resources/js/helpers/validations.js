import { extend, localize } from 'vee-validate';
import { required, required_if, email, confirmed, alpha, alpha_dash, min, max, ext, image, mimes, size, numeric, integer, max_value, min_value } from 'vee-validate/dist/rules';
import en from "vee-validate/dist/locale/en.json";

// define rules
extend("required", required);
extend("required_if", required_if);
extend("email", email);
extend("confirmed", confirmed);
extend("alpha", alpha);
extend("alpha_dash", alpha_dash);
extend("min", min);
extend("max", max);
extend("max_value", max_value);
extend("min_value", min_value);
extend("ext", ext);
extend("image", image);
extend("mimes", mimes);
extend("size", size);
extend("numeric", numeric);
extend("integer", integer);

extend('password', {
    params: ['target'],
    validate(value, { target }) {
        return value === target;
    },
    message: 'Password confirmation does not match'
});

// define messages language
localize({
    en
});

// validate after form submit
