/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  state: {
    get isMsgEmpty() {
      const context = getContext();
      return context.login_msg.length === 0;
    }
  },
  actions: {
    *login(e) {
      e.preventDefault();
      const context = getContext();

      const formData = new FormData();

      formData.append("action", "fla_login");
      formData.append("_ajax_nonce", state.nonce);
      formData.append("uname", context.uname);
      formData.append("pword", context.pword);
      formData.append("remember", context.remember);

      const data = yield fetch(state.ajaxUrl, {
        method: "POST",
        body: formData
      }).then((response) => response.json());

      context.login_status = data.status ?? "";
      context.login_msg = data.message ?? "";

      if (data.status == "error") {
        if (data.code === "empty_username") {
          document.querySelector('input[name="uname"]').classList.add("error");
        }

        if (data.code === "empty_password") {
          document.querySelector('input[name="pword"]').classList.add("error");
        }
        document.querySelector(".login-message").classList.add("error");
      } else {
        document.querySelector('input[name="uname"]').classList.remove("error");
        document.querySelector('input[name="pword"]').classList.remove("error");

        // Login redirect
        window.location.href = state.login_redirect;
      }
    }
  },
  callbacks: {
    setUserName: () => {
      const context = getContext();
      const el = getElement();
      context.uname = el.ref.value;

      if (context.uname.length === 0) {
        el.ref.classList.add("error");
      } else {
        el.ref.classList.remove("error");
      }
    },
    setPassword: () => {
      const context = getContext();
      const el = getElement();
      context.pword = el.ref.value;

      if (context.pword.length === 0) {
        el.ref.classList.add("error");
      } else {
        el.ref.classList.remove("error");
      }
    },
    setRemember: () => {
      const context = getContext();
      const el = getElement();

      context.remember = el.ref.checked;
    },
    renderLoginMsg: () => {
      const context = getContext();
      const el = getElement();

      el.ref.innerHTML = context.login_msg;
    }
  }
});
