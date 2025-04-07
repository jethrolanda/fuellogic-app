/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

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
      console.log(selectedSite);
      context.siteDetails = selectedSite;
    }
  },
  callbacks: {
    toggleReviewed: (e) => {
      const context = getContext();
      context.isReviewed = e.target.checked;
    }
  }
});
