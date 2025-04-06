/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  actions: {
    *closeModal(e) {
      e.preventDefault();
      const context = getContext();

      const formData = new FormData();

      formData.append("action", "close_thank_you_modal");
      formData.append("_ajax_nonce", state.nonce);
      formData.append("order_id", context.order_id);

      const data = yield fetch(state.ajaxUrl, {
        method: "POST",
        body: formData
      }).then((response) => response.json());

      console.log(data);
      if (data.status == "success") {
        // Close the modal
        document.getElementsByClassName("modal")[0].style.display = "none";
      }
    }
  },
  callbacks: {}
});
