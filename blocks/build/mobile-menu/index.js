(()=>{"use strict";var e,t={206:()=>{const e=window.wp.blocks,t=window.wp.coreData,n=window.wp.data,o=window.wp.components,r=(window.wp.i18n,window.wp.blockEditor),s=window.ReactJSXRuntime,i=JSON.parse('{"UU":"fuellogic-app/mobile-menu"}');(0,e.registerBlockType)(i.UU,{edit:function(e){const{patterns:i,hasResolved:a}=function(e){const{patterns:o,hasResolved:r}=(0,n.useSelect)((e=>{const n=["postType","wp_block",{per_page:-1}];return{patterns:e(t.store).getEntityRecords(...n),hasResolved:e(t.store).hasFinishedResolution("getEntityRecords",n)}}),[e]);return{patterns:o,hasResolved:r}}(e),l=i?i.map((e=>({value:e.id,label:e.title.raw}))):[];l.unshift({value:"none",label:"Select a Pattern"});const c=(0,r.useBlockProps)(),{attributes:p,setAttributes:d}=e,{mobileMenuPattern:u}=p;return(0,s.jsxs)("div",{...c,children:[(0,s.jsx)(r.InspectorControls,{children:(0,s.jsx)(o.PanelBody,{title:"Settings",initialOpen:!0,children:a?(0,s.jsx)(s.Fragment,{children:(0,s.jsx)(o.SelectControl,{label:"Loading Screen Pattern",value:parseInt(u)>0?u:"none",options:l,onChange:function(e){d({mobileMenuPattern:e})}})}):(0,s.jsxs)("div",{style:{marginBottom:"10px"},children:["Loading Patterns",(0,s.jsx)(o.Spinner,{})]})})}),(0,s.jsx)("div",{children:"FL Mobile Menu"})]})}})}},n={};function o(e){var r=n[e];if(void 0!==r)return r.exports;var s=n[e]={exports:{}};return t[e](s,s.exports,o),s.exports}o.m=t,e=[],o.O=(t,n,r,s)=>{if(!n){var i=1/0;for(p=0;p<e.length;p++){for(var[n,r,s]=e[p],a=!0,l=0;l<n.length;l++)(!1&s||i>=s)&&Object.keys(o.O).every((e=>o.O[e](n[l])))?n.splice(l--,1):(a=!1,s<i&&(i=s));if(a){e.splice(p--,1);var c=r();void 0!==c&&(t=c)}}return t}s=s||0;for(var p=e.length;p>0&&e[p-1][2]>s;p--)e[p]=e[p-1];e[p]=[n,r,s]},o.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={258:0,846:0};o.O.j=t=>0===e[t];var t=(t,n)=>{var r,s,[i,a,l]=n,c=0;if(i.some((t=>0!==e[t]))){for(r in a)o.o(a,r)&&(o.m[r]=a[r]);if(l)var p=l(o)}for(t&&t(n);c<i.length;c++)s=i[c],o.o(e,s)&&e[s]&&e[s][0](),e[s]=0;return o.O(p)},n=globalThis.webpackChunkblocks=globalThis.webpackChunkblocks||[];n.forEach(t.bind(null,0)),n.push=t.bind(null,n.push.bind(n))})();var r=o.O(void 0,[846],(()=>o(206)));r=o.O(r)})();