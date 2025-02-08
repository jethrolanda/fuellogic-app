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
    bgImage: () => {
      const context = getContext();
      const found = context.data.find(
        (element, index) => index === context.current
      );

      document.body.style.backgroundImage = "url('" + found.bg_image.url + "')";
      document.body.style.backgroundSize = "cover";
      document.body.style.backgroundPosition = "center top";
      document.body.style.backgroundRepeat = "no-repeat";

      const test = document.getElementsByClassName("mobile-images");
      if (test.length > 0) {
        test[0].style.backgroundImage = "url('" + found.bg_image.url + "')";
        test[0].style.backgroundSize = "cover";
        test[0].style.backgroundPosition = "center top";
        test[0].style.backgroundRepeat = "no-repeat";
        test[0].style.height = "330px";
        test[0].innerHTML = "";
      }
    }
  }
});
