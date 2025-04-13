/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  actions: {
    *closeThankyouModal(e) {
      const context = getContext();

      const formData = new FormData();

      formData.append("action", "close_thank_you_modal");
      formData.append("_ajax_nonce", state.nonce);
      formData.append("order_id", context.order_id);

      // Optimistic update
      const el = document.body.querySelector(
        ".wp-block-fuellogic-app-thank-you-modal .modal"
      );
      if (el) el.style.display = "none";

      const data = yield fetch(state.ajaxUrl, {
        method: "POST",
        body: formData
      }).then((response) => response.json());

      if (data.status == "success") {
        // Close the modal
        if (el) el.style.display = "none";
      } else {
        if (el) el.style.display = "grid";
      }
    }
  },
  callbacks: {
    test: (e) => {
      console.log("test");
    }
  }
});
