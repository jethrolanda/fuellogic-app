(()=>{"use strict";var e,t={126:()=>{const e=window.wp.blocks,t=window.wp.coreData,n=window.wp.data,s=window.wp.components,o=(window.wp.i18n,window.wp.blockEditor),r=window.ReactJSXRuntime,i=JSON.parse('{"UU":"fuellogic-app/signup"}');(0,e.registerBlockType)(i.UU,{edit:function(e){const i=(0,o.useBlockProps)(),{pages:a,hasResolved:l}=function(e){const{pages:s,hasResolved:o}=(0,n.useSelect)((e=>{const n=["postType","page",{per_page:-1}];return{pages:e(t.store).getEntityRecords(...n),hasResolved:e(t.store).hasFinishedResolution("getEntityRecords",n)}}),[e]);return{pages:s,hasResolved:o}}(e),c=a?a.map((e=>({value:e.id,label:e.title.raw}))):[];c.unshift({value:"none",label:"Select a Page"});const{attributes:p,setAttributes:d}=e,{loginRedirect:u}=p;return(0,r.jsxs)("div",{...i,children:[(0,r.jsx)(o.InspectorControls,{children:(0,r.jsx)(s.PanelBody,{title:"Settings",initialOpen:!0,children:l?(0,r.jsx)(r.Fragment,{children:(0,r.jsx)(s.SelectControl,{label:"Login Redirect",value:parseInt(u)>0?u:"none",options:c,onChange:e=>{d({loginRedirect:e})}})}):(0,r.jsxs)("div",{style:{marginBottom:"10px"},children:["Loading Patterns",(0,r.jsx)(s.Spinner,{})]})})}),(0,r.jsxs)("form",{action:"#",children:[(0,r.jsxs)("label",{for:"has_account",children:[(0,r.jsx)("input",{type:"checkbox",id:"has_account"})," My company currently has an account"]}),(0,r.jsx)("input",{type:"text",placeholder:"Company Name"}),(0,r.jsx)("input",{type:"text",placeholder:"First Name"}),(0,r.jsx)("input",{type:"text",placeholder:"Last Name"}),(0,r.jsx)("input",{type:"email",placeholder:"Email Address"}),(0,r.jsx)("input",{type:"text",placeholder:"Mobile Number"}),(0,r.jsx)("input",{type:"password",placeholder:"Password"}),(0,r.jsx)("div",{class:"remember",children:(0,r.jsxs)("label",{for:"terms_conditions_agreement",children:[(0,r.jsx)("input",{type:"checkbox",id:"terms_conditions_agreement"})," I agree with Terms of Service"]})}),(0,r.jsx)("button",{children:"SIGN UP"})]})]})}})}},n={};function s(e){var o=n[e];if(void 0!==o)return o.exports;var r=n[e]={exports:{}};return t[e](r,r.exports,s),r.exports}s.m=t,e=[],s.O=(t,n,o,r)=>{if(!n){var i=1/0;for(p=0;p<e.length;p++){for(var[n,o,r]=e[p],a=!0,l=0;l<n.length;l++)(!1&r||i>=r)&&Object.keys(s.O).every((e=>s.O[e](n[l])))?n.splice(l--,1):(a=!1,r<i&&(i=r));if(a){e.splice(p--,1);var c=o();void 0!==c&&(t=c)}}return t}r=r||0;for(var p=e.length;p>0&&e[p-1][2]>r;p--)e[p]=e[p-1];e[p]=[n,o,r]},s.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={554:0,550:0};s.O.j=t=>0===e[t];var t=(t,n)=>{var o,r,[i,a,l]=n,c=0;if(i.some((t=>0!==e[t]))){for(o in a)s.o(a,o)&&(s.m[o]=a[o]);if(l)var p=l(s)}for(t&&t(n);c<i.length;c++)r=i[c],s.o(e,r)&&e[r]&&e[r][0](),e[r]=0;return s.O(p)},n=globalThis.webpackChunkblocks=globalThis.webpackChunkblocks||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))})();var o=s.O(void 0,[550],(()=>s(126)));o=s.O(o)})();