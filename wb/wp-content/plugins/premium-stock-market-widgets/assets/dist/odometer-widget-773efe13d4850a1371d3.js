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
(window.webpackJsonp94003=window.webpackJsonp94003||[]).push([[29],{1037:function(t,e,s){"use strict";s.r(e);var i=function(){var t=this.$createElement;return(this._self._c||t)("generic",this._b({key:this.key,tag:"component"},"component",this.$attrs,!1))};i._withStripped=!0;var a=s(267),r=function(){var t=this.$createElement,e=this._self._c||t;return e("div",{class:this.classes},[e("placeholder",{attrs:{display:this.display,height:"2em",width:"12em"}},[e("div",{ref:"container"})])],1)};r._withStripped=!0;var n=s(263),o=s(261),h=s(851),d=s.n(h),l=(s(852),s(854),s(856),s(858),s(860),s(862),s(864),{components:{Placeholder:n.a},mixins:[o.a],data:()=>({odometer:null}),computed:{value(){return this.getDataField(this.$attrs,this.asset,"price")},format:()=>"(,ddd).DD",theme(){return this.$attrs.theme}},methods:{onDataLoaded(){this.odometer=new d.a({el:this.$refs.container,value:.01,theme:this.theme,format:this.format,minIntegerLen:1}),this.odometer.render();var t=this.$refs.container.querySelector(".odometer-inside");t.setAttribute("data-before",this.formatDataField(this.$attrs,this.asset,"name")),t.setAttribute("data-after",this.getDataField(this.$attrs,this.asset,"currency")),this.odometer&&this.value&&this.odometer.update(this.value)}}}),m=s(0),c=Object(m.a)(l,r,[],!1,null,null,null);c.options.__file="assets/js/components/widgets/odometer/template.vue";var u={components:{Generic:c.exports},mixins:[a.a],computed:{key(){return this.$attrs.assets+"-"+this.$attrs.theme}}},p=Object(m.a)(u,i,[],!1,null,null,null);p.options.__file="assets/js/components/widgets/odometer/type.vue";e.default=p.exports}}]);