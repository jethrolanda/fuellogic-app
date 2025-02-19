/**
 * WordPress dependencies
 */
import { store, getElement } from "@wordpress/interactivity";

const { state } = store("fuellogic-app", {
  state: {
    get isSitesEmpty() {
      return state.sites.length <= 0 ? true : false;
    }
  },
  actions: {
    *submitForm(e) {
      e.preventDefault();

      const { ref } = getElement();

      const formData = new FormData(ref);
      formData.append("action", "add_site");
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
      var modal = document.getElementById("myModal");
      modal.style.display = "block";
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
        console.log(1);
      } else {
        console.log(2);
        state.sites = state.sites.reverse();
      }
    }
  }
});
