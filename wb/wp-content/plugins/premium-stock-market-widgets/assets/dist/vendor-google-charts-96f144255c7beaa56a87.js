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
(window.webpackJsonp94003=window.webpackJsonp94003||[]).push([[46],{803:function(t,e,s){"use strict";s.d(e,"a",(function(){return n}));const a=Symbol("loadScript"),c=Symbol("instance");let r;class i{get[c](){return r}set[c](t){r=t}constructor(){if(this[c])return this[c];this[c]=this}reset(){r=null}[a](){return this.scriptPromise||(this.scriptPromise=new Promise(t=>{const e=document.getElementsByTagName("body")[0],s=document.createElement("script");s.type="text/javascript",s.onload=function(){n.api=window.google,n.api.charts.load("current",{packages:["corechart","table"]}),n.api.charts.setOnLoadCallback(()=>{t()})},s.src="https://www.gstatic.com/charts/loader.js",e.appendChild(s)})),this.scriptPromise}load(t,e){return this[a]().then(()=>{if(e){let s={};s=e instanceof Object?e:Array.isArray(e)?{packages:e}:{packages:[e]},this.api.charts.load("current",s),this.api.charts.setOnLoadCallback(t)}else{if("function"!=typeof t)throw"callback must be a function";t()}})}}const n=new i}}]);