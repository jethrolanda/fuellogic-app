/**
 * WordPress dependencies
 */
import { store, getElement } from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  state: {
    get isSitesEmpty() {
      return state.sites.length <= 0 ? true : false;
    },
    get modalHeading() {
      switch (state.action) {
        case "add-site":
          return "Add new site";
        case "edit-site":
          return "Edit site";

        default:
          return "Add new site";
      }
    },
    get siteName() {
      return state.action == "add-site" ? "" : state.selectedSite.name;
    },
    get siteAddress() {
      return state.action == "add-site" ? "" : state.selectedSite.address;
    },
    get siteDeliverySchedule() {
      return state.action == "add-site"
        ? ""
        : state.selectedSite.delivery_schedule;
    },
    get siteDeliveryNotes() {
      return state.action == "add-site"
        ? ""
        : state.selectedSite.delivery_notes;
    }
  },
  actions: {
    *submitForm(e) {
      e.preventDefault();

      const { ref } = getElement();

      const formData = new FormData(ref);
      formData.append(
        "action",
        state.action == "add-site" ? "add_site" : "update_site"
      );
      formData.append("nonce", state.nonce);

      const data = yield fetch(state.ajaxUrl, {
        method: "POST",
        body: formData
      }).then((response) => response.json());

      state.sites = data.data;
    },
    *deleteSite() {
      var result = confirm("Are you sure?");
      if (result) {
        const formData = new FormData();
        formData.append("action", "delete_site");
        formData.append("nonce", state.nonce);
        formData.append("id", state.selectedSiteId);

        const data = yield fetch(state.ajaxUrl, {
          method: "POST",
          body: formData
        }).then((response) => response.json());

        state.sites = data.data;
      }
    }
  },
  callbacks: {
    openModal: () => {
      const { ref } = getElement();
      state.action = ref.dataset.action;

      var modal = document.getElementById("myModal");
      modal.style.display = "block";
      console.log(state.selectedSite);
    },
    closeModal: () => {
      var modal = document.getElementById("myModal");
      modal.style.display = "none";
    },
    selectSite: () => {
      const { ref } = getElement();

      let allLis = document.querySelectorAll("ul#sites-list li");
      // Iterate over all <li> elements inside <ul>
      allLis.forEach((li) => {
        li.classList.remove("selected");
      });

      ref.classList.add("selected");
      const selected = state.sites.filter(
        (site) => parseInt(site.id) === parseInt(ref.id)
      );
      state.selectedSiteId = ref.id;
      state.selectedSite = selected.length ? selected[0] : "";
    },
    sortSites: () => {
      if (!state.sorted) {
        state.sites = state.sites.sort((a, b) => {
          return a?.name.localeCompare(b?.name);
        });
        state.sorted = true;
      } else {
        state.sites = state.sites.reverse();
      }
    }
  }
});
