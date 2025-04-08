/**
 * WordPress dependencies
 */
import {
  store,
  getContext,
  getElement,
  useEffect
} from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  state: {
    get gas_type_text() {
      const context = getContext();
      return context.gas_type_list[context.item];
    },
    get gas_type_qty() {
      const context = getContext();
      return context.siteDetails.data[`${context.item}_qty`];
    },
    get machines_text() {
      const context = getContext();
      return context.machines_list[context.item];
    },
    get machines_qty() {
      const context = getContext();
      return context.siteDetails.data[`${context.item}_qty`];
    }
  },
  actions: {
    showModal: () => {
      const el = document.body.querySelector(
        ".wp-block-fuellogic-app-reorder .modal"
      );
      if (el) el.style.display = "flex";
    },
    closeReorderModal: () => {
      const el = document.body.querySelector(
        ".wp-block-fuellogic-app-reorder .modal"
      );
      if (el) el.style.display = "none";
    },
    selectSite: (e) => {
      const context = getContext();

      const selectedSite = context.sites.find(
        (site) => parseInt(site.id) === parseInt(e.target.value)
      );
      context.siteDetails = selectedSite;

      context.isButtonDisabled =
        context.isReviewed == true && typeof selectedSite !== "undefined"
          ? false
          : true;
    },
    *submitNewOrder() {
      const context = getContext();
      const formData = new FormData();

      if (
        typeof context.siteDetails !== "undefined" &&
        context.siteDetails == ""
      ) {
        alert("Please select a site");
        return;
      }
      formData.append("action", "add_order_ajax");
      formData.append("data", JSON.stringify(context.siteDetails.data));
      formData.append("images", JSON.stringify(context.siteDetails.images));
      formData.append("gas_type", JSON.stringify(context.siteDetails.gas_type));
      formData.append("machines", JSON.stringify(context.siteDetails.machines));
      formData.append("nonce", state.nonce);

      const data = yield fetch(state.ajaxUrl, {
        method: "POST",
        body: formData
      }).then((response) => response.json());

      if (data.status == "success") {
        // Thank you page redirect
        window.location.href =
          context.thank_you_page + "?order_id=" + data?.order?.order_id;
      }
    }
  },
  callbacks: {
    toggleReviewed: (e) => {
      const context = getContext();
      context.isReviewed = e.target.checked;
      context.isButtonDisabled =
        e.target.checked == true && typeof context.siteDetails !== "undefined"
          ? false
          : true;
    },
    disableButton: () => {
      const context = getContext();
      useEffect(() => {
        const { ref } = getElement();
        if (ref == null) return;

        if (context.isButtonDisabled) {
          ref.classList.add("disabled");
          ref.setAttribute("disabled", "disabled");
        } else {
          ref.classList.remove("disabled");
          ref.removeAttribute("disabled");
        }
      }, [context.isButtonDisabled]);
    }
  }
});
