/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./.dev/assets/admin/js/customize/preview/color-schemes.js":
/*!*****************************************************************!*\
  !*** ./.dev/assets/admin/js/customize/preview/color-schemes.js ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _util__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../util */ "./.dev/assets/admin/js/customize/util.js");

const $ = jQuery;
/* harmony default export */ __webpack_exports__["default"] = (() => {
  let selectedDesignStyle = GoPreviewData.selectedDesignStyle;
  /**
   * Set color
   *
   * @param {*} color
   * @param {*} cssVar
   */

  const setColor = (color, cssVar) => {
    const hsl = (0,_util__WEBPACK_IMPORTED_MODULE_0__.hexToHSL)(color);
    document.querySelector(':root').style.setProperty(`${cssVar}`, `hsl(${hsl[0]}, ${hsl[1]}%, ${hsl[2]}%)`);
  };
  /**
   * Load the color schemes for the selected design style.
   *
   * @param {*} colorScheme
   */


  const loadColorSchemes = colorScheme => {
    const designStyle = getDesignStyle(selectedDesignStyle);
    colorScheme = colorScheme.replace(`${selectedDesignStyle}-`, '');

    if ('undefined' !== typeof designStyle.color_schemes[colorScheme] && 'undefined' !== typeof wp.customize.settings.controls) {
      const colors = designStyle.color_schemes[colorScheme];
      toggleColorSchemes();
      setTimeout(function () {
        updateViewportBasis(designStyle);
      }, 200);
      Object.entries(wp.customize.settings.controls) // eslint-disable-next-line no-unused-vars
      .filter(_ref => {
        let [_control, config] = _ref;
        return config.type === 'color';
      }).forEach(_ref2 => {
        let [customizerControl, config] = _ref2;
        const customizerSetting = wp.customize(config.settings.default);
        const color = colors[config.settings.default.replace('_color', '')] || '';
        customizerSetting.set(color);
        wp.customize.control(customizerControl).container.find('.color-picker-hex').data('data-default-color', color).wpColorPicker('defaultColor', color).trigger('change');
      });
    }
  };
  /**
   * Control the visibility of the color schemes selections.
   */


  const toggleColorSchemes = () => {
    $('label[for^=color_scheme_control]').hide();
    $(`label[for^=color_scheme_control-${selectedDesignStyle}-]`).show();
  };
  /**
   * Update the viewport basis for the selected design style.
   *
   * @param {*} designStyle
   */


  const updateViewportBasis = designStyle => {
    const viewportBasis = 'undefined' !== typeof designStyle.viewport_basis ? designStyle.viewport_basis : '950';
    wp.customize.control('viewport_basis').setting(viewportBasis);
  };
  /**
   * Returns the design style array
   *
   * @param {*} designStyle
   */


  const getDesignStyle = designStyle => {
    if ('undefined' !== typeof GoPreviewData.design_styles && 'undefined' !== GoPreviewData.design_styles[designStyle]) {
      return GoPreviewData.design_styles[designStyle];
    }

    return false;
  };

  wp.customize.bind('ready', () => toggleColorSchemes());
  wp.customize('design_style', value => {
    selectedDesignStyle = value.get();
    value.bind(to => {
      selectedDesignStyle = to;
      loadColorSchemes('one');
      $(`#color_scheme_control-${selectedDesignStyle}-one`).prop('checked', true);
    });
  });
  wp.customize('color_scheme', value => {
    value.bind(colorScheme => loadColorSchemes(colorScheme));
  });
  wp.customize('background_color', value => {
    value.bind(to => setColor(to, '--go--color--background'));
  });
  wp.customize('primary_color', value => {
    value.bind(to => setColor(to, '--go--color--primary'));
  });
  wp.customize('secondary_color', value => {
    value.bind(to => setColor(to, '--go--color--secondary'));
  });
  wp.customize('tertiary_color', value => {
    value.bind(to => setColor(to, '--go--color--tertiary'));
  });
});

/***/ }),

/***/ "./.dev/assets/admin/js/customize/preview/design-style.js":
/*!****************************************************************!*\
  !*** ./.dev/assets/admin/js/customize/preview/design-style.js ***!
  \****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
const $ = jQuery;
/* harmony default export */ __webpack_exports__["default"] = (() => {
  wp.customize('design_style', value => {
    value.bind(to => {
      $('#customize-preview').addClass('is-loading');

      if ('undefined' !== typeof GoPreviewData.design_styles && 'undefined' !== GoPreviewData.design_styles[to]) {
        setTimeout(function () {
          const designStyle = GoPreviewData.design_styles[to];
          $('link[id*="design-style"]').attr('href', designStyle.url);
          setTimeout(function () {
            $('#customize-preview').removeClass('is-loading');
          }, 500);
        }, 500); // match the .02s transition time from core
      }
    });
  });
  /**
   * Set viewport basis
   *
   * @param {*} size
   */

  const setViewportBasis = size => {
    document.documentElement.style.setProperty('--go--viewport-basis', size ? size : '1000');
  };

  wp.customize('viewport_basis', value => {
    value.bind(to => setViewportBasis(to));
  });
});

/***/ }),

/***/ "./.dev/assets/admin/js/customize/preview/footer.js":
/*!**********************************************************!*\
  !*** ./.dev/assets/admin/js/customize/preview/footer.js ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _util__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../util */ "./.dev/assets/admin/js/customize/util.js");

const $ = jQuery;
$(document).ready(setMenuLocationDescription);
/* harmony default export */ __webpack_exports__["default"] = (() => {
  wp.customize('footer_variation', value => {
    value.bind(to => {
      $('body').removeClass('has-footer-1 has-footer-2 has-footer-3 has-footer-4').addClass('has-' + to);
      setMenuLocationDescription();
    });
  });
  wp.customize('copyright', function (value) {
    value.bind(function (to) {
      $('.copyright').html(to);
    });
  });
  wp.customize('footer_background_color', value => {
    value.bind(to => {
      const hsl = (0,_util__WEBPACK_IMPORTED_MODULE_0__.hexToHSL)(to);
      const setTo = to ? `hsl(${hsl[0]}, ${hsl[1]}%, ${hsl[2]}%)` : undefined;
      document.querySelector(':root').style.setProperty('--go-footer--color--background', setTo); // Add class if a background color is applied.

      if (to) {
        $('body').addClass('has-footer-background');
        $('.site-footer').addClass('has-background');
      } else {
        $('body').removeClass('has-footer-background');
        $('.site-footer').removeClass('has-background');
      }
    });
  });
  wp.customize('social_icon_color', value => {
    value.bind(to => {
      const hsl = (0,_util__WEBPACK_IMPORTED_MODULE_0__.hexToHSL)(to);
      const setTo = to ? `hsl(${hsl[0]}, ${hsl[1]}%, ${hsl[2]}%)` : undefined;
      document.querySelector(':root').style.setProperty('--go-social--color--text', setTo);
    });
  });
  wp.customize('footer_text_color', value => {
    value.bind(to => {
      const hsl = (0,_util__WEBPACK_IMPORTED_MODULE_0__.hexToHSL)(to);
      const setTo = to ? `hsl(${hsl[0]}, ${hsl[1]}%, ${hsl[2]}%)` : undefined;
      document.querySelector(':root').style.setProperty('--go-footer--color--text', setTo);
      document.querySelector(':root').style.setProperty('--go-footer-navigation--color--text', setTo);
    });
  });
  wp.customize('footer_heading_color', value => {
    value.bind(to => {
      const hsl = (0,_util__WEBPACK_IMPORTED_MODULE_0__.hexToHSL)(to);
      const setTo = to ? `hsl(${hsl[0]}, ${hsl[1]}%, ${hsl[2]}%)` : null;
      document.querySelector(':root').style.setProperty('--go-footer-heading--color--text', setTo);
    });
  });
  wp.customize('social_icon_facebook', value => {
    value.bind(to => {
      if (to) {
        $('.social-icon-facebook').removeClass('display-none');
      } else {
        $('.social-icon-facebook').addClass('display-none');
      }
    });
  });
  wp.customize('social_icon_twitter', value => {
    value.bind(to => {
      if (to) {
        $('.social-icon-twitter').removeClass('display-none');
      } else {
        $('.social-icon-twitter').addClass('display-none');
      }
    });
  });
  wp.customize('social_icon_instagram', value => {
    value.bind(to => {
      if (to) {
        $('.social-icon-instagram').removeClass('display-none');
      } else {
        $('.social-icon-instagram').addClass('display-none');
      }
    });
  });
  wp.customize('social_icon_linkedin', value => {
    value.bind(to => {
      if (to) {
        $('.social-icon-linkedin').removeClass('display-none');
      } else {
        $('.social-icon-linkedin').addClass('display-none');
      }
    });
  });
  wp.customize('social_icon_xing', function (value) {
    value.bind(function (to) {
      if (to) {
        $('.social-icon-xing').removeClass('display-none');
      } else {
        $('.social-icon-xing').addClass('display-none');
      }
    });
  });
  wp.customize('social_icon_pinterest', value => {
    value.bind(to => {
      if (to) {
        $('.social-icon-pinterest').removeClass('display-none');
      } else {
        $('.social-icon-pinterest').addClass('display-none');
      }
    });
  });
  wp.customize('social_icon_youtube', value => {
    value.bind(to => {
      if (to) {
        $('.social-icon-youtube').removeClass('display-none');
      } else {
        $('.social-icon-youtube').addClass('display-none');
      }
    });
  });
  wp.customize('social_icon_spotify', value => {
    value.bind(to => {
      if (to) {
        $('.social-icon-spotify').removeClass('display-none');
      } else {
        $('.social-icon-spotify').addClass('display-none');
      }
    });
  });
  wp.customize('social_icon_github', value => {
    value.bind(to => {
      if (to) {
        $('.social-icon-github').removeClass('display-none');
      } else {
        $('.social-icon-github').addClass('display-none');
      }
    });
  });
  wp.customize('social_icon_tiktok', value => {
    value.bind(to => {
      if (to) {
        $('.social-icon-tiktok').removeClass('display-none');
      } else {
        $('.social-icon-tiktok').addClass('display-none');
      }
    });
  });
});

function setMenuLocationDescription() {
  const menuLocationsDescription = $('.customize-section-title-menu_locations-description').text();
  const menuLocationCount = ['footer-1', 'footer-2'].includes(wp.customize('footer_variation').get()) ? '2' : '4';
  $('.customize-section-title-menu_locations-description').text(menuLocationsDescription.replace(/[0-9]/g, menuLocationCount));
}

/***/ }),

/***/ "./.dev/assets/admin/js/customize/preview/header.js":
/*!**********************************************************!*\
  !*** ./.dev/assets/admin/js/customize/preview/header.js ***!
  \**********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _util__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../util */ "./.dev/assets/admin/js/customize/util.js");

const $ = jQuery;
/* harmony default export */ __webpack_exports__["default"] = (() => {
  wp.customize('header_variation', value => {
    value.bind(to => {
      $('body').removeClass('has-header-1 has-header-2 has-header-3 has-header-4 has-header-5 has-header-6 has-header-7').addClass('has-' + to);
    });
  });
  wp.customize('header_background_color', value => {
    value.bind(to => {
      const hsl = (0,_util__WEBPACK_IMPORTED_MODULE_0__.hexToHSL)(to);
      const setTo = to ? `hsl(${hsl[0]}, ${hsl[1]}%, ${hsl[2]}%)` : undefined;
      document.querySelector(':root').style.setProperty('--go-header--color--background', setTo); // Add class if a background color is applied.

      if (to) {
        $('.header').addClass('has-background');
      } else {
        $('.header').removeClass('has-background');
      }
    });
  });
  wp.customize('header_text_color', value => {
    value.bind(to => {
      const hsl = (0,_util__WEBPACK_IMPORTED_MODULE_0__.hexToHSL)(to);
      const setTo = to ? `hsl(${hsl[0]}, ${hsl[1]}%, ${hsl[2]}%)` : undefined;
      document.querySelector(':root').style.setProperty('--go-navigation--color--text', setTo);
      document.querySelector(':root').style.setProperty('--go-site-description--color--text', setTo);
      document.querySelector(':root').style.setProperty('--go-search-button--color--text', setTo);
      document.querySelector(':root').style.setProperty('--go-site-title--color--text', setTo);
    });
  });
});

/***/ }),

/***/ "./.dev/assets/admin/js/customize/preview/logo-sizing.js":
/*!***************************************************************!*\
  !*** ./.dev/assets/admin/js/customize/preview/logo-sizing.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = (() => {
  /**
   * Set Logo width.
   *
   * @param {*} width
   */
  const setLogoWidth = width => {
    document.documentElement.style.setProperty('--go-logo--max-width', width ? `${width}px` : 'none');
  };
  /**
   * Set Logo mobile width.
   *
   * @param {*} width
   */


  const setLogoMobileWidth = width => {
    document.documentElement.style.setProperty('--go-logo-mobile--max-width', width ? `${width}px` : 'none');
  };

  wp.customize('logo_width', value => {
    value.bind(to => setLogoWidth(to));
  });
  wp.customize('logo_width_mobile', value => {
    value.bind(to => setLogoMobileWidth(to));
  });
});

/***/ }),

/***/ "./.dev/assets/admin/js/customize/preview/page-titles.js":
/*!***************************************************************!*\
  !*** ./.dev/assets/admin/js/customize/preview/page-titles.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
const $ = jQuery; // eslint-disable-line

/* harmony default export */ __webpack_exports__["default"] = (() => {
  wp.customize('page_titles', value => {
    const selectors = '#content > .entry-header, body.page article .entry-header, body.woocommerce .entry-header';
    value.bind(to => {
      if (to) {
        $('body').addClass('has-page-titles');
        $(selectors).removeClass('display-none');
      } else {
        $('body').removeClass('has-page-titles');
        $(selectors).addClass('display-none');
      }
    });
  });
});

/***/ }),

/***/ "./.dev/assets/admin/js/customize/util.js":
/*!************************************************!*\
  !*** ./.dev/assets/admin/js/customize/util.js ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "hexToHSL": function() { return /* binding */ hexToHSL; }
/* harmony export */ });
/**
 * Functions to convert hex color to HSL
 *
 * @param {*} H
 */
function hexToHSL(H) {
  // Convert hex to RGB first
  let b = 0;
  let g = 0;
  let r = 0;

  if (4 === H.length) {
    r = `0x${H[1]}${H[1]}`;
    g = `0x${H[2]}${H[2]}`;
    b = `0x${H[3]}${H[3]}`;
  } else if (7 === H.length) {
    r = `0x${H[1]}${H[2]}`;
    g = `0x${H[3]}${H[4]}`;
    b = `0x${H[5]}${H[6]}`;
  } // Then to HSL


  r /= 255;
  g /= 255;
  b /= 255;
  const cmax = Math.max(r, g, b);
  const cmin = Math.min(r, g, b);
  const delta = cmax - cmin;
  let h = 0;
  let s = 0;
  let l = 0;

  if (0 === delta) {
    h = 0;
  } else if (cmax === r) {
    h = (g - b) / delta % 6;
  } else if (cmax === g) {
    h = (b - r) / delta + 2;
  } else {
    h = (r - g) / delta + 4;
  }

  h = Math.round(h * 60);

  if (0 > h) {
    h += 360;
  }

  l = (cmax + cmin) / 2;
  s = 0 === delta ? 0 : delta / (1 - Math.abs(2 * l - 1));
  s = +(s * 100).toFixed();
  l = +(l * 100).toFixed();
  return [h, s, l];
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!***************************************************!*\
  !*** ./.dev/assets/admin/js/customize-preview.js ***!
  \***************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _customize_preview_color_schemes__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./customize/preview/color-schemes */ "./.dev/assets/admin/js/customize/preview/color-schemes.js");
/* harmony import */ var _customize_preview_design_style__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./customize/preview/design-style */ "./.dev/assets/admin/js/customize/preview/design-style.js");
/* harmony import */ var _customize_preview_footer__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./customize/preview/footer */ "./.dev/assets/admin/js/customize/preview/footer.js");
/* harmony import */ var _customize_preview_header__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./customize/preview/header */ "./.dev/assets/admin/js/customize/preview/header.js");
/* harmony import */ var _customize_preview_logo_sizing__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./customize/preview/logo-sizing */ "./.dev/assets/admin/js/customize/preview/logo-sizing.js");
/* harmony import */ var _customize_preview_page_titles__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./customize/preview/page-titles */ "./.dev/assets/admin/js/customize/preview/page-titles.js");






(0,_customize_preview_design_style__WEBPACK_IMPORTED_MODULE_1__["default"])();
(0,_customize_preview_header__WEBPACK_IMPORTED_MODULE_3__["default"])();
(0,_customize_preview_footer__WEBPACK_IMPORTED_MODULE_2__["default"])();
(0,_customize_preview_color_schemes__WEBPACK_IMPORTED_MODULE_0__["default"])();
(0,_customize_preview_logo_sizing__WEBPACK_IMPORTED_MODULE_4__["default"])();
(0,_customize_preview_page_titles__WEBPACK_IMPORTED_MODULE_5__["default"])();
}();
/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoianMvYWRtaW4vY3VzdG9taXplLXByZXZpZXcuanMiLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7Ozs7O0FBQUE7QUFFQTtBQUVBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBRUE7QUFBQTtBQUVBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBRUE7QUFJQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7OztBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7O0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQTtBQUNBO0FBSUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7Ozs7OztBQ3BIQTtBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBSUE7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDbENBO0FBRUE7QUFFQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBR0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBR0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7Ozs7Ozs7QUN6S0E7QUFFQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBR0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBR0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7Ozs7OztBQ3RDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7O0FDMUJBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7Ozs7O0FDZkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFHQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7Ozs7OztBQ3ZEQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7QUN2QkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7QUNQQTs7Ozs7QUNBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNOQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9nby8uLy5kZXYvYXNzZXRzL2FkbWluL2pzL2N1c3RvbWl6ZS9wcmV2aWV3L2NvbG9yLXNjaGVtZXMuanMiLCJ3ZWJwYWNrOi8vZ28vLi8uZGV2L2Fzc2V0cy9hZG1pbi9qcy9jdXN0b21pemUvcHJldmlldy9kZXNpZ24tc3R5bGUuanMiLCJ3ZWJwYWNrOi8vZ28vLi8uZGV2L2Fzc2V0cy9hZG1pbi9qcy9jdXN0b21pemUvcHJldmlldy9mb290ZXIuanMiLCJ3ZWJwYWNrOi8vZ28vLi8uZGV2L2Fzc2V0cy9hZG1pbi9qcy9jdXN0b21pemUvcHJldmlldy9oZWFkZXIuanMiLCJ3ZWJwYWNrOi8vZ28vLi8uZGV2L2Fzc2V0cy9hZG1pbi9qcy9jdXN0b21pemUvcHJldmlldy9sb2dvLXNpemluZy5qcyIsIndlYnBhY2s6Ly9nby8uLy5kZXYvYXNzZXRzL2FkbWluL2pzL2N1c3RvbWl6ZS9wcmV2aWV3L3BhZ2UtdGl0bGVzLmpzIiwid2VicGFjazovL2dvLy4vLmRldi9hc3NldHMvYWRtaW4vanMvY3VzdG9taXplL3V0aWwuanMiLCJ3ZWJwYWNrOi8vZ28vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vZ28vd2VicGFjay9ydW50aW1lL2RlZmluZSBwcm9wZXJ0eSBnZXR0ZXJzIiwid2VicGFjazovL2dvL3dlYnBhY2svcnVudGltZS9oYXNPd25Qcm9wZXJ0eSBzaG9ydGhhbmQiLCJ3ZWJwYWNrOi8vZ28vd2VicGFjay9ydW50aW1lL21ha2UgbmFtZXNwYWNlIG9iamVjdCIsIndlYnBhY2s6Ly9nby8uLy5kZXYvYXNzZXRzL2FkbWluL2pzL2N1c3RvbWl6ZS1wcmV2aWV3LmpzIl0sInNvdXJjZXNDb250ZW50IjpbImltcG9ydCB7IGhleFRvSFNMIH0gZnJvbSAnLi4vdXRpbCc7XG5cbmNvbnN0ICQgPSBqUXVlcnk7XG5cbmV4cG9ydCBkZWZhdWx0ICgpID0+IHtcblx0bGV0IHNlbGVjdGVkRGVzaWduU3R5bGUgPSBHb1ByZXZpZXdEYXRhLnNlbGVjdGVkRGVzaWduU3R5bGU7XG5cblx0LyoqXG5cdCAqIFNldCBjb2xvclxuXHQgKlxuXHQgKiBAcGFyYW0geyp9IGNvbG9yXG5cdCAqIEBwYXJhbSB7Kn0gY3NzVmFyXG5cdCAqL1xuXHRjb25zdCBzZXRDb2xvciA9ICggY29sb3IsIGNzc1ZhciApID0+IHtcblx0XHRjb25zdCBoc2wgPSBoZXhUb0hTTCggY29sb3IgKTtcblx0XHRkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCAnOnJvb3QnICkuc3R5bGUuc2V0UHJvcGVydHkoIGAkeyBjc3NWYXIgfWAsIGBoc2woJHsgaHNsWyAwIF0gfSwgJHsgaHNsWyAxIF0gfSUsICR7IGhzbFsgMiBdIH0lKWAgKTtcblx0fTtcblxuXHQvKipcblx0ICogTG9hZCB0aGUgY29sb3Igc2NoZW1lcyBmb3IgdGhlIHNlbGVjdGVkIGRlc2lnbiBzdHlsZS5cblx0ICpcblx0ICogQHBhcmFtIHsqfSBjb2xvclNjaGVtZVxuXHQgKi9cblx0Y29uc3QgbG9hZENvbG9yU2NoZW1lcyA9ICggY29sb3JTY2hlbWUgKSA9PiB7XG5cdFx0Y29uc3QgZGVzaWduU3R5bGUgPSBnZXREZXNpZ25TdHlsZSggc2VsZWN0ZWREZXNpZ25TdHlsZSApO1xuXHRcdGNvbG9yU2NoZW1lID0gY29sb3JTY2hlbWUucmVwbGFjZSggYCR7IHNlbGVjdGVkRGVzaWduU3R5bGUgfS1gLCAnJyApO1xuXG5cdFx0aWYgKCAndW5kZWZpbmVkJyAhPT0gdHlwZW9mIGRlc2lnblN0eWxlLmNvbG9yX3NjaGVtZXNbIGNvbG9yU2NoZW1lIF0gJiYgJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiB3cC5jdXN0b21pemUuc2V0dGluZ3MuY29udHJvbHMgKSB7XG5cdFx0XHRjb25zdCBjb2xvcnMgPSBkZXNpZ25TdHlsZS5jb2xvcl9zY2hlbWVzWyBjb2xvclNjaGVtZSBdO1xuXHRcdFx0dG9nZ2xlQ29sb3JTY2hlbWVzKCk7XG5cblx0XHRcdHNldFRpbWVvdXQoIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHR1cGRhdGVWaWV3cG9ydEJhc2lzKCBkZXNpZ25TdHlsZSApO1xuXHRcdFx0fSwgMjAwICk7XG5cblx0XHRcdE9iamVjdC5lbnRyaWVzKCB3cC5jdXN0b21pemUuc2V0dGluZ3MuY29udHJvbHMgKVxuXHRcdFx0XHQvLyBlc2xpbnQtZGlzYWJsZS1uZXh0LWxpbmUgbm8tdW51c2VkLXZhcnNcblx0XHRcdFx0LmZpbHRlciggKCBbIF9jb250cm9sLCBjb25maWcgXSApID0+IGNvbmZpZy50eXBlID09PSAnY29sb3InIClcblx0XHRcdFx0LmZvckVhY2goICggWyBjdXN0b21pemVyQ29udHJvbCwgY29uZmlnIF0gKSA9PiB7XG5cdFx0XHRcdFx0Y29uc3QgY3VzdG9taXplclNldHRpbmcgPSB3cC5jdXN0b21pemUoIGNvbmZpZy5zZXR0aW5ncy5kZWZhdWx0ICk7XG5cdFx0XHRcdFx0Y29uc3QgY29sb3IgPSBjb2xvcnNbIGNvbmZpZy5zZXR0aW5ncy5kZWZhdWx0LnJlcGxhY2UoICdfY29sb3InLCAnJyApIF0gfHwgJyc7XG5cblx0XHRcdFx0XHRjdXN0b21pemVyU2V0dGluZy5zZXQoIGNvbG9yICk7XG5cblx0XHRcdFx0XHR3cC5jdXN0b21pemUuY29udHJvbCggY3VzdG9taXplckNvbnRyb2wgKS5jb250YWluZXIuZmluZCggJy5jb2xvci1waWNrZXItaGV4JyApXG5cdFx0XHRcdFx0XHQuZGF0YSggJ2RhdGEtZGVmYXVsdC1jb2xvcicsIGNvbG9yIClcblx0XHRcdFx0XHRcdC53cENvbG9yUGlja2VyKCAnZGVmYXVsdENvbG9yJywgY29sb3IgKVxuXHRcdFx0XHRcdFx0LnRyaWdnZXIoICdjaGFuZ2UnICk7XG5cdFx0XHRcdH0gKTtcblx0XHR9XG5cdH07XG5cblx0LyoqXG5cdCAqIENvbnRyb2wgdGhlIHZpc2liaWxpdHkgb2YgdGhlIGNvbG9yIHNjaGVtZXMgc2VsZWN0aW9ucy5cblx0ICovXG5cdGNvbnN0IHRvZ2dsZUNvbG9yU2NoZW1lcyA9ICgpID0+IHtcblx0XHQkKCAnbGFiZWxbZm9yXj1jb2xvcl9zY2hlbWVfY29udHJvbF0nICkuaGlkZSgpO1xuXHRcdCQoIGBsYWJlbFtmb3JePWNvbG9yX3NjaGVtZV9jb250cm9sLSR7IHNlbGVjdGVkRGVzaWduU3R5bGUgfS1dYCApLnNob3coKTtcblx0fTtcblxuXHQvKipcblx0ICogVXBkYXRlIHRoZSB2aWV3cG9ydCBiYXNpcyBmb3IgdGhlIHNlbGVjdGVkIGRlc2lnbiBzdHlsZS5cblx0ICpcblx0ICogQHBhcmFtIHsqfSBkZXNpZ25TdHlsZVxuXHQgKi9cblx0Y29uc3QgdXBkYXRlVmlld3BvcnRCYXNpcyA9ICggZGVzaWduU3R5bGUgKSA9PiB7XG5cdFx0Y29uc3Qgdmlld3BvcnRCYXNpcyA9ICggJ3VuZGVmaW5lZCcgIT09IHR5cGVvZiBkZXNpZ25TdHlsZS52aWV3cG9ydF9iYXNpcyApID8gZGVzaWduU3R5bGUudmlld3BvcnRfYmFzaXMgOiAnOTUwJztcblx0XHR3cC5jdXN0b21pemUuY29udHJvbCggJ3ZpZXdwb3J0X2Jhc2lzJyApLnNldHRpbmcoIHZpZXdwb3J0QmFzaXMgKTtcblx0fTtcblxuXHQvKipcblx0ICogUmV0dXJucyB0aGUgZGVzaWduIHN0eWxlIGFycmF5XG5cdCAqXG5cdCAqIEBwYXJhbSB7Kn0gZGVzaWduU3R5bGVcblx0ICovXG5cdGNvbnN0IGdldERlc2lnblN0eWxlID0gKCBkZXNpZ25TdHlsZSApID0+IHtcblx0XHRpZiAoXG5cdFx0XHQndW5kZWZpbmVkJyAhPT0gdHlwZW9mIEdvUHJldmlld0RhdGEuZGVzaWduX3N0eWxlcyAmJlxuXHRcdFx0J3VuZGVmaW5lZCcgIT09IEdvUHJldmlld0RhdGEuZGVzaWduX3N0eWxlc1sgZGVzaWduU3R5bGUgXVxuXHRcdCkge1xuXHRcdFx0cmV0dXJuIEdvUHJldmlld0RhdGEuZGVzaWduX3N0eWxlc1sgZGVzaWduU3R5bGUgXTtcblx0XHR9XG5cblx0XHRyZXR1cm4gZmFsc2U7XG5cdH07XG5cblx0d3AuY3VzdG9taXplLmJpbmQoICdyZWFkeScsICgpID0+IHRvZ2dsZUNvbG9yU2NoZW1lcygpICk7XG5cblx0d3AuY3VzdG9taXplKCAnZGVzaWduX3N0eWxlJywgKCB2YWx1ZSApID0+IHtcblx0XHRzZWxlY3RlZERlc2lnblN0eWxlID0gdmFsdWUuZ2V0KCk7XG5cdFx0dmFsdWUuYmluZCggKCB0byApID0+IHtcblx0XHRcdHNlbGVjdGVkRGVzaWduU3R5bGUgPSB0bztcblx0XHRcdGxvYWRDb2xvclNjaGVtZXMoICdvbmUnICk7XG5cdFx0XHQkKCBgI2NvbG9yX3NjaGVtZV9jb250cm9sLSR7IHNlbGVjdGVkRGVzaWduU3R5bGUgfS1vbmVgICkucHJvcCggJ2NoZWNrZWQnLCB0cnVlICk7XG5cdFx0fSApO1xuXHR9ICk7XG5cblx0d3AuY3VzdG9taXplKCAnY29sb3Jfc2NoZW1lJywgKCB2YWx1ZSApID0+IHtcblx0XHR2YWx1ZS5iaW5kKCAoIGNvbG9yU2NoZW1lICkgPT4gbG9hZENvbG9yU2NoZW1lcyggY29sb3JTY2hlbWUgKSApO1xuXHR9ICk7XG5cblx0d3AuY3VzdG9taXplKCAnYmFja2dyb3VuZF9jb2xvcicsICggdmFsdWUgKSA9PiB7XG5cdFx0dmFsdWUuYmluZCggKCB0byApID0+IHNldENvbG9yKCB0bywgJy0tZ28tLWNvbG9yLS1iYWNrZ3JvdW5kJyApICk7XG5cdH0gKTtcblxuXHR3cC5jdXN0b21pemUoICdwcmltYXJ5X2NvbG9yJywgKCB2YWx1ZSApID0+IHtcblx0XHR2YWx1ZS5iaW5kKCAoIHRvICkgPT4gc2V0Q29sb3IoIHRvLCAnLS1nby0tY29sb3ItLXByaW1hcnknICkgKTtcblx0fSApO1xuXG5cdHdwLmN1c3RvbWl6ZSggJ3NlY29uZGFyeV9jb2xvcicsICggdmFsdWUgKSA9PiB7XG5cdFx0dmFsdWUuYmluZCggKCB0byApID0+IHNldENvbG9yKCB0bywgJy0tZ28tLWNvbG9yLS1zZWNvbmRhcnknICkgKTtcblx0fSApO1xuXG5cdHdwLmN1c3RvbWl6ZSggJ3RlcnRpYXJ5X2NvbG9yJywgKCB2YWx1ZSApID0+IHtcblx0XHR2YWx1ZS5iaW5kKCAoIHRvICkgPT4gc2V0Q29sb3IoIHRvLCAnLS1nby0tY29sb3ItLXRlcnRpYXJ5JyApICk7XG5cdH0gKTtcbn07XG4iLCJjb25zdCAkID0galF1ZXJ5O1xuXG5leHBvcnQgZGVmYXVsdCAoKSA9PiB7XG5cdHdwLmN1c3RvbWl6ZSggJ2Rlc2lnbl9zdHlsZScsICggdmFsdWUgKSA9PiB7XG5cdFx0dmFsdWUuYmluZCggKCB0byApID0+IHtcblx0XHRcdCQoICcjY3VzdG9taXplLXByZXZpZXcnICkuYWRkQ2xhc3MoICdpcy1sb2FkaW5nJyApO1xuXG5cdFx0XHRpZiAoXG5cdFx0XHRcdCd1bmRlZmluZWQnICE9PSB0eXBlb2YgR29QcmV2aWV3RGF0YS5kZXNpZ25fc3R5bGVzICYmXG5cdFx0XHRcdCd1bmRlZmluZWQnICE9PSBHb1ByZXZpZXdEYXRhLmRlc2lnbl9zdHlsZXNbIHRvIF1cblx0XHRcdCkge1xuXHRcdFx0XHRzZXRUaW1lb3V0KCBmdW5jdGlvbigpIHtcblx0XHRcdFx0XHRjb25zdCBkZXNpZ25TdHlsZSA9IEdvUHJldmlld0RhdGEuZGVzaWduX3N0eWxlc1sgdG8gXTtcblx0XHRcdFx0XHQkKCAnbGlua1tpZCo9XCJkZXNpZ24tc3R5bGVcIl0nICkuYXR0ciggJ2hyZWYnLCBkZXNpZ25TdHlsZS51cmwgKTtcblxuXHRcdFx0XHRcdHNldFRpbWVvdXQoIGZ1bmN0aW9uKCkge1xuXHRcdFx0XHRcdFx0JCggJyNjdXN0b21pemUtcHJldmlldycgKS5yZW1vdmVDbGFzcyggJ2lzLWxvYWRpbmcnICk7XG5cdFx0XHRcdFx0fSwgNTAwICk7XG5cdFx0XHRcdH0sIDUwMCApOyAvLyBtYXRjaCB0aGUgLjAycyB0cmFuc2l0aW9uIHRpbWUgZnJvbSBjb3JlXG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9ICk7XG5cdC8qKlxuXHQgKiBTZXQgdmlld3BvcnQgYmFzaXNcblx0ICpcblx0ICogQHBhcmFtIHsqfSBzaXplXG5cdCAqL1xuXHRjb25zdCBzZXRWaWV3cG9ydEJhc2lzID0gKCBzaXplICkgPT4ge1xuXHRcdGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zdHlsZS5zZXRQcm9wZXJ0eSggJy0tZ28tLXZpZXdwb3J0LWJhc2lzJywgc2l6ZSA/IHNpemUgOiAnMTAwMCcgKTtcblx0fTtcblxuXHR3cC5jdXN0b21pemUoICd2aWV3cG9ydF9iYXNpcycsICggdmFsdWUgKSA9PiB7XG5cdFx0dmFsdWUuYmluZCggKCB0byApID0+IHNldFZpZXdwb3J0QmFzaXMoIHRvICkgKTtcblx0fSApO1xufTtcbiIsImltcG9ydCB7IGhleFRvSFNMIH0gZnJvbSAnLi4vdXRpbCc7XG5cbmNvbnN0ICQgPSBqUXVlcnk7XG5cbiQoIGRvY3VtZW50ICkucmVhZHkoIHNldE1lbnVMb2NhdGlvbkRlc2NyaXB0aW9uICk7XG5cbmV4cG9ydCBkZWZhdWx0ICgpID0+IHtcblx0d3AuY3VzdG9taXplKCAnZm9vdGVyX3ZhcmlhdGlvbicsICggdmFsdWUgKSA9PiB7XG5cdFx0dmFsdWUuYmluZCggKCB0byApID0+IHtcblx0XHRcdCQoICdib2R5JyApXG5cdFx0XHRcdC5yZW1vdmVDbGFzcyggJ2hhcy1mb290ZXItMSBoYXMtZm9vdGVyLTIgaGFzLWZvb3Rlci0zIGhhcy1mb290ZXItNCcgKVxuXHRcdFx0XHQuYWRkQ2xhc3MoICdoYXMtJyArIHRvICk7XG5cdFx0XHRzZXRNZW51TG9jYXRpb25EZXNjcmlwdGlvbigpO1xuXHRcdH0gKTtcblx0fSApO1xuXG5cdHdwLmN1c3RvbWl6ZSggJ2NvcHlyaWdodCcsIGZ1bmN0aW9uKCB2YWx1ZSApIHtcblx0XHR2YWx1ZS5iaW5kKCBmdW5jdGlvbiggdG8gKSB7XG5cdFx0XHQkKCAnLmNvcHlyaWdodCcgKS5odG1sKCB0byApO1xuXHRcdH0gKTtcblx0fSApO1xuXG5cdHdwLmN1c3RvbWl6ZSggJ2Zvb3Rlcl9iYWNrZ3JvdW5kX2NvbG9yJywgKCB2YWx1ZSApID0+IHtcblx0XHR2YWx1ZS5iaW5kKCAoIHRvICkgPT4ge1xuXHRcdFx0Y29uc3QgaHNsID0gaGV4VG9IU0woIHRvICk7XG5cdFx0XHRjb25zdCBzZXRUbyA9IHRvID8gYGhzbCgkeyBoc2xbIDAgXSB9LCAkeyBoc2xbIDEgXSB9JSwgJHsgaHNsWyAyIF0gfSUpYCA6IHVuZGVmaW5lZDtcblx0XHRcdGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoICc6cm9vdCcgKS5zdHlsZS5zZXRQcm9wZXJ0eSggJy0tZ28tZm9vdGVyLS1jb2xvci0tYmFja2dyb3VuZCcsIHNldFRvICk7XG5cblx0XHRcdC8vIEFkZCBjbGFzcyBpZiBhIGJhY2tncm91bmQgY29sb3IgaXMgYXBwbGllZC5cblx0XHRcdGlmICggdG8gKSB7XG5cdFx0XHRcdCQoICdib2R5JyApLmFkZENsYXNzKCAnaGFzLWZvb3Rlci1iYWNrZ3JvdW5kJyApO1xuXHRcdFx0XHQkKCAnLnNpdGUtZm9vdGVyJyApLmFkZENsYXNzKCAnaGFzLWJhY2tncm91bmQnICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHQkKCAnYm9keScgKS5yZW1vdmVDbGFzcyggJ2hhcy1mb290ZXItYmFja2dyb3VuZCcgKTtcblx0XHRcdFx0JCggJy5zaXRlLWZvb3RlcicgKS5yZW1vdmVDbGFzcyggJ2hhcy1iYWNrZ3JvdW5kJyApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0fSApO1xuXG5cdHdwLmN1c3RvbWl6ZSggJ3NvY2lhbF9pY29uX2NvbG9yJywgKCB2YWx1ZSApID0+IHtcblx0XHR2YWx1ZS5iaW5kKCAoIHRvICkgPT4ge1xuXHRcdFx0Y29uc3QgaHNsID0gaGV4VG9IU0woIHRvICk7XG5cdFx0XHRjb25zdCBzZXRUbyA9IHRvID8gYGhzbCgkeyBoc2xbIDAgXSB9LCAkeyBoc2xbIDEgXSB9JSwgJHsgaHNsWyAyIF0gfSUpYCA6IHVuZGVmaW5lZDtcblx0XHRcdGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoICc6cm9vdCcgKS5zdHlsZS5zZXRQcm9wZXJ0eSggJy0tZ28tc29jaWFsLS1jb2xvci0tdGV4dCcsIHNldFRvICk7XG5cdFx0fSApO1xuXHR9ICk7XG5cblx0d3AuY3VzdG9taXplKCAnZm9vdGVyX3RleHRfY29sb3InLCAoIHZhbHVlICkgPT4ge1xuXHRcdHZhbHVlLmJpbmQoICggdG8gKSA9PiB7XG5cdFx0XHRjb25zdCBoc2wgPSBoZXhUb0hTTCggdG8gKTtcblx0XHRcdGNvbnN0IHNldFRvID0gdG8gPyBgaHNsKCR7IGhzbFsgMCBdIH0sICR7IGhzbFsgMSBdIH0lLCAkeyBoc2xbIDIgXSB9JSlgIDogdW5kZWZpbmVkO1xuXHRcdFx0ZG9jdW1lbnQucXVlcnlTZWxlY3RvciggJzpyb290JyApLnN0eWxlLnNldFByb3BlcnR5KCAnLS1nby1mb290ZXItLWNvbG9yLS10ZXh0Jywgc2V0VG8gKTtcblx0XHRcdGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoICc6cm9vdCcgKS5zdHlsZS5zZXRQcm9wZXJ0eSggJy0tZ28tZm9vdGVyLW5hdmlnYXRpb24tLWNvbG9yLS10ZXh0Jywgc2V0VG8gKTtcblx0XHR9ICk7XG5cdH0gKTtcblxuXHR3cC5jdXN0b21pemUoICdmb290ZXJfaGVhZGluZ19jb2xvcicsICggdmFsdWUgKSA9PiB7XG5cdFx0dmFsdWUuYmluZCggKCB0byApID0+IHtcblx0XHRcdGNvbnN0IGhzbCA9IGhleFRvSFNMKCB0byApO1xuXHRcdFx0Y29uc3Qgc2V0VG8gPSB0byA/IGBoc2woJHsgaHNsWyAwIF0gfSwgJHsgaHNsWyAxIF0gfSUsICR7IGhzbFsgMiBdIH0lKWAgOiBudWxsO1xuXHRcdFx0ZG9jdW1lbnQucXVlcnlTZWxlY3RvciggJzpyb290JyApLnN0eWxlLnNldFByb3BlcnR5KCAnLS1nby1mb290ZXItaGVhZGluZy0tY29sb3ItLXRleHQnLCBzZXRUbyApO1xuXHRcdH0gKTtcblx0fSApO1xuXG5cdHdwLmN1c3RvbWl6ZSggJ3NvY2lhbF9pY29uX2ZhY2Vib29rJywgKCB2YWx1ZSApID0+IHtcblx0XHR2YWx1ZS5iaW5kKCAoIHRvICkgPT4ge1xuXHRcdFx0aWYgKCB0byApIHtcblx0XHRcdFx0JCggJy5zb2NpYWwtaWNvbi1mYWNlYm9vaycgKS5yZW1vdmVDbGFzcyggJ2Rpc3BsYXktbm9uZScgKTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdCQoICcuc29jaWFsLWljb24tZmFjZWJvb2snICkuYWRkQ2xhc3MoICdkaXNwbGF5LW5vbmUnICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9ICk7XG5cblx0d3AuY3VzdG9taXplKCAnc29jaWFsX2ljb25fdHdpdHRlcicsICggdmFsdWUgKSA9PiB7XG5cdFx0dmFsdWUuYmluZCggKCB0byApID0+IHtcblx0XHRcdGlmICggdG8gKSB7XG5cdFx0XHRcdCQoICcuc29jaWFsLWljb24tdHdpdHRlcicgKS5yZW1vdmVDbGFzcyggJ2Rpc3BsYXktbm9uZScgKTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdCQoICcuc29jaWFsLWljb24tdHdpdHRlcicgKS5hZGRDbGFzcyggJ2Rpc3BsYXktbm9uZScgKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cdH0gKTtcblxuXHR3cC5jdXN0b21pemUoICdzb2NpYWxfaWNvbl9pbnN0YWdyYW0nLCAoIHZhbHVlICkgPT4ge1xuXHRcdHZhbHVlLmJpbmQoICggdG8gKSA9PiB7XG5cdFx0XHRpZiAoIHRvICkge1xuXHRcdFx0XHQkKCAnLnNvY2lhbC1pY29uLWluc3RhZ3JhbScgKS5yZW1vdmVDbGFzcyggJ2Rpc3BsYXktbm9uZScgKTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdCQoICcuc29jaWFsLWljb24taW5zdGFncmFtJyApLmFkZENsYXNzKCAnZGlzcGxheS1ub25lJyApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0fSApO1xuXG5cdHdwLmN1c3RvbWl6ZSggJ3NvY2lhbF9pY29uX2xpbmtlZGluJywgKCB2YWx1ZSApID0+IHtcblx0XHR2YWx1ZS5iaW5kKCAoIHRvICkgPT4ge1xuXHRcdFx0aWYgKCB0byApIHtcblx0XHRcdFx0JCggJy5zb2NpYWwtaWNvbi1saW5rZWRpbicgKS5yZW1vdmVDbGFzcyggJ2Rpc3BsYXktbm9uZScgKTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdCQoICcuc29jaWFsLWljb24tbGlua2VkaW4nICkuYWRkQ2xhc3MoICdkaXNwbGF5LW5vbmUnICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9ICk7XG5cblx0d3AuY3VzdG9taXplKCAnc29jaWFsX2ljb25feGluZycsIGZ1bmN0aW9uKCB2YWx1ZSApIHtcblx0XHR2YWx1ZS5iaW5kKCBmdW5jdGlvbiggdG8gKSB7XG5cdFx0XHRpZiAoIHRvICkge1xuXHRcdFx0XHQkKCAnLnNvY2lhbC1pY29uLXhpbmcnICkucmVtb3ZlQ2xhc3MoICdkaXNwbGF5LW5vbmUnICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHQkKCAnLnNvY2lhbC1pY29uLXhpbmcnICkuYWRkQ2xhc3MoICdkaXNwbGF5LW5vbmUnICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9ICk7XG5cblx0d3AuY3VzdG9taXplKCAnc29jaWFsX2ljb25fcGludGVyZXN0JywgKCB2YWx1ZSApID0+IHtcblx0XHR2YWx1ZS5iaW5kKCAoIHRvICkgPT4ge1xuXHRcdFx0aWYgKCB0byApIHtcblx0XHRcdFx0JCggJy5zb2NpYWwtaWNvbi1waW50ZXJlc3QnICkucmVtb3ZlQ2xhc3MoICdkaXNwbGF5LW5vbmUnICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHQkKCAnLnNvY2lhbC1pY29uLXBpbnRlcmVzdCcgKS5hZGRDbGFzcyggJ2Rpc3BsYXktbm9uZScgKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cdH0gKTtcblxuXHR3cC5jdXN0b21pemUoICdzb2NpYWxfaWNvbl95b3V0dWJlJywgKCB2YWx1ZSApID0+IHtcblx0XHR2YWx1ZS5iaW5kKCAoIHRvICkgPT4ge1xuXHRcdFx0aWYgKCB0byApIHtcblx0XHRcdFx0JCggJy5zb2NpYWwtaWNvbi15b3V0dWJlJyApLnJlbW92ZUNsYXNzKCAnZGlzcGxheS1ub25lJyApO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0JCggJy5zb2NpYWwtaWNvbi15b3V0dWJlJyApLmFkZENsYXNzKCAnZGlzcGxheS1ub25lJyApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0fSApO1xuXG5cdHdwLmN1c3RvbWl6ZSggJ3NvY2lhbF9pY29uX3Nwb3RpZnknLCAoIHZhbHVlICkgPT4ge1xuXHRcdHZhbHVlLmJpbmQoICggdG8gKSA9PiB7XG5cdFx0XHRpZiAoIHRvICkge1xuXHRcdFx0XHQkKCAnLnNvY2lhbC1pY29uLXNwb3RpZnknICkucmVtb3ZlQ2xhc3MoICdkaXNwbGF5LW5vbmUnICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHQkKCAnLnNvY2lhbC1pY29uLXNwb3RpZnknICkuYWRkQ2xhc3MoICdkaXNwbGF5LW5vbmUnICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9ICk7XG5cblx0d3AuY3VzdG9taXplKCAnc29jaWFsX2ljb25fZ2l0aHViJywgKCB2YWx1ZSApID0+IHtcblx0XHR2YWx1ZS5iaW5kKCAoIHRvICkgPT4ge1xuXHRcdFx0aWYgKCB0byApIHtcblx0XHRcdFx0JCggJy5zb2NpYWwtaWNvbi1naXRodWInICkucmVtb3ZlQ2xhc3MoICdkaXNwbGF5LW5vbmUnICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHQkKCAnLnNvY2lhbC1pY29uLWdpdGh1YicgKS5hZGRDbGFzcyggJ2Rpc3BsYXktbm9uZScgKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cdH0gKTtcblxuXHR3cC5jdXN0b21pemUoICdzb2NpYWxfaWNvbl90aWt0b2snLCAoIHZhbHVlICkgPT4ge1xuXHRcdHZhbHVlLmJpbmQoICggdG8gKSA9PiB7XG5cdFx0XHRpZiAoIHRvICkge1xuXHRcdFx0XHQkKCAnLnNvY2lhbC1pY29uLXRpa3RvaycgKS5yZW1vdmVDbGFzcyggJ2Rpc3BsYXktbm9uZScgKTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdCQoICcuc29jaWFsLWljb24tdGlrdG9rJyApLmFkZENsYXNzKCAnZGlzcGxheS1ub25lJyApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0fSApO1xufTtcblxuZnVuY3Rpb24gc2V0TWVudUxvY2F0aW9uRGVzY3JpcHRpb24oKSB7XG5cdGNvbnN0IG1lbnVMb2NhdGlvbnNEZXNjcmlwdGlvbiA9ICQoICcuY3VzdG9taXplLXNlY3Rpb24tdGl0bGUtbWVudV9sb2NhdGlvbnMtZGVzY3JpcHRpb24nICkudGV4dCgpO1xuXHRjb25zdCBtZW51TG9jYXRpb25Db3VudCA9IFsgJ2Zvb3Rlci0xJywgJ2Zvb3Rlci0yJyBdLmluY2x1ZGVzKCB3cC5jdXN0b21pemUoICdmb290ZXJfdmFyaWF0aW9uJyApLmdldCgpICkgPyAnMicgOiAnNCc7XG5cdCQoICcuY3VzdG9taXplLXNlY3Rpb24tdGl0bGUtbWVudV9sb2NhdGlvbnMtZGVzY3JpcHRpb24nICkudGV4dCggbWVudUxvY2F0aW9uc0Rlc2NyaXB0aW9uLnJlcGxhY2UoIC9bMC05XS9nLCBtZW51TG9jYXRpb25Db3VudCApICk7XG59XG4iLCJpbXBvcnQgeyBoZXhUb0hTTCB9IGZyb20gJy4uL3V0aWwnO1xuXG5jb25zdCAkID0galF1ZXJ5O1xuXG5leHBvcnQgZGVmYXVsdCAoKSA9PiB7XG5cdHdwLmN1c3RvbWl6ZSggJ2hlYWRlcl92YXJpYXRpb24nLCAoIHZhbHVlICkgPT4ge1xuXHRcdHZhbHVlLmJpbmQoICggdG8gKSA9PiB7XG5cdFx0XHQkKCAnYm9keScgKVxuXHRcdFx0XHQucmVtb3ZlQ2xhc3MoICdoYXMtaGVhZGVyLTEgaGFzLWhlYWRlci0yIGhhcy1oZWFkZXItMyBoYXMtaGVhZGVyLTQgaGFzLWhlYWRlci01IGhhcy1oZWFkZXItNiBoYXMtaGVhZGVyLTcnIClcblx0XHRcdFx0LmFkZENsYXNzKCAnaGFzLScgKyB0byApO1xuXHRcdH0gKTtcblx0fSApO1xuXG5cdHdwLmN1c3RvbWl6ZSggJ2hlYWRlcl9iYWNrZ3JvdW5kX2NvbG9yJywgKCB2YWx1ZSApID0+IHtcblx0XHR2YWx1ZS5iaW5kKCAoIHRvICkgPT4ge1xuXHRcdFx0Y29uc3QgaHNsID0gaGV4VG9IU0woIHRvICk7XG5cdFx0XHRjb25zdCBzZXRUbyA9IHRvID8gYGhzbCgkeyBoc2xbIDAgXSB9LCAkeyBoc2xbIDEgXSB9JSwgJHsgaHNsWyAyIF0gfSUpYCA6IHVuZGVmaW5lZDtcblx0XHRcdGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoICc6cm9vdCcgKS5zdHlsZS5zZXRQcm9wZXJ0eSggJy0tZ28taGVhZGVyLS1jb2xvci0tYmFja2dyb3VuZCcsIHNldFRvICk7XG5cblx0XHRcdC8vIEFkZCBjbGFzcyBpZiBhIGJhY2tncm91bmQgY29sb3IgaXMgYXBwbGllZC5cblx0XHRcdGlmICggdG8gKSB7XG5cdFx0XHRcdCQoICcuaGVhZGVyJyApLmFkZENsYXNzKCAnaGFzLWJhY2tncm91bmQnICk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHQkKCAnLmhlYWRlcicgKS5yZW1vdmVDbGFzcyggJ2hhcy1iYWNrZ3JvdW5kJyApO1xuXHRcdFx0fVxuXHRcdH0gKTtcblx0fSApO1xuXG5cdHdwLmN1c3RvbWl6ZSggJ2hlYWRlcl90ZXh0X2NvbG9yJywgKCB2YWx1ZSApID0+IHtcblx0XHR2YWx1ZS5iaW5kKCAoIHRvICkgPT4ge1xuXHRcdFx0Y29uc3QgaHNsID0gaGV4VG9IU0woIHRvICk7XG5cdFx0XHRjb25zdCBzZXRUbyA9IHRvID8gYGhzbCgkeyBoc2xbIDAgXSB9LCAkeyBoc2xbIDEgXSB9JSwgJHsgaHNsWyAyIF0gfSUpYCA6IHVuZGVmaW5lZDtcblx0XHRcdGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoICc6cm9vdCcgKS5zdHlsZS5zZXRQcm9wZXJ0eSggJy0tZ28tbmF2aWdhdGlvbi0tY29sb3ItLXRleHQnLCBzZXRUbyApO1xuXHRcdFx0ZG9jdW1lbnQucXVlcnlTZWxlY3RvciggJzpyb290JyApLnN0eWxlLnNldFByb3BlcnR5KCAnLS1nby1zaXRlLWRlc2NyaXB0aW9uLS1jb2xvci0tdGV4dCcsIHNldFRvICk7XG5cdFx0XHRkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCAnOnJvb3QnICkuc3R5bGUuc2V0UHJvcGVydHkoICctLWdvLXNlYXJjaC1idXR0b24tLWNvbG9yLS10ZXh0Jywgc2V0VG8gKTtcblx0XHRcdGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoICc6cm9vdCcgKS5zdHlsZS5zZXRQcm9wZXJ0eSggJy0tZ28tc2l0ZS10aXRsZS0tY29sb3ItLXRleHQnLCBzZXRUbyApO1xuXHRcdH0gKTtcblx0fSApO1xufTtcbiIsImV4cG9ydCBkZWZhdWx0ICgpID0+IHtcblx0LyoqXG5cdCAqIFNldCBMb2dvIHdpZHRoLlxuXHQgKlxuXHQgKiBAcGFyYW0geyp9IHdpZHRoXG5cdCAqL1xuXHRjb25zdCBzZXRMb2dvV2lkdGggPSAoIHdpZHRoICkgPT4ge1xuXHRcdGRvY3VtZW50LmRvY3VtZW50RWxlbWVudC5zdHlsZS5zZXRQcm9wZXJ0eSggJy0tZ28tbG9nby0tbWF4LXdpZHRoJywgd2lkdGggPyBgJHsgd2lkdGggfXB4YCA6ICdub25lJyApO1xuXHR9O1xuXG5cdC8qKlxuXHQgKiBTZXQgTG9nbyBtb2JpbGUgd2lkdGguXG5cdCAqXG5cdCAqIEBwYXJhbSB7Kn0gd2lkdGhcblx0ICovXG5cdGNvbnN0IHNldExvZ29Nb2JpbGVXaWR0aCA9ICggd2lkdGggKSA9PiB7XG5cdFx0ZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LnN0eWxlLnNldFByb3BlcnR5KCAnLS1nby1sb2dvLW1vYmlsZS0tbWF4LXdpZHRoJywgd2lkdGggPyBgJHsgd2lkdGggfXB4YCA6ICdub25lJyApO1xuXHR9O1xuXG5cdHdwLmN1c3RvbWl6ZSggJ2xvZ29fd2lkdGgnLCAoIHZhbHVlICkgPT4ge1xuXHRcdHZhbHVlLmJpbmQoICggdG8gKSA9PiBzZXRMb2dvV2lkdGgoIHRvICkgKTtcblx0fSApO1xuXG5cdHdwLmN1c3RvbWl6ZSggJ2xvZ29fd2lkdGhfbW9iaWxlJywgKCB2YWx1ZSApID0+IHtcblx0XHR2YWx1ZS5iaW5kKCAoIHRvICkgPT4gc2V0TG9nb01vYmlsZVdpZHRoKCB0byApICk7XG5cdH0gKTtcbn07XG4iLCJjb25zdCAkID0galF1ZXJ5OyAvLyBlc2xpbnQtZGlzYWJsZS1saW5lXG5cbmV4cG9ydCBkZWZhdWx0ICgpID0+IHtcblx0d3AuY3VzdG9taXplKCAncGFnZV90aXRsZXMnLCAoIHZhbHVlICkgPT4ge1xuXHRcdGNvbnN0IHNlbGVjdG9ycyA9ICcjY29udGVudCA+IC5lbnRyeS1oZWFkZXIsIGJvZHkucGFnZSBhcnRpY2xlIC5lbnRyeS1oZWFkZXIsIGJvZHkud29vY29tbWVyY2UgLmVudHJ5LWhlYWRlcic7XG5cdFx0dmFsdWUuYmluZCggKCB0byApID0+IHtcblx0XHRcdGlmICggdG8gKSB7XG5cdFx0XHRcdCQoICdib2R5JyApLmFkZENsYXNzKCAnaGFzLXBhZ2UtdGl0bGVzJyApO1xuXHRcdFx0XHQkKCBzZWxlY3RvcnMgKS5yZW1vdmVDbGFzcyggJ2Rpc3BsYXktbm9uZScgKTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdCQoICdib2R5JyApLnJlbW92ZUNsYXNzKCAnaGFzLXBhZ2UtdGl0bGVzJyApO1xuXHRcdFx0XHQkKCBzZWxlY3RvcnMgKS5hZGRDbGFzcyggJ2Rpc3BsYXktbm9uZScgKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cdH0gKTtcbn07XG4iLCIvKipcbiAqIEZ1bmN0aW9ucyB0byBjb252ZXJ0IGhleCBjb2xvciB0byBIU0xcbiAqXG4gKiBAcGFyYW0geyp9IEhcbiAqL1xuZXhwb3J0IGZ1bmN0aW9uIGhleFRvSFNMKCBIICkge1xuXHQvLyBDb252ZXJ0IGhleCB0byBSR0IgZmlyc3Rcblx0bGV0IGIgPSAwO1xuXHRsZXQgZyA9IDA7XG5cdGxldCByID0gMDtcblx0aWYgKCA0ID09PSBILmxlbmd0aCApIHtcblx0XHRyID0gYDB4JHsgSFsgMSBdIH0keyBIWyAxIF0gfWA7XG5cdFx0ZyA9IGAweCR7IEhbIDIgXSB9JHsgSFsgMiBdIH1gO1xuXHRcdGIgPSBgMHgkeyBIWyAzIF0gfSR7IEhbIDMgXSB9YDtcblx0fSBlbHNlIGlmICggNyA9PT0gSC5sZW5ndGggKSB7XG5cdFx0ciA9IGAweCR7IEhbIDEgXSB9JHsgSFsgMiBdIH1gO1xuXHRcdGcgPSBgMHgkeyBIWyAzIF0gfSR7IEhbIDQgXSB9YDtcblx0XHRiID0gYDB4JHsgSFsgNSBdIH0keyBIWyA2IF0gfWA7XG5cdH1cblxuXHQvLyBUaGVuIHRvIEhTTFxuXHRyIC89IDI1NTtcblx0ZyAvPSAyNTU7XG5cdGIgLz0gMjU1O1xuXG5cdGNvbnN0IGNtYXggPSBNYXRoLm1heCggciwgZywgYiApO1xuXHRjb25zdCBjbWluID0gTWF0aC5taW4oIHIsIGcsIGIgKTtcblx0Y29uc3QgZGVsdGEgPSBjbWF4IC0gY21pbjtcblxuXHRsZXQgaCA9IDA7XG5cdGxldFx0cyA9IDA7XG5cdGxldCBsID0gMDtcblxuXHRpZiAoIDAgPT09IGRlbHRhICkge1xuXHRcdGggPSAwO1xuXHR9IGVsc2UgaWYgKCBjbWF4ID09PSByICkge1xuXHRcdGggPSAoICggZyAtIGIgKSAvIGRlbHRhICkgJSA2O1xuXHR9IGVsc2UgaWYgKCBjbWF4ID09PSBnICkge1xuXHRcdGggPSAoICggYiAtIHIgKSAvIGRlbHRhICkgKyAyO1xuXHR9IGVsc2Uge1xuXHRcdGggPSAoICggciAtIGcgKSAvIGRlbHRhICkgKyA0O1xuXHR9XG5cblx0aCA9IE1hdGgucm91bmQoIGggKiA2MCApO1xuXG5cdGlmICggMCA+IGggKSB7XG5cdFx0aCArPSAzNjA7XG5cdH1cblxuXHRsID0gKCBjbWF4ICsgY21pbiApIC8gMjtcblx0cyA9IDAgPT09IGRlbHRhID8gMCA6IGRlbHRhIC8gKCAxIC0gTWF0aC5hYnMoICggMiAqIGwgKSAtIDEgKSApO1xuXHRzID0gKyggcyAqIDEwMCApLnRvRml4ZWQoKTtcblx0bCA9ICsoIGwgKiAxMDAgKS50b0ZpeGVkKCk7XG5cblx0cmV0dXJuIFsgaCwgcywgbCBdO1xufVxuIiwiLy8gVGhlIG1vZHVsZSBjYWNoZVxudmFyIF9fd2VicGFja19tb2R1bGVfY2FjaGVfXyA9IHt9O1xuXG4vLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcblx0dmFyIGNhY2hlZE1vZHVsZSA9IF9fd2VicGFja19tb2R1bGVfY2FjaGVfX1ttb2R1bGVJZF07XG5cdGlmIChjYWNoZWRNb2R1bGUgIT09IHVuZGVmaW5lZCkge1xuXHRcdHJldHVybiBjYWNoZWRNb2R1bGUuZXhwb3J0cztcblx0fVxuXHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuXHR2YXIgbW9kdWxlID0gX193ZWJwYWNrX21vZHVsZV9jYWNoZV9fW21vZHVsZUlkXSA9IHtcblx0XHQvLyBubyBtb2R1bGUuaWQgbmVlZGVkXG5cdFx0Ly8gbm8gbW9kdWxlLmxvYWRlZCBuZWVkZWRcblx0XHRleHBvcnRzOiB7fVxuXHR9O1xuXG5cdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuXHRfX3dlYnBhY2tfbW9kdWxlc19fW21vZHVsZUlkXShtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuXHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuXHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG59XG5cbiIsIi8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb25zIGZvciBoYXJtb255IGV4cG9ydHNcbl9fd2VicGFja19yZXF1aXJlX18uZCA9IGZ1bmN0aW9uKGV4cG9ydHMsIGRlZmluaXRpb24pIHtcblx0Zm9yKHZhciBrZXkgaW4gZGVmaW5pdGlvbikge1xuXHRcdGlmKF9fd2VicGFja19yZXF1aXJlX18ubyhkZWZpbml0aW9uLCBrZXkpICYmICFfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZXhwb3J0cywga2V5KSkge1xuXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIGtleSwgeyBlbnVtZXJhYmxlOiB0cnVlLCBnZXQ6IGRlZmluaXRpb25ba2V5XSB9KTtcblx0XHR9XG5cdH1cbn07IiwiX193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqLCBwcm9wKSB7IHJldHVybiBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqLCBwcm9wKTsgfSIsIi8vIGRlZmluZSBfX2VzTW9kdWxlIG9uIGV4cG9ydHNcbl9fd2VicGFja19yZXF1aXJlX18uciA9IGZ1bmN0aW9uKGV4cG9ydHMpIHtcblx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG5cdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG5cdH1cblx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbn07IiwiaW1wb3J0IENvbG9yU2NoZW1lUHJldmlldyBmcm9tICcuL2N1c3RvbWl6ZS9wcmV2aWV3L2NvbG9yLXNjaGVtZXMnO1xuaW1wb3J0IERlc2lnblN0eWxlUHJldmlldyBmcm9tICcuL2N1c3RvbWl6ZS9wcmV2aWV3L2Rlc2lnbi1zdHlsZSc7XG5pbXBvcnQgRm9vdGVyQ29sb3JzUHJldmlldyBmcm9tICcuL2N1c3RvbWl6ZS9wcmV2aWV3L2Zvb3Rlcic7XG5pbXBvcnQgSGVhZGVyQ29sb3JzUHJldmlldyBmcm9tICcuL2N1c3RvbWl6ZS9wcmV2aWV3L2hlYWRlcic7XG5pbXBvcnQgTG9nb1NpemluZ1ByZXZpZXcgZnJvbSAnLi9jdXN0b21pemUvcHJldmlldy9sb2dvLXNpemluZyc7XG5pbXBvcnQgUGFnZVRpdGxlc1ByZXZpZXcgZnJvbSAnLi9jdXN0b21pemUvcHJldmlldy9wYWdlLXRpdGxlcyc7XG5cbkRlc2lnblN0eWxlUHJldmlldygpO1xuSGVhZGVyQ29sb3JzUHJldmlldygpO1xuRm9vdGVyQ29sb3JzUHJldmlldygpO1xuQ29sb3JTY2hlbWVQcmV2aWV3KCk7XG5Mb2dvU2l6aW5nUHJldmlldygpO1xuUGFnZVRpdGxlc1ByZXZpZXcoKTtcbiJdLCJuYW1lcyI6W10sInNvdXJjZVJvb3QiOiIifQ==