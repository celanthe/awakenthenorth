(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[10,13],{284:function(e,t){},297:function(e,t,a){"use strict";a.r(t);var c=a(0),n=(a(8),a(1)),l=a(5),r=a.n(l),o=a(37),s=a(65),i=a(134);a(284),t.default=Object(i.withProductDataContext)(e=>{let{className:t,align:a}=e;const{parentClassName:l}=Object(s.useInnerBlockLayoutContext)(),{product:i}=Object(s.useProductDataContext)();if(!i.id||!i.on_sale)return null;const u="string"==typeof a?"wc-block-components-product-sale-badge--align-"+a:"";return Object(c.createElement)("div",{className:r()("wc-block-components-product-sale-badge",t,u,{[l+"__product-onsale"]:l})},Object(c.createElement)(o.a,{label:Object(n.__)("Sale",'woocommerce'),screenReaderLabel:Object(n.__)("Product on sale",'woocommerce')}))})},316:function(e,t){},37:function(e,t,a){"use strict";var c=a(0),n=a(5),l=a.n(n);t.a=e=>{let t,{label:a,screenReaderLabel:n,wrapperElement:r,wrapperProps:o={}}=e;const s=null!=a,i=null!=n;return!s&&i?(t=r||"span",o={...o,className:l()(o.className,"screen-reader-text")},Object(c.createElement)(t,o,n)):(t=r||c.Fragment,s&&i&&a!==n?Object(c.createElement)(t,o,Object(c.createElement)("span",{"aria-hidden":"true"},a),Object(c.createElement)("span",{className:"screen-reader-text"},n)):Object(c.createElement)(t,o,a))}},386:function(e,t,a){"use strict";a.r(t);var c=a(134),n=a(18),l=a.n(n),r=a(0),o=(a(8),a(1)),s=a(5),i=a.n(s),u=a(2),d=a(65),b=a(42),m=a(297);a(316);const p=()=>Object(r.createElement)("img",{src:u.PLACEHOLDER_IMG_SRC,alt:"",width:500,height:500}),g=e=>{let{image:t,onLoad:a,loaded:c,showFullSize:n,fallbackAlt:o}=e;const{thumbnail:s,src:i,srcset:u,sizes:d,alt:b}=t||{},m={alt:b||o,onLoad:a,hidden:!c,src:s,...n&&{src:i,srcSet:u,sizes:d}};return Object(r.createElement)(r.Fragment,null,m.src&&Object(r.createElement)("img",l()({"data-testid":"product-image"},m)),!c&&Object(r.createElement)(p,null))};var O=Object(c.withProductDataContext)(e=>{let{className:t,imageSizing:a="full-size",showProductLink:c=!0,showSaleBadge:n,saleBadgeAlign:l="right"}=e;const{parentClassName:s}=Object(d.useInnerBlockLayoutContext)(),{product:u}=Object(d.useProductDataContext)(),[O,j]=Object(r.useState)(!1),{dispatchStoreEvent:w}=Object(b.a)();if(!u.id)return Object(r.createElement)("div",{className:i()(t,"wc-block-components-product-image","wc-block-components-product-image--placeholder",{[s+"__product-image"]:s})},Object(r.createElement)(p,null));const f=!!u.images.length,h=f?u.images[0]:null,k=c?"a":r.Fragment,E=Object(o.sprintf)(
/* translators: %s is referring to the product name */
Object(o.__)("Link to %s",'woocommerce'),u.name),_={href:u.permalink,rel:"nofollow",...!f&&{"aria-label":E},onClick:()=>{w("product-view-link",{product:u})}};return Object(r.createElement)("div",{className:i()(t,"wc-block-components-product-image",{[s+"__product-image"]:s})},Object(r.createElement)(k,c&&_,!!n&&Object(r.createElement)(m.default,{align:l,product:u}),Object(r.createElement)(g,{fallbackAlt:u.name,image:h,onLoad:()=>j(!0),loaded:O,showFullSize:"cropped"!==a})))});t.default=Object(c.withFilteredAttributes)({showProductLink:{type:"boolean",default:!0},showSaleBadge:{type:"boolean",default:!0},saleBadgeAlign:{type:"string",default:"right"},imageSizing:{type:"string",default:"full-size"},productId:{type:"number",default:0}})(O)}}]);