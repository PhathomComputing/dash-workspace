/*!
 * 
 * Premium Stock Market Widgets
 * -----------------------------
 * Version 3.2.6, built on Friday, June 4, 2021
 * Copyright (c) Financial apps and plugins <info@financialplugins.com>. All rights reserved
 * Demo: https://stockmarketwidgets.financialplugins.com/
 * Purchase (WordPress version): https://1.envato.market/az97R
 * Purchase (PHP version): https://1.envato.market/AQ17o
 * Like: https://www.facebook.com/financialplugins/
 * 
 */
(window.webpackJsonp94003=window.webpackJsonp94003||[]).push([[30],{1003:function(e,t,r){"use strict";r.r(t);var o=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{class:e.classes},[r("asset-dropdown",{attrs:{color:e.$attrs.color,default:e.$attrs.assets[0]},on:{change:function(t){e.selectedAsset=t}}}),e._v(" "),e.asset?r("stock-market-widget",{attrs:{type:"card",template:"search-"+e.$attrs.template,color:e.$attrs.color,assets:e.asset,api:e.$attrs.api}}):e._e()],1)};o._withStripped=!0;var s=r(261),n={components:{AssetDropdown:r(504).a},mixins:[s.a],data:()=>({selectedAsset:null}),computed:{asset(){return this.selectedAsset?this.selectedAsset.symbol:this.$attrs.assets[0]}}},a=r(0),i=Object(a.a)(n,o,[],!1,null,null,null);i.options.__file="assets/js/components/widgets/search/quote/template.vue";t.default=i.exports},1004:function(e,t,r){"use strict";r.r(t);var o=function(){var e=this.$createElement,t=this._self._c||e;return t("div",{class:this.classes},[t("asset-dropdown",{attrs:{color:this.$attrs.color},on:{change:this.openUrl}})],1)};o._withStripped=!0;var s=r(261),n={components:{AssetDropdown:r(504).a},mixins:[s.a],data:()=>({}),methods:{getUrl(e){return this.$attrs.url?this.$attrs.url.replace(/{[a-z0-9_-]+}/gi,t=>{var r=t.replace(/{|}/g,"");return"name"===r?e.text.replace(/\s+/g,"-"):"name_lc"===r?e.text.replace(/\s+/g,"-").toLowerCase():"symbol"===r?e.symbol:"symbol_lc"===r?e.symbol.toLowerCase():void 0}):""},openUrl(e){window.open(this.getUrl(e),this.$attrs.target)}}},a=r(0),i=Object(a.a)(n,o,[],!1,null,null,null);i.options.__file="assets/js/components/widgets/search/redirect/template.vue";t.default=i.exports},1060:function(e,t,r){"use strict";r.r(t);var o=function(){var e=this.$createElement;return(this._self._c||e)(this.template,this._b({tag:"component"},"component",this.$attrs,!1))};o._withStripped=!0;var s=r(267),n=r(10);function a(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);t&&(o=o.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,o)}return r}function i(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?a(Object(r),!0).forEach((function(t){l(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):a(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function l(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}var c=Object(n.d)(r(866)),d={components:i(i({},c),{},{Quote2:c.quote,Quote3:c.quote}),mixins:[s.a]},p=r(0),v=Object(p.a)(d,o,[],!1,null,null,null);v.options.__file="assets/js/components/widgets/search/type.vue";t.default=v.exports},47:function(e,t,r){var o=r(28),s=r(83);"string"==typeof(s=s.__esModule?s.default:s)&&(s=[[e.i,s,""]]);var n={insert:"head",singleton:!1};o(s,n);e.exports=s.locals||{}},83:function(e,t,r){"use strict";r.r(t);var o=r(16),s=r.n(o)()(!1);s.push([e.i,'.v-select{position:relative;font-family:inherit}.v-select,.v-select *{box-sizing:border-box}@-webkit-keyframes vSelectSpinner{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}@keyframes vSelectSpinner{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}.vs__fade-enter-active,.vs__fade-leave-active{pointer-events:none;transition:opacity .15s cubic-bezier(1, 0.5, 0.8, 1)}.vs__fade-enter,.vs__fade-leave-to{opacity:0}.vs--disabled .vs__dropdown-toggle,.vs--disabled .vs__clear,.vs--disabled .vs__search,.vs--disabled .vs__selected,.vs--disabled .vs__open-indicator{cursor:not-allowed;background-color:#f8f8f8}.v-select[dir="rtl"] .vs__actions{padding:0 3px 0 6px}.v-select[dir="rtl"] .vs__clear{margin-left:6px;margin-right:0}.v-select[dir="rtl"] .vs__deselect{margin-left:0;margin-right:2px}.v-select[dir="rtl"] .vs__dropdown-menu{text-align:right}.vs__dropdown-toggle{appearance:none;display:flex;padding:0 0 4px 0;background:none;border:1px solid rgba(60,60,60,0.26);border-radius:4px;white-space:normal}.vs__selected-options{display:flex;flex-basis:100%;flex-grow:1;flex-wrap:wrap;padding:0 2px;position:relative}.vs__actions{display:flex;align-items:center;padding:4px 6px 0 3px}.vs--searchable .vs__dropdown-toggle{cursor:text}.vs--unsearchable .vs__dropdown-toggle{cursor:pointer}.vs--open .vs__dropdown-toggle{border-bottom-color:transparent;border-bottom-left-radius:0;border-bottom-right-radius:0}.vs__open-indicator{fill:rgba(60,60,60,0.5);transform:scale(1);transition:transform 150ms cubic-bezier(1, -0.115, 0.975, 0.855);transition-timing-function:cubic-bezier(1, -0.115, 0.975, 0.855)}.vs--open .vs__open-indicator{transform:rotate(180deg) scale(1)}.vs--loading .vs__open-indicator{opacity:0}.vs__clear{fill:rgba(60,60,60,0.5);padding:0;border:0;background-color:transparent;cursor:pointer;margin-right:8px}.vs__dropdown-menu{display:block;box-sizing:border-box;position:absolute;top:calc(100% - 1px);left:0;z-index:1000;padding:5px 0;margin:0;width:100%;max-height:350px;min-width:160px;overflow-y:auto;box-shadow:0px 3px 6px 0px rgba(0,0,0,0.15);border:1px solid rgba(60,60,60,0.26);border-top-style:none;border-radius:0 0 4px 4px;text-align:left;list-style:none;background:#fff}.vs__no-options{text-align:center}.vs__dropdown-option{line-height:1.42857143;display:block;padding:3px 20px;clear:both;color:#333;white-space:nowrap}.vs__dropdown-option:hover{cursor:pointer}.vs__dropdown-option--highlight{background:#4d56db;color:#fff}.vs__dropdown-option--disabled{background:inherit;color:rgba(60,60,60,0.5)}.vs__dropdown-option--disabled:hover{cursor:inherit}.vs__selected{display:flex;align-items:center;background-color:#f0f0f0;border:1px solid rgba(60,60,60,0.26);border-radius:4px;color:#333;line-height:1.4;margin:4px 2px 0px 2px;padding:0 0.25em;z-index:0}.vs__deselect{display:inline-flex;appearance:none;margin-left:4px;padding:0;border:0;cursor:pointer;background:none;fill:rgba(60,60,60,0.5);text-shadow:0 1px 0 #fff}.vs--single .vs__selected{background-color:transparent;border-color:transparent}.vs--single.vs--open .vs__selected{position:absolute;opacity:.4}.vs--single.vs--searching .vs__selected{display:none}.vs__search::-webkit-search-cancel-button{display:none}.vs__search::-webkit-search-decoration,.vs__search::-webkit-search-results-button,.vs__search::-webkit-search-results-decoration,.vs__search::-ms-clear{display:none}.vs__search,.vs__search:focus{appearance:none;line-height:1.4;font-size:1em;border:1px solid transparent;border-left:none;outline:none;margin:4px 0 0 0;padding:0 7px;background:none;box-shadow:none;width:0;max-width:100%;flex-grow:1;z-index:1}.vs__search::placeholder{color:inherit}.vs--unsearchable .vs__search{opacity:1}.vs--unsearchable:not(.vs--disabled) .vs__search:hover{cursor:pointer}.vs--single.vs--searching:not(.vs--open):not(.vs--loading) .vs__search{opacity:.2}.vs__spinner{align-self:center;opacity:0;font-size:5px;text-indent:-9999em;overflow:hidden;border-top:0.9em solid rgba(100,100,100,0.1);border-right:0.9em solid rgba(100,100,100,0.1);border-bottom:0.9em solid rgba(100,100,100,0.1);border-left:0.9em solid rgba(60,60,60,0.45);transform:translateZ(0);animation:vSelectSpinner 1.1s infinite linear;transition:opacity .1s}.vs__spinner,.vs__spinner:after{border-radius:50%;width:5em;height:5em}.vs--loading .vs__spinner{opacity:1}.v-select .vs__dropdown-toggle{min-height:2.5em !important}.v-select .vs__dropdown-toggle:focus,.v-select .vs__dropdown-toggle:active{border-color:#4d56db;box-shadow:0 0 0 0.125em rgba(77,86,219,0.25) !important;outline:none !important}.v-select .vs__search{border:none !important;box-shadow:none !important;outline:none !important}.v-select .vs__search:focus{outline:none !important}\n',""]),t.default=s},866:function(e,t,r){var o={"./quote/template.vue":1003,"./redirect/template.vue":1004};function s(e){var t=n(e);return r(t)}function n(e){if(!r.o(o,e)){var t=new Error("Cannot find module '"+e+"'");throw t.code="MODULE_NOT_FOUND",t}return o[e]}s.keys=function(){return Object.keys(o)},s.resolve=n,e.exports=s,s.id=866}}]);