YUI.add("moodle-core-actionmenu",function(e,t){var n=e.one(e.config.doc.body),r={MENUSHOWN:"action-menu-shown"},i={CAN_RECEIVE_FOCUS_SELECTOR:'input:not([type="hidden"]), a[href], button, textarea, select, [tabindex]',MENU:".moodle-actionmenu[data-enhance=moodle-core-actionmenu]",MENUBAR:'[role="menubar"]',MENUITEM:'[role="menuitem"]',MENUCONTENT:".menu[data-rel=menu-content]",MENUCONTENTCHILD:"li a",MENUCHILD:".menu li a",TOGGLE:".toggle-display",KEEPOPEN:'[data-keepopen="1"]',MENUBARITEMS:['[role="menubar"] > [role="menuitem"]','[role="menubar"] > [role="presentation"] > [role="menuitem"]'],MENUITEMS:['> [role="menuitem"]','> [role="presentation"] > [role="menuitem"]']},s,o={TL:"tl",TR:"tr",BL:"bl",BR:"br"};s=function(){s.superclass.constructor.apply(this,arguments)},s.prototype={dialogue:null,events:[],owner:null,menulink:null,menuChildren:null,firstMenuChild:null,lastMenuChild:null,initializer:function(){e.all(i.MENU).each(this.enhance,this),n.delegate("key",this.moveMenuItem,"down:37,39",i.MENUBARITEMS.join(","),this),n.delegate("click",this.toggleMenu,i.MENU+" "+i.TOGGLE,this),n.delegate("key",this.showIfHidden,"down:enter,38,40",i.MENU+" "+i.TOGGLE,this),n.delegate("key",function(e){e.currentTarget.simulate("click"),e.preventDefault()},"down:32",i.MENUBARITEMS.join(","))},enhance:function(e){var t=e.one(i.MENUCONTENT),n;if(!t)return!1;n=t.getData("align")||this.get("align").join("-"),e.one(i.TOGGLE).set("aria-haspopup",!0),t.set("aria-hidden",!0),t.hasClass("align-"+n)||t.addClass("align-"+n),t.getDOMNode().childElementCount&&e.setAttribute("data-enhanced","1")},moveMenuItem:function(e){var t,n=e.target.ancestor(i.MENUITEM,!0);return e.keyCode===37?t=this.getMenuItem(n,!0):e.keyCode===39&&(t=this.getMenuItem(n)),t&&t.focus(),this},getMenuItem:function(e,t){var n=e.ancestor(i.MENUBAR),r,s;if(!n)return null;r=n.all(i.MENUITEMS.join(","));if(!r)return null;var o=r.size();if(o===1)return null;var u=0,a=1,f=0;for(u=0;u<o;u++)if(r.item(u)===e)break;if(r.item(u)!==e)return null;t&&(a=-1);do u+=a,s=r.item(u),f++;while(s&&s.hasAttribute("hidden"));return s},hideMenu:function(e){this.dialogue&&(this.dialogue.removeClass("show"),this.dialogue.one(i.MENUCONTENT).set("aria-hidden",!0),this.dialogue=null);for(var t in this.events)this.events[t].detach&&this.events[t].detach();this.events=[],this.owner&&(this.owner.removeClass(r.MENUSHOWN),this.owner=null),this.menulink&&(e.type!="click"&&this.menulink.focus(),this.menulink=null)},showIfHidden:function(e){var t=e.target.ancestor(i.MENU),n=t.hasClass("show");return n||(e.preventDefault(),this.showMenu(e,t)),this},toggleMenu:function(e){var t=e.target.ancestor(i.MENU),n=t.hasClass("show");e.halt(!0),this.hideMenu(e);if(n)return;this.showMenu(e,t)},handleKeyboardEvent:function(e){var t,n=function(e){e.preventDefault(),e.stopPropagation()};if(e.currentTarget.ancestor(i.TOGGLE,!0))return(e.keyCode===40||e.keyCode===9&&!e.shiftKey)&&this.firstMenuChild?(this.firstMenuChild.focus(),n(e)):e.keyCode===38&&this.lastMenuChild?(this.lastMenuChild.focus(),n(e)):e.keyCode===9&&e.shiftKey&&(this.hideMenu(e),n(e)),this;if(e.keyCode===27)this.hideMenu(e),n(e);else if(e.keyCode===32)n(e),e.currentTarget.simulate("click");else if(e.keyCode===9)e.target===this.firstMenuChild&&e.shiftKey?(this.hideMenu(e),n(e)):e.target===this.lastMenuChild&&!e.shiftKey&&this.hideMenu(e)&&(t=this.menulink.next(i.CAN_RECEIVE_FOCUS_SELECTOR),t&&(t.focus(),n(e)));else if(e.keyCode===38||e.keyCode===40){var r=!1,s=0,o=1,u=0;while(!r&&s<this.menuChildren.size())this.menuChildren.item(s)===e.currentTarget?r=!0:s++;if(!r)return;e.keyCode===38&&(o=-1);do s+=o,s<0?s=this.menuChildren.size()-1:s>=this.menuChildren.size()&&(s=0),t=this.menuChildren.item(s),u++;while(u<this.menuChildren.size()&&t!==e.currentTarget&&t.hasClass("hidden"));t&&(t.focus(),n(e))}},hideIfOutside:function(e){e.target.ancestor(i.MENUCONTENT,!0)||this.hideMenu(e)},showMenu:function(e,t){var s=t.getData("owner"),o=t.one(i.MENUCONTENT);return this.owner=s?t.ancestor(s):null,this.dialogue=t,t.addClass("show"),this.owner?(this.owner.addClass(r.MENUSHOWN),this.menulink=this.owner.one(i.TOGGLE)):this.menulink=e.target.ancestor(i.TOGGLE,!0),this.constrain(o.set("aria-hidden",!1)),this.menuChildren=this.dialogue.all(i.MENUCHILD),this.menuChildren.size()>0&&(this.firstMenuChild=this.menuChildren.item(0),this.lastMenuChild=this.menuChildren.item(this.menuChildren.size()-1),this.firstMenuChild.focus()),this.events.push(n.on("key",this.hideMenu,"esc",this)),this.events.push(n.on("click",this.hideIfOutside,this)),this.events.push(n.delegate("focus",this.hideIfOutside,"*",this)),this.events.push(t.delegate("key",this.handleKeyboardEvent,"down:9, 27, 38, 40, 32",i.MENUCHILD+", "+i.TOGGLE,this)),this.events.push(t.delegate("click",function(e){if(e.currentTarget.test(i.KEEPOPEN))return;this.hideMenu(e)},i.MENUCHILD,this)),!0},constrain:function(e){var t=e.getData("constraint"),n=e.getX(),r=e.getY(),i=e.get("offsetWidth"),s=e.get("offsetHeight"),o=0,u=0,a,f,l="auto",c=null,h=null,p=null,d=null,v=null;t&&(t=e.ancestor(t)),t?(a=t.get("offsetWidth"),f=t.get("offsetHeight"),o=t.getX(),u=t.getY(),l=t.getStyle("overflow")||"auto"):(a=e.get("docWidth"),f=e.get("docHeight")),i>a?(c=i=a,p=n=o):n<o?p=n=o:n+i>=o+a&&(p=o+a-i),s>f&&l.toLowerCase()==="hidden"&&(h=s=f,e.setStyle("overflow","auto"));if(r>=u&&r+s>u+f){d=u+f-s;try{v=e.getStyle("boxShadow").replace(/.*? (\d+)px \d+px$/,"$1"),(new RegExp(/^\d+$/)).test(v)&&d-u>v&&(d-=v)}catch(m){}}p!==null&&e.setX(p),d!==null&&e.setY(d),c!==null&&e.setStyle("width",c.toString()+"px"),h!==null&&e.setStyle("height",h.toString()+"px")}},e.extend(s,e.Base,s.prototype,{NAME:"moodle-core-actionmenu",ATTRS:{align:{value:[o.TR,o.BR]}}}),M.core=M.core||{},M.core.actionmenu=M.core.actionmenu||{},M.core.actionmenu.instance=null,M.core.actionmenu.init=M.core.actionmenu.init||function(e){M.core.actionmenu.instance=M.core.actionmenu.instance||new s(e)},M.core.actionmenu.newDOMNode=function(e){if(M.core.actionmenu.instance===
null)return!0;e.all(i.MENU).each(M.core.actionmenu.instance.enhance,M.core.actionmenu.instance)}},"@VERSION@",{requires:["base","event","node-event-simulate"]});
