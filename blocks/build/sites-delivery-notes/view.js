import*as e from"@wordpress/interactivity";var t={d:(e,o)=>{for(var r in o)t.o(o,r)&&!t.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:o[r]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t)};const o=(a={getContext:()=>e.getContext,store:()=>e.store},c={},t.d(c,a),c),{state:r}=(0,o.store)("fuellogic-app",{actions:{},callbacks:{clicked:()=>{(0,o.getContext)(),alert(r.selectedSite)}}});var a,c;