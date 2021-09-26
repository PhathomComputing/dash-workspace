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
(window.webpackJsonp94003=window.webpackJsonp94003||[]).push([[40],{1046:function(t,s,o){"use strict";o.r(s);var a=function(){var t=this.$createElement;return(this._self._c||t)("generic",this._b({tag:"component"},"component",this.$attrs,!1))};a._withStripped=!0;var i=o(267),e=o(261),r=(o(927),o(929)),n=o(23),l={mixins:[e.a],data:()=>({loading:!1}),computed:{style(){return this.$attrs.color?{color:{"--smw-color-rgba80":Object(n.d)(this.$attrs.color,.8)},"black-background":{"--smw-color":this.$attrs.color},gradient:{"--smw-color":this.$attrs.color,"--smw-color-lighten10":Object(n.g)(.1,this.$attrs.color),"--smw-color-lighten20":Object(n.g)(.2,this.$attrs.color),"--smw-color-darken20":Object(n.g)(-.4,this.$attrs.color)}}:""}},created(){["template","color","logo","timeout","position","transition_in","transition_out"].forEach(t=>{this.$watch("$attrs."+t,()=>{this.displayToast()})})},methods:{onDataLoaded(){this.displayToast()},displayToast(){if(!this.loading){this.loading=!0;var t=void 0!==this.config.assetsLogoImages[this.asset]?this.config.pluginUrl+"/assets/images/logo/"+this.config.assetsLogoImages[this.asset]:null,s="smw-toast-"+Math.round(99999*Math.random());r.show({id:s,class:this.classes.join(" "),title:this.asset,message:this.formatDataField(this.$attrs,this.asset,"name")+" "+this.getDataField(this.$attrs,this.asset,"currency_symbol")+this.formatDataField(this.$attrs,this.asset,"price")+" ("+this.formatDataField(this.$attrs,this.asset,"change_pct")+")",timeout:1e3*parseInt(this.$attrs.timeout,10),image:this.$attrs.logo&&t?t:"",position:this.$attrs.position,transitionIn:this.$attrs.transition_in,transitionOut:this.$attrs.transition_out,onOpening:()=>{setTimeout(()=>{this.loading=!1},700)}});var o=document.getElementById(s);o&&this.style[this.$attrs.template]&&Object.keys(this.style[this.$attrs.template]).forEach(t=>{o.style.setProperty(t,this.style[this.$attrs.template][t])})}}},render:()=>null},c=(o(930),o(0)),A=Object(c.a)(l,void 0,void 0,!1,null,null,null);A.options.__file="assets/js/components/widgets/toast/template.vue";var m={components:{Generic:A.exports},mixins:[i.a]},h=Object(c.a)(m,a,[],!1,null,null,null);h.options.__file="assets/js/components/widgets/toast/type.vue";s.default=h.exports},462:function(t,s,o){var a=o(28),i=o(931);"string"==typeof(i=i.__esModule?i.default:i)&&(i=[[t.i,i,""]]);var e={insert:"head",singleton:!1};a(i,e);t.exports=i.locals||{}},930:function(t,s,o){"use strict";var a=o(462);o.n(a).a},931:function(t,s,o){"use strict";o.r(s);var a=o(16),i=o.n(a)()(!1);i.push([t.i,".smw-toast.smw-color{background:var(--smw-color-rgba80);border:1px solid var(--smw-color)}.smw-toast.smw-color p.iziToast-message{color:#000}.smw-toast.smw-black-background{background:#000}.smw-toast.smw-black-background .iziToast-close{background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAQAAADZc7J/AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAADdcAAA3XAUIom3gAAAAHdElNRQfgCR4OIQIPSao6AAAAwElEQVRIx72VUQ6EIAwFmz2XB+AConhjzqTJ7JeGKhLYlyx/BGdoBVpjIpMJNjgIZDKTkQHYmYfwmR2AfAqGFBcO2QjXZCd24bEggvd1KBx+xlwoDpYmvnBUUy68DYXD77ESr8WDtYqvxRex7a8oHP4Wo1Mkt5I68Mc+qYqv1h5OsZmZsQ3gj/02h6cO/KEYx29hu3R+VTTwz6D3TymIP1E8RvEiiVdZfEzicxYLiljSxKIqlnW5seitTW6uYnv/Aqh4whX3mEUrAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDE2LTA5LTMwVDE0OjMzOjAyKzAyOjAwl6RMVgAAACV0RVh0ZGF0ZTptb2RpZnkAMjAxNi0wOS0zMFQxNDozMzowMiswMjowMOb59OoAAAAZdEVYdFNvZnR3YXJlAHd3dy5pbmtzY2FwZS5vcmeb7jwaAAAAAElFTkSuQmCC) no-repeat 50% 50%;background-size:8px;opacity:0.6}.smw-toast.smw-black-background .iziToast-title,.smw-toast.smw-black-background p.iziToast-message{color:var(--smw-color)}.smw-toast.smw-gradient{color:#000;border-color:var(--smw-color);background:var(--smw-color);background:linear-gradient(to right, var(--smw-color-lighten20), var(--smw-color-lighten10))}.smw-toast.smw-gradient .iziToast-title,.smw-toast.smw-gradient p.iziToast-message{color:var(--smw-color-darken20)}\n",""]),s.default=i}}]);