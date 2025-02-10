/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  actions: {
    toggle: () => {
      const context = getContext();
      context.isOpen = !context.isOpen;
    },
    *logout(e) {
      e.preventDefault();
      const context = getContext();

      const formData = new FormData();

      formData.append("action", "fla_logout");
      formData.append("_ajax_nonce", state.nonce);

      const data = yield fetch(state.ajaxUrl, {
        method: "POST",
        body: formData
      }).then((response) => response.json());

      if (data.status == "success") {
        // Login redirect
        window.location.href = state.logout_redirect;
      }
    }
  },
  callbacks: {
    showHideMenu: () => {
      const { ref } = getElement();
      const context = getContext();
      context.showMenu = !context.showMenu;
    }
  }
});
