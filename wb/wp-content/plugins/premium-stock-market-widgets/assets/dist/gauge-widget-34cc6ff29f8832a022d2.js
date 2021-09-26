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
(window.webpackJsonp94003=window.webpackJsonp94003||[]).push([[20],{1036:function(t,i,a){"use strict";a.r(i);var e=function(){var t=this.$createElement;return(this._self._c||t)("generic",this._b({tag:"component"},"component",this.$attrs,!1))};e._withStripped=!0;var s=a(267),h=function(){var t=this.$createElement,i=this._self._c||t;return i("div",{class:this.classes},[this.display?i("div",{ref:"container",staticStyle:{height:"100%"}}):i("div",{staticClass:"smw-flexbox smw-flexbox-align-items-center smw-flexbox-justify-content-center"},[i("i",{staticClass:"fas fa-spinner fa-spin"})])])};h._withStripped=!0;var n=a(261),r=a(23),o=a(803),l={mixins:[n.a],data:()=>({chartData:null,chart:null}),computed:{name(){return this.getDataField(this.$attrs,this.asset,"symbol")},value(){return this.getDataField(this.$attrs,this.asset,"price")},min(){return"52_week_low_high"===this.$attrs.low_high?this.getDataField(this.$attrs,this.asset,"52_week_low"):this.getDataField(this.$attrs,this.asset,"low")},max(){return"52_week_low_high"===this.$attrs.low_high?this.getDataField(this.$attrs,this.asset,"52_week_high"):this.getDataField(this.$attrs,this.asset,"high")},chartOptions(){return{min:this.min,max:this.max,redColor:Object(r.g)(.15,r.a.red),yellowColor:Object(r.g)(.15,r.a.yellow),greenColor:Object(r.g)(.15,r.a.green),redFrom:this.min,redTo:this.min+(this.max-this.min)/3,yellowFrom:this.min+(this.max-this.min)/3,yellowTo:this.min+2*(this.max-this.min)/3,greenFrom:this.min+2*(this.max-this.min)/3,greenTo:this.max,majorTicks:[this.translate("low"),this.translate("high")],minorTicks:15,animation:{duration:2500,easing:"out"}}}},created(){this.$watch("$attrs.low_high",t=>{this.initChart()})},methods:{onDataLoaded(){o.a.load(this.initChart,{packages:["gauge"]})},initChart(){this.chartData=o.a.api.visualization.arrayToDataTable([["Label","Value"],[this.name,this.min]]),this.chart||(this.chart=new o.a.api.visualization.Gauge(this.$refs.container)),this.drawChart(),this.animateGauge()},animateGauge(){setTimeout(()=>{this.chartData.setValue(0,1,this.value),this.drawChart()},200)},drawChart(){this.chart.draw(this.chartData,this.chartOptions)}}},c=(a(804),a(0)),m=Object(c.a)(l,h,[],!1,null,"0a77f91e",null);m.options.__file="assets/js/components/widgets/gauge/template.vue";var u={components:{Generic:m.exports},mixins:[s.a]},g=Object(c.a)(u,e,[],!1,null,null,null);g.options.__file="assets/js/components/widgets/gauge/type.vue";i.default=g.exports},414:function(t,i,a){var e=a(28),s=a(805);"string"==typeof(s=s.__esModule?s.default:s)&&(s=[[t.i,s,""]]);var h={insert:"head",singleton:!1};e(s,h);t.exports=s.locals||{}},804:function(t,i,a){"use strict";var e=a(414);a.n(e).a},805:function(t,i,a){"use strict";a.r(i);var e=a(16),s=a.n(e)()(!1);s.push([t.i,".smw-widget[data-v-0a77f91e]{color:inherit;height:15em}.smw-widget .smw-flexbox[data-v-0a77f91e]{color:inherit;height:100%}\n",""]),i.default=s}}]);