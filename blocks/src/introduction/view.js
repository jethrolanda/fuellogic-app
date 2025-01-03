/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from "@wordpress/interactivity";

const { actions } = store("fuellogic-app", {
  actions: {
    onChange: () => {
      const context = getContext();
      const { ref } = getElement();

      Array.from(document.querySelectorAll("ul.indicators li")).forEach((li) =>
        li.classList.remove("active")
      );
      ref.classList.add("active");
      context.current = context.id;
      context.data = context.data.map((item) => {
        if (item.id === context.id) {
          return {
            ...item,
            selected: true
          };
        } else {
          return {
            ...item,
            selected: false
          };
        }
      });

      Array.from(document.querySelectorAll(".slider")).forEach((slide, i) => {
        slide.classList.remove("active");
        if (i === context.current) {
          slide.classList.add("active");
        }
      });

      if (context.current + 1 === context.data.length) {
        context.next = "GET STARTED";
      } else {
        context.next = "NEXT";
      }
    },
    previous: () => {
      const context = getContext();
      if (context.current > 0 && context.current + 1 <= context.data.length) {
        context.current -= 1;
      }

      Array.from(document.querySelectorAll(".slider")).forEach((slide, i) => {
        slide.classList.remove("active");
        if (i === context.current) {
          slide.classList.add("active");
        }
      });

      Array.from(document.querySelectorAll("ul.indicators li")).forEach(
        (li, i) => {
          li.classList.remove("active");
          if (i === context.current) {
            li.classList.add("active");
          }
        }
      );
      context.data = context.data.map((item) => {
        if (item.id === context.current) {
          return {
            ...item,
            selected: true
          };
        } else {
          return {
            ...item,
            selected: false
          };
        }
      });
      if (context.current + 1 === context.data.length) {
        context.next = "GET STARTED";
      } else {
        context.next = "NEXT";
      }
    },
    next: () => {
      const context = getContext();

      if (context.current + 1 < context.data.length) {
        context.current += 1;
      }

      if (context.next === "GET STARTED") {
        window.location.href = window.location.origin + "/login";
        // const { router } = yield import("@wordpress/interactivity-router");
        // console.log(router);
        // yield router.navigate(e.target.href);
      }

      if (context.current + 1 === context.data.length) {
        context.next = "GET STARTED";
      } else {
        context.next = "NEXT";
      }

      Array.from(document.querySelectorAll(".slider")).forEach((slide, i) => {
        slide.classList.remove("active");
        if (i === context.current) {
          slide.classList.add("active");
        }
      });

      Array.from(document.querySelectorAll("ul.indicators li")).forEach(
        (li, i) => {
          li.classList.remove("active");
          if (i === context.current) {
            li.classList.add("active");
          }
        }
      );
      context.data = context.data.map((item) => {
        if (item.id === context.current) {
          return {
            ...item,
            selected: true
          };
        } else {
          return {
            ...item,
            selected: false
          };
        }
      });
    },
    getStarted: () => {
      const context = getContext();
      context.step = 1;
    },
    onKeyDown: (e) => {
      switch (e.key) {
        case "ArrowLeft": {
          actions.previous();
          break;
        }
        case "ArrowRight": {
          actions.next();
          break;
        }
      }
    }
  },
  callbacks: {
    logIsOpen: () => {
      const { isOpen } = getContext();
      // Log the value of `isOpen` each time it changes.
      console.log(`Is open: ${isOpen}`);
    },
    bgImage: () => {
      const context = getContext();
      const found = context.data.find(
        (element) => element.id === context.current
      );
      document.body.style.backgroundImage = "url('" + found.image + "')";
      document.body.style.backgroundSize = "cover";
      document.body.style.backgroundPosition = "center top";
      document.body.style.backgroundRepeat = "no-repeat";
    }
  }
});
