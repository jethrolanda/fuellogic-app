(()=>{"use strict";var e,n={563:()=>{const e=window.wp.blocks,n=window.wp.coreData,s=window.wp.data,t=window.wp.components,o=window.wp.primitives,a=window.ReactJSXRuntime,l=(0,a.jsx)(o.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,a.jsx)(o.Path,{d:"m11.3 17.2-5-5c-.1-.1-.1-.3 0-.4l2.3-2.3-1.1-1-2.3 2.3c-.7.7-.7 1.8 0 2.5l5 5H7.5v1.5h5.3v-5.2h-1.5v2.6zm7.5-6.4-5-5h2.7V4.2h-5.2v5.2h1.5V6.8l5 5c.1.1.1.3 0 .4l-2.3 2.3 1.1 1.1 2.3-2.3c.6-.7.6-1.9-.1-2.5z"})}),i=(0,a.jsx)(o.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,a.jsx)(o.Path,{d:"m19 7-3-3-8.5 8.5-1 4 4-1L19 7Zm-7 11.5H5V20h7v-1.5Z"})}),r=(window.wp.i18n,window.wp.blockEditor);function c(e){const{data:n}=e;return n.map(((e,n)=>(0,a.jsx)("li",{class:" "+(0===n?"selected":"")}))),(0,a.jsx)(a.Fragment,{children:"FL Mobile Menu"})}const d=JSON.parse('{"UU":"fuellogic-app/mobile-menu"}');(0,e.registerBlockType)(d.UU,{edit:function(e){const{pages:o,hasResolved:d}=function(e){const{pages:t,hasResolved:o}=(0,s.useSelect)((e=>{const s=["postType","page",{per_page:-1}];return{pages:e(n.store).getEntityRecords(...s),hasResolved:e(n.store).hasFinishedResolution("getEntityRecords",s)}}),[e]);return{pages:t,hasResolved:o}}(e),p=o?o.map((e=>({value:e.id,label:e.title.raw}))):[];p.unshift({value:"none",label:"Select a Page"});const h=(0,r.useBlockProps)(),{attributes:u,setAttributes:x}=e,{editMode:w}=u;function v(){x({editMode:!w})}return(0,a.jsxs)("div",{...h,children:[(0,a.jsx)(r.BlockControls,{children:w?(0,a.jsx)(t.ToolbarButton,{icon:l,label:"View",onClick:()=>v()}):(0,a.jsx)(t.ToolbarButton,{icon:i,label:"Edit",onClick:()=>v()})}),w?(0,a.jsx)(t.Flex,{children:(0,a.jsxs)(t.FlexBlock,{style:{gap:"20px"},children:[u.data.map((function(e,n){return(0,a.jsxs)("div",{children:[(0,a.jsxs)("h4",{children:["Menu #",n+1]}),d?(0,a.jsxs)(a.Fragment,{children:[(0,a.jsxs)(t.BaseControl,{help:"Only class name example: fa-solid fa-map",children:[(0,a.jsx)(t.BaseControl.VisualLabel,{children:"Fontawesome Class"}),(0,a.jsx)(t.TextControl,{value:e?.fa_class,onChange:e=>{const s=u.data.concat([]);s[n]={...s[n],fa_class:e},x({data:s})}})]}),(0,a.jsxs)(t.BaseControl,{children:[(0,a.jsx)(t.BaseControl.VisualLabel,{children:"Page"}),(0,a.jsx)(t.SelectControl,{value:e?.page,options:p,onChange:e=>{const s=u.data.concat([]);s[n]={...s[n],page:e},x({data:s})}})]})]}):(0,a.jsxs)("div",{style:{marginBottom:"10px"},children:["Loading pages",(0,a.jsx)(t.Spinner,{})]}),(0,a.jsx)(t.BaseControl,{children:(0,a.jsx)("a",{className:"custom-btn btn-delete",onClick:()=>function(e){const n=u.data.filter((function(n,s){return s!=e}));x({data:n})}(n),children:"Remove Menu"})})]})})),(0,a.jsx)("a",{className:"custom-btn btn-add",onClick:()=>{x({data:u.data.concat([void 0])})},children:"Add New Menu"})]})}):(0,a.jsx)(c,{data:u.data})]})}})}},s={};function t(e){var o=s[e];if(void 0!==o)return o.exports;var a=s[e]={exports:{}};return n[e](a,a.exports,t),a.exports}t.m=n,e=[],t.O=(n,s,o,a)=>{if(!s){var l=1/0;for(d=0;d<e.length;d++){for(var[s,o,a]=e[d],i=!0,r=0;r<s.length;r++)(!1&a||l>=a)&&Object.keys(t.O).every((e=>t.O[e](s[r])))?s.splice(r--,1):(i=!1,a<l&&(l=a));if(i){e.splice(d--,1);var c=o();void 0!==c&&(n=c)}}return n}a=a||0;for(var d=e.length;d>0&&e[d-1][2]>a;d--)e[d]=e[d-1];e[d]=[s,o,a]},t.o=(e,n)=>Object.prototype.hasOwnProperty.call(e,n),(()=>{var e={258:0,846:0};t.O.j=n=>0===e[n];var n=(n,s)=>{var o,a,[l,i,r]=s,c=0;if(l.some((n=>0!==e[n]))){for(o in i)t.o(i,o)&&(t.m[o]=i[o]);if(r)var d=r(t)}for(n&&n(s);c<l.length;c++)a=l[c],t.o(e,a)&&e[a]&&e[a][0](),e[a]=0;return t.O(d)},s=globalThis.webpackChunkblocks=globalThis.webpackChunkblocks||[];s.forEach(n.bind(null,0)),s.push=n.bind(null,s.push.bind(s))})();var o=t.O(void 0,[846],(()=>t(563)));o=t.O(o)})();