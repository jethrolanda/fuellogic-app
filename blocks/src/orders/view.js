/**
 * WordPress dependencies
 */
import { store, getContext } from "@wordpress/interactivity";

store("fuellogic-app", {
  actions: {
    openOrderStatus: () => {
      const context = getContext();
      console.log(context.orders_page + "?order_id=" + context.order_id);
      window.location.href =
        context.orders_page + "?order_id=" + context.order_id;
    }
  },
  callbacks: {
    logIsOpen: () => {
      const { isOpen } = getContext();
      // Log the value of `isOpen` each time it changes.
      console.log(`Is open: ${isOpen}`);
    },
    adjustSiteHeight: () => {
      var el = document.getElementById("orders-list");
      var space = window.innerHeight - el.offsetTop;
      el.style.height = space + "px";
    }
  }
});
