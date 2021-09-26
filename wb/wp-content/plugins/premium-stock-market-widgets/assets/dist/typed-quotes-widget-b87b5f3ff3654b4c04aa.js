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
(window.webpackJsonp94003=window.webpackJsonp94003||[]).push([[42],{1047:function(e,t,s){"use strict";s.r(t);var a=function(){var e=this.$createElement;return(this._self._c||e)("generic",this._b({tag:"component"},"component",this.$attrs,!1))};a._withStripped=!0;var n=s(267),o=s(12),p=s(261),i=s(264),l=s(265),r=s(321),c={components:{Quote:i.a,Logo:l.a},mixins:[p.a,r.a],data:()=>({template:null}),created(){this.compileTemplate(),this.$watch("$attrs.markup",()=>{this.compileTemplate()})},methods:{componentMarkup:e=>"logo"===e?'<logo :asset="asset"></logo>':'<quote v-bind="$attrs" :asset="asset" field="'+e+'"></quote>',compileTemplate(){var e=this.$attrs.markup?this.$attrs.markup.replace(/{[a-z0-9_-]+}/gi,e=>{var t=e.replace(/[{}]/g,"");return this.componentMarkup(t)}):"";this.template=o.a.compile('<span :class="classes"><span ref="elements"><span v-if="display" v-for="asset in assets">'.concat(e,'</span></span><span ref="container"></span></span>')).render}},render:function(e){return this.template?this.template():null}},u=s(0),m=Object(u.a)(c,void 0,void 0,!1,null,null,null);m.options.__file="assets/js/components/widgets/typed-quotes/template.vue";var d={components:{Generic:m.exports},mixins:[n.a]},h=Object(u.a)(d,a,[],!1,null,null,null);h.options.__file="assets/js/components/widgets/typed-quotes/type.vue";t.default=h.exports}}]);