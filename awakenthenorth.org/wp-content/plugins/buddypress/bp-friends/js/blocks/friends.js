parcelRequire=function(e,r,t,n){var i,o="function"==typeof parcelRequire&&parcelRequire,u="function"==typeof require&&require;function f(t,n){if(!r[t]){if(!e[t]){var i="function"==typeof parcelRequire&&parcelRequire;if(!n&&i)return i(t,!0);if(o)return o(t,!0);if(u&&"string"==typeof t)return u(t);var c=new Error("Cannot find module '"+t+"'");throw c.code="MODULE_NOT_FOUND",c}p.resolve=function(r){return e[t][1][r]||r},p.cache={};var l=r[t]=new f.Module(t);e[t][0].call(l.exports,p,l,l.exports,this)}return r[t].exports;function p(e){return f(p.resolve(e))}}f.isParcelRequire=!0,f.Module=function(e){this.id=e,this.bundle=f,this.exports={}},f.modules=e,f.cache=r,f.parent=o,f.register=function(r,t){e[r]=[function(e,r){r.exports=t},{}]};for(var c=0;c<t.length;c++)try{f(t[c])}catch(e){i||(i=e)}if(t.length){var l=f(t[t.length-1]);"object"==typeof exports&&"undefined"!=typeof module?module.exports=l:"function"==typeof define&&define.amd?define(function(){return l}):n&&(this[n]=l)}if(parcelRequire=f,i)throw i;return f}({"CSIX":[function(require,module,exports) {
"use strict";Object.defineProperty(exports,"__esModule",{value:!0}),exports.TYPES=void 0;const{i18n:{__:e}}=wp,s=[{label:e("Newest","buddypress"),value:"newest"},{label:e("Active","buddypress"),value:"active"},{label:e("Popular","buddypress"),value:"popular"}];exports.TYPES=s;
},{}],"qXsY":[function(require,module,exports) {
"use strict";Object.defineProperty(exports,"__esModule",{value:!0}),exports.default=void 0;var e=require("./constants");const{blockEditor:{InspectorControls:t},components:{Disabled:n,PanelBody:r,RangeControl:l,SelectControl:o,ToggleControl:s},element:{Fragment:i,createElement:a},i18n:{__:d},serverSideRender:u}=wp,{blockData:{currentPostId:b}}=bp,p=({attributes:p,setAttributes:c})=>{const{postId:f,maxFriends:m,friendDefault:g,linkTitle:k}=p,v=b();return!f&&v&&c({postId:v}),a(i,null,a(t,null,a(r,{title:d("Settings","buddypress"),initialOpen:!0},a(l,{label:d("Max friends to show","buddypress"),value:m,onChange:e=>c({maxFriends:e}),min:1,max:10,required:!0}),a(o,{label:d("Default members to show","buddypress"),value:g,options:e.TYPES,onChange:e=>{c({friendDefault:e})}}),a(s,{label:d("Link block title to Member's profile friends page","buddypress"),checked:!!k,onChange:()=>{c({linkTitle:!k})}}))),a(n,null,a(u,{block:"bp/friends",attributes:p})))};var c=p;exports.default=c;
},{"./constants":"CSIX"}],"fch3":[function(require,module,exports) {
"use strict";Object.defineProperty(exports,"__esModule",{value:!0}),exports.default=void 0;const{blocks:{createBlock:e}}=wp,r={from:[{type:"block",blocks:["core/legacy-widget"],isMatch:({idBase:e,instance:r})=>!(null==r||!r.raw)&&"bp_core_friends_widget"===e,transform:({instance:r})=>e("bp/friends",{maxFriends:r.raw.max_friends,friendDefault:r.raw.friend_default,linkTitle:r.raw.link_title})}]};var t=r;exports.default=t;
},{}],"Z2R5":[function(require,module,exports) {
"use strict";var e=r(require("./friends/edit")),t=r(require("./friends/transforms"));function r(e){return e&&e.__esModule?e:{default:e}}const{blocks:{registerBlockType:d},i18n:{__:s}}=wp;d("bp/friends",{title:s("Friends List","buddypress"),description:s("A dynamic list of recently active, popular, and newest friends of the post author (when used into a page or post) or of the displayed member (when used in a widgetized area). If author/member data is not available the block is not displayed.","buddypress"),icon:{background:"#fff",foreground:"#d84800",src:"buddicons-friends"},category:"buddypress",attributes:{maxFriends:{type:"number",default:5},friendDefault:{type:"string",default:"active"},linkTitle:{type:"boolean",default:!1},postId:{type:"number",default:0}},edit:e.default,transforms:t.default});
},{"./friends/edit":"qXsY","./friends/transforms":"fch3"}]},{},["Z2R5"], null)
//# sourceMappingURL=/bp-friends/js/blocks/friends.js.map