parcelRequire=function(e,r,t,n){var i,o="function"==typeof parcelRequire&&parcelRequire,u="function"==typeof require&&require;function f(t,n){if(!r[t]){if(!e[t]){var i="function"==typeof parcelRequire&&parcelRequire;if(!n&&i)return i(t,!0);if(o)return o(t,!0);if(u&&"string"==typeof t)return u(t);var c=new Error("Cannot find module '"+t+"'");throw c.code="MODULE_NOT_FOUND",c}p.resolve=function(r){return e[t][1][r]||r},p.cache={};var l=r[t]=new f.Module(t);e[t][0].call(l.exports,p,l,l.exports,this)}return r[t].exports;function p(e){return f(p.resolve(e))}}f.isParcelRequire=!0,f.Module=function(e){this.id=e,this.bundle=f,this.exports={}},f.modules=e,f.cache=r,f.parent=o,f.register=function(r,t){e[r]=[function(e,r){r.exports=t},{}]};for(var c=0;c<t.length;c++)try{f(t[c])}catch(e){i||(i=e)}if(t.length){var l=f(t[t.length-1]);"object"==typeof exports&&"undefined"!=typeof module?module.exports=l:"function"==typeof define&&define.amd?define(function(){return l}):n&&(this[n]=l)}if(parcelRequire=f,i)throw i;return f}({"pMhP":[function(require,module,exports) {
const{i18n:{__:e,sprintf:t}}=wp,{dynamicWidgetBlock:s}=bp;class r extends s{loop(s=[],r="",d="active"){const i=super.useTemplate("bp-friends-item"),n=document.querySelector("#"+r);let o="";s&&s.length?s.forEach(s=>{if("active"===d&&s.last_activity)s.extra=t(e("Active %s","buddypress"),s.last_activity.timediff);else if("popular"===d&&s.total_friend_count){const r=parseInt(s.total_friend_count,10);s.extra=0===r?e("No friends","buddypress"):1===r?e("1 friend","buddypress"):t(e("%s friends","buddypress"),s.total_friend_count)}else"newest"===d&&s.registered_since&&(s.extra=t(e("Registered %s","buddypress"),s.registered_since));s.avatar_alt=t(e("Profile picture of %s","buddypress"),s.name),o+=i(s)}):o='<div class="widget-error">'+e("Sorry, no members were found.","buddypress")+"</div>",n.innerHTML=o}start(){this.blocks.forEach((e,t)=>{const{selector:s}=e,{type:r}=e.query_args,d=document.querySelector("#"+s).closest(".bp-dynamic-block-container");super.getItems(r,t),d.querySelectorAll(".item-options a").forEach(e=>{e.addEventListener("click",e=>{e.preventDefault(),e.target.closest(".item-options").querySelector(".selected").classList.remove("selected"),e.target.classList.add("selected");const s=e.target.getAttribute("data-bp-sort");s!==this.blocks[t].query_args.type&&super.getItems(s,t)})})})}}const d=window.bpFriendsSettings||{},i=window.bpFriendsBlocks||{},n=new r(d,i);"loading"===document.readyState?document.addEventListener("DOMContentLoaded",n.start()):n.start();
},{}]},{},["pMhP"], null)
//# sourceMappingURL=/bp-friends/js/friends.js.map