import*as e from"@wordpress/interactivity";var t={d:(e,r)=>{for(var o in r)t.o(r,o)&&!t.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:r[o]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const r=(a={getContext:()=>e.getContext,getElement:()=>e.getElement,store:()=>e.store},c={},t.d(c,a),c),{actions:o}=(0,r.store)("fuellogic-app",{actions:{onChange:()=>{const e=(0,r.getContext)(),{ref:t}=(0,r.getElement)();Array.from(document.querySelectorAll("ul.indicators li")).forEach((e=>e.classList.remove("active"))),t.classList.add("active"),e.current=e.id,e.data=e.data.map((t=>t.id===e.id?{...t,selected:!0}:{...t,selected:!1})),Array.from(document.querySelectorAll(".slider")).forEach(((t,r)=>{t.classList.remove("active"),r===e.current&&t.classList.add("active")})),e.current+1===e.data.length?e.next="GET STARTED":e.next="NEXT"},previous:()=>{const e=(0,r.getContext)();e.current>0&&e.current+1<=e.data.length&&(e.current-=1),Array.from(document.querySelectorAll(".slider")).forEach(((t,r)=>{t.classList.remove("active"),r===e.current&&t.classList.add("active")})),Array.from(document.querySelectorAll("ul.indicators li")).forEach(((t,r)=>{t.classList.remove("active"),r===e.current&&t.classList.add("active")})),e.data=e.data.map((t=>t.id===e.current?{...t,selected:!0}:{...t,selected:!1})),e.current+1===e.data.length?e.next="GET STARTED":e.next="NEXT"},next:()=>{const e=(0,r.getContext)();e.current+1<e.data.length&&(e.current+=1),"GET STARTED"===e.next&&(window.location.href=window.location.origin+"/login"),e.current+1===e.data.length?e.next="GET STARTED":e.next="NEXT",Array.from(document.querySelectorAll(".slider")).forEach(((t,r)=>{t.classList.remove("active"),r===e.current&&t.classList.add("active")})),Array.from(document.querySelectorAll("ul.indicators li")).forEach(((t,r)=>{t.classList.remove("active"),r===e.current&&t.classList.add("active")})),e.data=e.data.map((t=>t.id===e.current?{...t,selected:!0}:{...t,selected:!1}))},getStarted:()=>{(0,r.getContext)().step=1},onKeyDown:e=>{switch(e.key){case"ArrowLeft":o.previous();break;case"ArrowRight":o.next()}}},callbacks:{logIsOpen:()=>{const{isOpen:e}=(0,r.getContext)();console.log(`Is open: ${e}`)},bgImage:()=>{const e=(0,r.getContext)(),t=e.data.find((t=>t.id===e.current));document.body.style.backgroundImage="url('"+t.image+"')",document.body.style.backgroundSize="cover",document.body.style.backgroundPosition="center top",document.body.style.backgroundRepeat="no-repeat";const o=document.getElementsByClassName("mobile-images");o.length>0&&(o[0].style.backgroundImage="url('"+t.image+"')",o[0].style.backgroundSize="cover",o[0].style.backgroundPosition="center top",o[0].style.backgroundRepeat="no-repeat",o[0].style.height="330px",o[0].innerHTML="")}}});var a,c;