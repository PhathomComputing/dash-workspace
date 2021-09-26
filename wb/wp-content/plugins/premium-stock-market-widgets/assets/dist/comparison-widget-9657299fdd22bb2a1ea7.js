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
(window.webpackJsonp94003=window.webpackJsonp94003||[]).push([[18],{1034:function(t,a,s){"use strict";s.r(a);var r=function(){var t=this.$createElement;return(this._self._c||t)("generic",this._b({tag:"component"},"component",this.$attrs,!1))};r._withStripped=!0;var e=s(267),o=function(){var t=this,a=t.$createElement,s=t._self._c||a;return s("div",{class:t.classes,style:t.style},[t.$attrs.template.match(/^cards[0-9]*$/)?s("div",{staticClass:"smw-comparison-card-container"},t._l(t.assets,(function(a,r){return s("div",{key:r,staticClass:"smw-comparison-card"},[s("placeholder",{staticClass:"smw-asset-heading smw-flexbox-justify-content-center",attrs:{display:t.display,width:"6em",height:"2em",color:t.$attrs.color,opacity:t.$attrs.color?.6:.1}},[s("logo",{attrs:{asset:a}}),t._v(" "),s("quote",t._b({attrs:{asset:a,field:"symbol"}},"quote",t.$attrs,!1))],1),t._v(" "),t._l(t.fields,(function(r){return s("div",{key:r,staticClass:"smw-asset-field-container",class:"smw-asset-field-"+r},[s("div",{staticClass:"smw-asset-field-label"},[t._v("\n          "+t._s(t.translate(r)+("chart"===r?" ("+t.translate(t.$attrs.chart_range)+")":""))+"\n        ")]),t._v(" "),"chart"===r?[s("stock-market-widget",{staticClass:"smw-asset-chart",attrs:{type:"chart",template:"basic",color:t.$attrs.color,background:{direction:"top to bottom",size:200,colors:[t.$attrs.color,t.style["--smw-color-lighten40"]]},assets:a,axes:!1,api:t.api,range:t.$attrs.chart_range,interval:t.$attrs.chart_interval}})]:[s("placeholder",{staticClass:"smw-flexbox-justify-content-center",attrs:{display:t.display,color:t.$attrs.color,opacity:t.$attrs.color?.6:.1,width:"5em"}},["logo"===r?[s("logo",{attrs:{asset:a}})]:["change_abs","change_pct"].indexOf(r)>-1?[s("quote-indicator",t._b({staticClass:"fas",attrs:{asset:a,field:r,"down-class":"fa-caret-down","up-class":"fa-caret-up"}},"quote-indicator",t.$attrs,!1)),t._v(" "),s("quote",t._b({attrs:{asset:a,field:r,"color-indicator":!0}},"quote",t.$attrs,!1))]:"logo_name_link"===r&&t.$attrs.links&&void 0!==t.$attrs.links[a]?[s("logo",{attrs:{asset:a}}),t._v(" "),s("stock-market-widget",{attrs:{type:"button-link",template:"link",color:"default",assets:a,url:t.$attrs.links[a].url,target:t.$attrs.links_target,markup:"{name}",api:t.api}})]:"link"===r&&t.$attrs.links&&void 0!==t.$attrs.links[a]?[s("stock-market-widget",{attrs:{type:"button-link",template:"link",color:"default",assets:a,url:t.$attrs.links[a].url,target:t.$attrs.links_target,markup:t.$attrs.links[a].markup,api:t.api}})]:[s("quote",t._b({attrs:{asset:a,field:r}},"quote",t.$attrs,!1))]],2)]],2)}))],2)})),0):s("table",[s("thead",[s("tr",[s("th"),t._v(" "),t._l(t.assets,(function(a,r){return s("th",{key:r},[s("placeholder",{staticClass:"smw-flexbox-justify-content-center",attrs:{display:t.display,height:"1.8em",color:t.$attrs.color,opacity:t.$attrs.color?.6:.1,width:"5em"}},[s("logo",{attrs:{asset:a}}),t._v(" "),s("quote",t._b({attrs:{asset:a,field:"symbol"}},"quote",t.$attrs,!1))],1)],1)}))],2),t._v(" "),s("tr",[s("th"),t._v(" "),t._l(t.assets,(function(a,r){return s("th",{key:r},[s("placeholder",{staticClass:"smw-flexbox-justify-content-center",attrs:{display:t.display,height:"2em",color:t.$attrs.color,opacity:t.$attrs.color?.6:.1,width:"5em"}},[s("quote",t._b({attrs:{asset:a,field:"price"}},"quote",t.$attrs,!1))],1)],1)}))],2)]),t._v(" "),s("tbody",t._l(t.fields,(function(a){return s("tr",{key:a},[s("td",[t._v("\n          "+t._s(t.translate(a)+("chart"===a?" ("+t.translate(t.$attrs.chart_range)+")":""))+"\n        ")]),t._v(" "),t._l(t.assets,(function(r,e){return s("td",{key:e,class:"smw-cell-"+a.replace(/_/g,"-")},["chart"===a?[s("stock-market-widget",{attrs:{type:"chart",template:"basic",color:t.$attrs.color,background:{direction:"top to bottom",size:50,colors:[t.$attrs.color,"rgba(255,255,255,0)"]},assets:r,axes:!1,api:t.api,range:t.$attrs.chart_range,interval:t.$attrs.chart_interval}})]:[s("placeholder",{staticClass:"smw-flexbox-justify-content-center",attrs:{display:t.display,color:t.$attrs.color,opacity:t.$attrs.color?.6:.1,width:"5em"}},["logo"===a?[s("logo",{attrs:{asset:r}})]:["change_abs","change_pct"].indexOf(a)>-1?[s("quote-indicator",t._b({staticClass:"fas",attrs:{asset:r,field:a,"down-class":"fa-caret-down","up-class":"fa-caret-up"}},"quote-indicator",t.$attrs,!1)),t._v(" "),s("quote",t._b({attrs:{asset:r,field:a,"color-indicator":!0}},"quote",t.$attrs,!1))]:"logo_name_link"===a&&t.$attrs.links&&void 0!==t.$attrs.links[r]?[s("logo",{attrs:{asset:r}}),t._v(" "),s("stock-market-widget",{attrs:{type:"button-link",template:"link",color:"default",assets:r,url:t.$attrs.links[r].url,target:t.$attrs.links_target,markup:"{name}",api:t.api}})]:"link"===a&&t.$attrs.links&&void 0!==t.$attrs.links[r]?[s("stock-market-widget",{attrs:{type:"button-link",template:"link",color:"default",assets:r,url:t.$attrs.links[r].url,target:t.$attrs.links_target,markup:t.$attrs.links[r].markup,api:t.api}})]:[s("quote",t._b({attrs:{asset:r,field:a}},"quote",t.$attrs,!1))]],2)]],2)}))],2)})),0)])])};o._withStripped=!0;var d=s(261),c=s(264),i=s(265),l=s(266),m=s(23),n={components:{Placeholder:s(263).a,Quote:c.a,Logo:i.a,QuoteIndicator:l.a},mixins:[d.a],computed:{urls(){return this.$attrs.urls||[]},markups(){return this.$attrs.markups||[]},isBrightColor(){return Object(m.f)(this.$attrs.color)},style(){return{"--smw-color-lighten35-darken35":Object(m.g)(this.isBrightColor?-.35:.35,this.$attrs.color),"--smw-color-lighten10-darken10":Object(m.g)(this.isBrightColor?-.1:.1,this.$attrs.color),"--smw-color-lighten20":Object(m.g)(.2,this.$attrs.color),"--smw-color-lighten40":Object(m.g)(.4,this.$attrs.color),"--smw-color-darken10":Object(m.g)(-.1,this.$attrs.color),"--smw-color-darken20":Object(m.g)(-.2,this.$attrs.color)}}}},w=(s(799),s(0)),g=Object(w.a)(n,o,[],!1,null,"6c9f5022",null);g.options.__file="assets/js/components/widgets/comparison/template.vue";var b={components:{Generic:g.exports},mixins:[e.a]},f=Object(w.a)(b,r,[],!1,null,null,null);f.options.__file="assets/js/components/widgets/comparison/type.vue";a.default=f.exports},412:function(t,a,s){var r=s(28),e=s(800);"string"==typeof(e=e.__esModule?e.default:e)&&(e=[[t.i,e,""]]);var o={insert:"head",singleton:!1};r(e,o);t.exports=e.locals||{}},799:function(t,a,s){"use strict";var r=s(412);s.n(r).a},800:function(t,a,s){"use strict";s.r(a);var r=s(16),e=s.n(r)()(!1);e.push([t.i,".smw-widget .fas[data-v-6c9f5022]{margin-right:0.2em}.smw-widget table thead tr:first-child th[data-v-6c9f5022]{padding:0.5em 0}.smw-widget table thead tr:first-child th>div[data-v-6c9f5022]{height:1.8em}.smw-widget table thead tr:first-child th>div .smw-field-symbol[data-v-6c9f5022]{font-size:1.6em}.smw-widget table thead tr:first-child th>div .smw-field-logo[data-v-6c9f5022]{height:1.8em;margin-right:0.5em}.smw-widget table thead tr:last-child th[data-v-6c9f5022]{padding:0.8em 0}.smw-widget table thead tr:last-child th>div[data-v-6c9f5022]{height:2em}.smw-widget table thead tr:last-child th>div .smw-field-price[data-v-6c9f5022] {font-size:2em}.smw-widget table thead tr:last-child th>div .smw-field-price[data-v-6c9f5022] .smw-currency-symbol{font-size:0.5em;margin-right:0.2em}.smw-widget .smw-comparison-card-container[data-v-6c9f5022]{display:flex;align-items:center;justify-content:center}.smw-widget .smw-comparison-card-container .smw-asset-field-label[data-v-6c9f5022]{text-align:center}@media screen and (max-width: 768px){.smw-widget .smw-comparison-card-container[data-v-6c9f5022]{flex-direction:column;align-items:flex-start}.smw-widget .smw-comparison-card-container .smw-comparison-card[data-v-6c9f5022]:not(:last-child){margin-bottom:2em !important}}.smw-widget.smw-cards .smw-comparison-card[data-v-6c9f5022]{-webkit-box-shadow:0 0 50px 0 rgba(0,0,0,0.1);-moz-box-shadow:0 0 50px 0 rgba(0,0,0,0.1);box-shadow:0 0 50px 0 rgba(0,0,0,0.1);margin:0 2em;min-width:16em}.smw-widget.smw-cards .smw-comparison-card[data-v-6c9f5022]:hover{-webkit-box-shadow:0 0 30px 0 rgba(0,0,0,0.1);-moz-box-shadow:0 0 30px 0 rgba(0,0,0,0.1);box-shadow:0 0 30px 0 rgba(0,0,0,0.1)}.smw-widget.smw-cards .smw-comparison-card .smw-asset-heading[data-v-6c9f5022]{margin:0 1em 1em 1em;padding:1em 0;border-bottom:1px solid rgba(0,0,0,0.1)}.smw-widget.smw-cards .smw-comparison-card .smw-asset-heading .smw-field-symbol[data-v-6c9f5022]{font-size:1.6em}.smw-widget.smw-cards .smw-comparison-card .smw-asset-heading .smw-field-logo[data-v-6c9f5022]{height:2em;margin-right:0.5em}.smw-widget.smw-cards .smw-comparison-card .smw-asset-field-container[data-v-6c9f5022]:not(.smw-asset-field-chart){padding:0.5em}.smw-widget.smw-cards .smw-comparison-card .smw-asset-field-container.smw-asset-field-chart .smw-asset-field-label[data-v-6c9f5022]{display:none}.smw-widget.smw-cards .smw-comparison-card .smw-asset-field-container .smw-asset-field-label[data-v-6c9f5022]{text-transform:uppercase;color:#8c8c8c;margin-bottom:0.2em}.smw-widget.smw-cards2 .smw-comparison-card[data-v-6c9f5022]{color:#fff;-moz-border-radius:.4em;-webkit-border-radius:.4em;border-radius:.4em;background:linear-gradient(135deg, var(--smw-color-lighten20), var(--smw-color-darken20));margin:0 1em;min-width:16em}.smw-widget.smw-cards2 .smw-comparison-card[data-v-6c9f5022]:hover{-webkit-box-shadow:0 0 10px 0 var(--smw-color);-moz-box-shadow:0 0 10px 0 var(--smw-color);box-shadow:0 0 10px 0 var(--smw-color)}.smw-widget.smw-cards2 .smw-comparison-card .smw-asset-heading[data-v-6c9f5022]{padding:1em;margin-bottom:1em;background:rgba(255,255,255,0.25)}.smw-widget.smw-cards2 .smw-comparison-card .smw-asset-heading .smw-field-symbol[data-v-6c9f5022]{font-size:1.6em}.smw-widget.smw-cards2 .smw-comparison-card .smw-asset-heading .smw-field-logo[data-v-6c9f5022]{height:2em;margin-right:0.5em}.smw-widget.smw-cards2 .smw-comparison-card .smw-asset-field-container[data-v-6c9f5022]:not(.smw-asset-field-chart){padding:0.5em}.smw-widget.smw-cards2 .smw-comparison-card .smw-asset-field-container.smw-asset-field-chart .smw-asset-field-label[data-v-6c9f5022]{display:none}.smw-widget.smw-cards2 .smw-comparison-card .smw-asset-field-container .smw-asset-field-label[data-v-6c9f5022]{text-transform:uppercase;margin-bottom:0.2em;font-size:0.8em;font-weight:bold}.smw-widget.smw-cards2 .smw-comparison-card .smw-asset-field-container .smw-field.smw-up[data-v-6c9f5022],.smw-widget.smw-cards2 .smw-comparison-card .smw-asset-field-container .smw-field.smw-down[data-v-6c9f5022],.smw-widget.smw-cards2 .smw-comparison-card .smw-asset-field-container .fas.smw-up[data-v-6c9f5022],.smw-widget.smw-cards2 .smw-comparison-card .smw-asset-field-container .fas.smw-down[data-v-6c9f5022]{color:#fff}.smw-widget.smw-cards2 .smw-comparison-card .smw-asset-field-container .smw-asset-chart[data-v-6c9f5022] .smw-chart canvas{border-bottom-left-radius:0.4em;border-bottom-right-radius:0.4em}.smw-widget.smw-basic table thead tr th[data-v-6c9f5022]{color:var(--smw-color-lighten35-darken35);background:var(--smw-color);background:linear-gradient(to bottom, var(--smw-color), var(--smw-color-lighten10-darken10))}.smw-widget.smw-basic table tbody tr td[data-v-6c9f5022]{padding:0.7em;border-bottom:1px solid var(--smw-color)}.smw-widget.smw-basic2 table thead tr th[data-v-6c9f5022]{color:var(--smw-color);border-right:1px dashed}.smw-widget.smw-basic2 table tbody tr td[data-v-6c9f5022]{padding:0.7em;border-right:1px dashed var(--smw-color)}.smw-widget.smw-basic2 table tbody tr td[data-v-6c9f5022]:first-child{font-weight:bold}.smw-widget.smw-black-background table[data-v-6c9f5022]{color:var(--smw-color);background:#000}.smw-widget.smw-black-background table thead tr:last-child th[data-v-6c9f5022]{border-bottom:2px solid var(--smw-color)}.smw-widget.smw-black-background table thead tr th[data-v-6c9f5022]{color:var(--smw-color)}.smw-widget.smw-black-background table tbody tr td[data-v-6c9f5022]{padding:0.7em;border-bottom:1px solid var(--smw-color);color:var(--smw-color)}.smw-widget.smw-black-background table tbody tr td i.smw-up[data-v-6c9f5022],.smw-widget.smw-black-background table tbody tr td span.smw-up[data-v-6c9f5022]{color:var(--smw-color)}.smw-widget.smw-black-background table tbody tr td i.smw-down[data-v-6c9f5022],.smw-widget.smw-black-background table tbody tr td span.smw-down[data-v-6c9f5022]{color:var(--smw-color)}.smw-widget.smw-color-background table[data-v-6c9f5022]{color:#fff}.smw-widget.smw-color-background table thead tr th[data-v-6c9f5022]{color:rgba(255,255,255,0.7);background:var(--smw-color);background:linear-gradient(to bottom, var(--smw-color), var(--smw-color-lighten10-darken10))}.smw-widget.smw-color-background table tbody tr[data-v-6c9f5022]{background:var(--smw-color)}.smw-widget.smw-color-background table tbody tr[data-v-6c9f5022]:nth-child(odd){background:var(--smw-color)}.smw-widget.smw-color-background table tbody tr[data-v-6c9f5022]:nth-child(even){background:var(--smw-color-lighten10-darken10)}.smw-widget.smw-color-background table tbody tr td[data-v-6c9f5022]{padding:0.7em}.smw-widget.smw-color-background table tbody tr td span.smw-up[data-v-6c9f5022]{color:#fff}.smw-widget.smw-color-background table tbody tr td span.smw-down[data-v-6c9f5022]{color:#fff}.smw-widget.smw-color-background2 table thead tr:first-child th[data-v-6c9f5022]{color:#131313}.smw-widget.smw-color-background2 table thead tr th[data-v-6c9f5022]{background:var(--smw-color-lighten20)}.smw-widget.smw-color-background2 table thead tr th[data-v-6c9f5022]:first-child{background:var(--smw-color-darken10)}.smw-widget.smw-color-background2 table tbody tr td[data-v-6c9f5022]{color:#131313;padding:0.7em;background:var(--smw-color-lighten20);border-top:1px solid var(--smw-color-darken10)}.smw-widget.smw-color-background2 table tbody tr td[data-v-6c9f5022]:first-child{background:var(--smw-color-darken10);border-top:none}.smw-widget.smw-color-background2 table tbody tr td i.smw-up[data-v-6c9f5022],.smw-widget.smw-color-background2 table tbody tr td span.smw-up[data-v-6c9f5022]{color:#131313}.smw-widget.smw-color-background2 table tbody tr td i.smw-down[data-v-6c9f5022],.smw-widget.smw-color-background2 table tbody tr td span.smw-down[data-v-6c9f5022]{color:#131313}.smw-widget.smw-color-background2 table tbody tr td[data-v-6c9f5022]:first-child{font-weight:bold;color:#fff}.smw-widget.smw-color-background2 table tbody tr td .smw-chart[data-v-6c9f5022]{height:5em}\n",""]),a.default=e}}]);