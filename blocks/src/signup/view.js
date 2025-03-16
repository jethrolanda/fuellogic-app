/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  state: {
    get isError() {
      const context = getContext();
      return context.status === "error";
    },
    get isSuccess() {
      const context = getContext();
      return context.status === "success";
    }
  },
  actions: {
    *submitForm(e) {
      e.preventDefault();
      const { ref } = getElement();
      const context = getContext();
      const formData = new FormData(ref);
      console.log(formData);
      formData.append("action", "fla_signup");
      formData.append("nonce", state.nonce);

      const data = yield fetch(state.ajaxUrl, {
        method: "POST",
        body: formData
      }).then((response) => response.json());

      context.signup_msg = data.message;
      context.status = data.status;
      if (data.status == "success") {
        // Signup redirect
        window.location.href = state.signup_redirect;
      } else {
      }
    }
  },
  callbacks: {
    renderSignupMsg: () => {
      const context = getContext();
      const el = getElement();
      el.ref.innerHTML = context.signup_msg;
    }
  }
});
