import*as e from"@wordpress/interactivity";var t={d:(e,o)=>{for(var s in o)t.o(o,s)&&!t.o(e,s)&&Object.defineProperty(e,s,{enumerable:!0,get:o[s]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const o=(r={getContext:()=>e.getContext,store:()=>e.store},a={},t.d(a,r),a),{state:s}=(0,o.store)("fuellogic-app",{state:{get gas_type_text(){const e=(0,o.getContext)();return e.gas_type_list[e.item]},get gas_type_qty(){const e=(0,o.getContext)();return e.siteDetails.data[`${e.item}_qty`]},get machines_text(){const e=(0,o.getContext)();return e.machines_list[e.item]},get machines_qty(){const e=(0,o.getContext)();return e.siteDetails.data[`${e.item}_qty`]}},actions:{showModal:()=>{const e=document.body.querySelector(".wp-block-fuellogic-app-reorder .modal");e&&(e.style.display="flex")},closeReorderModal:()=>{const e=document.body.querySelector(".wp-block-fuellogic-app-reorder .modal");e&&(e.style.display="none")},selectSite:e=>{const t=(0,o.getContext)(),s=t.sites.find((t=>parseInt(t.id)===parseInt(e.target.value)));console.log(s),t.siteDetails=s}},callbacks:{toggleReviewed:e=>{(0,o.getContext)().isReviewed=e.target.checked}}});var r,a;