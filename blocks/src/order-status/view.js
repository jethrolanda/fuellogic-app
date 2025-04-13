/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  actions: {
    *changeStatus() {
      const context = getContext();

      const formData = new FormData();

      formData.append("action", "update_order_status");
      formData.append("order_status", context.status);
      formData.append("order_id", context.order_id);
      formData.append("nonce", state.nonce);

      const data = yield fetch(state.ajaxUrl, {
        method: "POST",
        body: formData
      }).then((response) => response.json());

      if (data.status == "success") {
        const status = document.querySelectorAll(
          ` .wp-block-fuellogic-app-order-status .status-wrapper div.status`
        );
        // Change status
        if (status.length > 0) {
          const classes = status[0].classList;
          status[0].classList.remove(classes[1]);
          status[0].classList.add(context.status);
        }
        // Change map
        if (context.status == "out-for-delivery") {
          document.getElementById("map1").style.display = "block";
          document.getElementById("map2").style.display = "none";
        } else {
          document.getElementById("map1").style.display = "none";
          document.getElementById("map2").style.display = "block";
        }

        // Show first delivery modal
        if (!data.isFirstDelivery) {
          const firstDeliveryModal = document.body.querySelector(
            ".wp-block-fuellogic-app-first-delivery-modal .modal"
          );
          if (firstDeliveryModal) firstDeliveryModal.style.display = "grid";
        }

        // Show fuel delivered modal
        if (!data.isFuelDelivered) {
          const fuelDeliveredModal = document.body.querySelector(
            ".wp-block-fuellogic-app-fuel-delivered-modal .modal"
          );
          if (fuelDeliveredModal) fuelDeliveredModal.style.display = "grid";
        }
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
