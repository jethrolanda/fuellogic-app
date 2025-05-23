/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  actions: {
    *closeFirstDeliveryModal(e) {
      const context = getContext();

      const formData = new FormData();

      formData.append("action", "close_first_delivery_modal");
      formData.append("_ajax_nonce", state.nonce);

      // Optimistic update
      const el = document.body.querySelector(
        ".wp-block-fuellogic-app-first-delivery-modal .modal"
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
    clicked: () => {
      const context = getContext();
      alert(state.selectedSite);
    }
  }
});
