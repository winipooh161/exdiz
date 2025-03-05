const jt=()=>{};/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Ze=function(e){const t=[];let n=0;for(let r=0;r<e.length;r++){let s=e.charCodeAt(r);s<128?t[n++]=s:s<2048?(t[n++]=s>>6|192,t[n++]=s&63|128):(s&64512)===55296&&r+1<e.length&&(e.charCodeAt(r+1)&64512)===56320?(s=65536+((s&1023)<<10)+(e.charCodeAt(++r)&1023),t[n++]=s>>18|240,t[n++]=s>>12&63|128,t[n++]=s>>6&63|128,t[n++]=s&63|128):(t[n++]=s>>12|224,t[n++]=s>>6&63|128,t[n++]=s&63|128)}return t},Ft=function(e){const t=[];let n=0,r=0;for(;n<e.length;){const s=e[n++];if(s<128)t[r++]=String.fromCharCode(s);else if(s>191&&s<224){const i=e[n++];t[r++]=String.fromCharCode((s&31)<<6|i&63)}else if(s>239&&s<365){const i=e[n++],o=e[n++],l=e[n++],f=((s&7)<<18|(i&63)<<12|(o&63)<<6|l&63)-65536;t[r++]=String.fromCharCode(55296+(f>>10)),t[r++]=String.fromCharCode(56320+(f&1023))}else{const i=e[n++],o=e[n++];t[r++]=String.fromCharCode((s&15)<<12|(i&63)<<6|o&63)}}return t.join("")},Qe={byteToCharMap_:null,charToByteMap_:null,byteToCharMapWebSafe_:null,charToByteMapWebSafe_:null,ENCODED_VALS_BASE:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",get ENCODED_VALS(){return this.ENCODED_VALS_BASE+"+/="},get ENCODED_VALS_WEBSAFE(){return this.ENCODED_VALS_BASE+"-_."},HAS_NATIVE_SUPPORT:typeof atob=="function",encodeByteArray(e,t){if(!Array.isArray(e))throw Error("encodeByteArray takes an array as a parameter");this.init_();const n=t?this.byteToCharMapWebSafe_:this.byteToCharMap_,r=[];for(let s=0;s<e.length;s+=3){const i=e[s],o=s+1<e.length,l=o?e[s+1]:0,f=s+2<e.length,p=f?e[s+2]:0,m=i>>2,E=(i&3)<<4|l>>4;let T=(l&15)<<2|p>>6,B=p&63;f||(B=64,o||(T=64)),r.push(n[m],n[E],n[T],n[B])}return r.join("")},encodeString(e,t){return this.HAS_NATIVE_SUPPORT&&!t?btoa(e):this.encodeByteArray(Ze(e),t)},decodeString(e,t){return this.HAS_NATIVE_SUPPORT&&!t?atob(e):Ft(this.decodeStringToByteArray(e,t))},decodeStringToByteArray(e,t){this.init_();const n=t?this.charToByteMapWebSafe_:this.charToByteMap_,r=[];for(let s=0;s<e.length;){const i=n[e.charAt(s++)],l=s<e.length?n[e.charAt(s)]:0;++s;const p=s<e.length?n[e.charAt(s)]:64;++s;const E=s<e.length?n[e.charAt(s)]:64;if(++s,i==null||l==null||p==null||E==null)throw new xt;const T=i<<2|l>>4;if(r.push(T),p!==64){const B=l<<4&240|p>>2;if(r.push(B),E!==64){const R=p<<6&192|E;r.push(R)}}}return r},init_(){if(!this.byteToCharMap_){this.byteToCharMap_={},this.charToByteMap_={},this.byteToCharMapWebSafe_={},this.charToByteMapWebSafe_={};for(let e=0;e<this.ENCODED_VALS.length;e++)this.byteToCharMap_[e]=this.ENCODED_VALS.charAt(e),this.charToByteMap_[this.byteToCharMap_[e]]=e,this.byteToCharMapWebSafe_[e]=this.ENCODED_VALS_WEBSAFE.charAt(e),this.charToByteMapWebSafe_[this.byteToCharMapWebSafe_[e]]=e,e>=this.ENCODED_VALS_BASE.length&&(this.charToByteMap_[this.ENCODED_VALS_WEBSAFE.charAt(e)]=e,this.charToByteMapWebSafe_[this.ENCODED_VALS.charAt(e)]=e)}}};class xt extends Error{constructor(){super(...arguments),this.name="DecodeBase64StringError"}}const Ht=function(e){const t=Ze(e);return Qe.encodeByteArray(t,!0)},et=function(e){return Ht(e).replace(/\./g,"")},Vt=function(e){try{return Qe.decodeString(e,!0)}catch(t){console.error("base64Decode failed: ",t)}return null};/**
 * @license
 * Copyright 2022 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function qt(){if(typeof self<"u")return self;if(typeof window<"u")return window;if(typeof global<"u")return global;throw new Error("Unable to locate global object.")}/**
 * @license
 * Copyright 2022 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Ut=()=>qt().__FIREBASE_DEFAULTS__,Kt=()=>{if(typeof process>"u"||typeof process.env>"u")return;const e={}.__FIREBASE_DEFAULTS__;if(e)return JSON.parse(e)},Wt=()=>{if(typeof document>"u")return;let e;try{e=document.cookie.match(/__FIREBASE_DEFAULTS__=([^;]+)/)}catch{return}const t=e&&Vt(e[1]);return t&&JSON.parse(t)},zt=()=>{try{return jt()||Ut()||Kt()||Wt()}catch(e){console.info(`Unable to get __FIREBASE_DEFAULTS__ due to: ${e}`);return}},tt=()=>{var e;return(e=zt())===null||e===void 0?void 0:e.config};/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class Gt{constructor(){this.reject=()=>{},this.resolve=()=>{},this.promise=new Promise((t,n)=>{this.resolve=t,this.reject=n})}wrapCallback(t){return(n,r)=>{n?this.reject(n):this.resolve(r),typeof t=="function"&&(this.promise.catch(()=>{}),t.length===1?t(n):t(n,r))}}}function nt(){try{return typeof indexedDB=="object"}catch{return!1}}function rt(){return new Promise((e,t)=>{try{let n=!0;const r="validate-browser-context-for-indexeddb-analytics-module",s=self.indexedDB.open(r);s.onsuccess=()=>{s.result.close(),n||self.indexedDB.deleteDatabase(r),e(!0)},s.onupgradeneeded=()=>{n=!1},s.onerror=()=>{var i;t(((i=s.error)===null||i===void 0?void 0:i.message)||"")}}catch(n){t(n)}})}function Jt(){return!(typeof navigator>"u"||!navigator.cookieEnabled)}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Xt="FirebaseError";class j extends Error{constructor(t,n,r){super(n),this.code=t,this.customData=r,this.name=Xt,Object.setPrototypeOf(this,j.prototype),Error.captureStackTrace&&Error.captureStackTrace(this,Y.prototype.create)}}class Y{constructor(t,n,r){this.service=t,this.serviceName=n,this.errors=r}create(t,...n){const r=n[0]||{},s=`${this.service}/${t}`,i=this.errors[t],o=i?Yt(i,r):"Error",l=`${this.serviceName}: ${o} (${s}).`;return new j(s,l,r)}}function Yt(e,t){return e.replace(Zt,(n,r)=>{const s=t[r];return s!=null?String(s):`<${r}?>`})}const Zt=/\{\$([^}]+)}/g;function pe(e,t){if(e===t)return!0;const n=Object.keys(e),r=Object.keys(t);for(const s of n){if(!r.includes(s))return!1;const i=e[s],o=t[s];if(Be(i)&&Be(o)){if(!pe(i,o))return!1}else if(i!==o)return!1}for(const s of r)if(!n.includes(s))return!1;return!0}function Be(e){return e!==null&&typeof e=="object"}/**
 * @license
 * Copyright 2021 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function st(e){return e&&e._delegate?e._delegate:e}class D{constructor(t,n,r){this.name=t,this.instanceFactory=n,this.type=r,this.multipleInstances=!1,this.serviceProps={},this.instantiationMode="LAZY",this.onInstanceCreated=null}setInstantiationMode(t){return this.instantiationMode=t,this}setMultipleInstances(t){return this.multipleInstances=t,this}setServiceProps(t){return this.serviceProps=t,this}setInstanceCreatedCallback(t){return this.onInstanceCreated=t,this}}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const k="[DEFAULT]";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class Qt{constructor(t,n){this.name=t,this.container=n,this.component=null,this.instances=new Map,this.instancesDeferred=new Map,this.instancesOptions=new Map,this.onInitCallbacks=new Map}get(t){const n=this.normalizeInstanceIdentifier(t);if(!this.instancesDeferred.has(n)){const r=new Gt;if(this.instancesDeferred.set(n,r),this.isInitialized(n)||this.shouldAutoInitialize())try{const s=this.getOrInitializeService({instanceIdentifier:n});s&&r.resolve(s)}catch{}}return this.instancesDeferred.get(n).promise}getImmediate(t){var n;const r=this.normalizeInstanceIdentifier(t==null?void 0:t.identifier),s=(n=t==null?void 0:t.optional)!==null&&n!==void 0?n:!1;if(this.isInitialized(r)||this.shouldAutoInitialize())try{return this.getOrInitializeService({instanceIdentifier:r})}catch(i){if(s)return null;throw i}else{if(s)return null;throw Error(`Service ${this.name} is not available`)}}getComponent(){return this.component}setComponent(t){if(t.name!==this.name)throw Error(`Mismatching Component ${t.name} for Provider ${this.name}.`);if(this.component)throw Error(`Component for ${this.name} has already been provided`);if(this.component=t,!!this.shouldAutoInitialize()){if(tn(t))try{this.getOrInitializeService({instanceIdentifier:k})}catch{}for(const[n,r]of this.instancesDeferred.entries()){const s=this.normalizeInstanceIdentifier(n);try{const i=this.getOrInitializeService({instanceIdentifier:s});r.resolve(i)}catch{}}}}clearInstance(t=k){this.instancesDeferred.delete(t),this.instancesOptions.delete(t),this.instances.delete(t)}async delete(){const t=Array.from(this.instances.values());await Promise.all([...t.filter(n=>"INTERNAL"in n).map(n=>n.INTERNAL.delete()),...t.filter(n=>"_delete"in n).map(n=>n._delete())])}isComponentSet(){return this.component!=null}isInitialized(t=k){return this.instances.has(t)}getOptions(t=k){return this.instancesOptions.get(t)||{}}initialize(t={}){const{options:n={}}=t,r=this.normalizeInstanceIdentifier(t.instanceIdentifier);if(this.isInitialized(r))throw Error(`${this.name}(${r}) has already been initialized`);if(!this.isComponentSet())throw Error(`Component ${this.name} has not been registered yet`);const s=this.getOrInitializeService({instanceIdentifier:r,options:n});for(const[i,o]of this.instancesDeferred.entries()){const l=this.normalizeInstanceIdentifier(i);r===l&&o.resolve(s)}return s}onInit(t,n){var r;const s=this.normalizeInstanceIdentifier(n),i=(r=this.onInitCallbacks.get(s))!==null&&r!==void 0?r:new Set;i.add(t),this.onInitCallbacks.set(s,i);const o=this.instances.get(s);return o&&t(o,s),()=>{i.delete(t)}}invokeOnInitCallbacks(t,n){const r=this.onInitCallbacks.get(n);if(r)for(const s of r)try{s(t,n)}catch{}}getOrInitializeService({instanceIdentifier:t,options:n={}}){let r=this.instances.get(t);if(!r&&this.component&&(r=this.component.instanceFactory(this.container,{instanceIdentifier:en(t),options:n}),this.instances.set(t,r),this.instancesOptions.set(t,n),this.invokeOnInitCallbacks(r,t),this.component.onInstanceCreated))try{this.component.onInstanceCreated(this.container,t,r)}catch{}return r||null}normalizeInstanceIdentifier(t=k){return this.component?this.component.multipleInstances?t:k:t}shouldAutoInitialize(){return!!this.component&&this.component.instantiationMode!=="EXPLICIT"}}function en(e){return e===k?void 0:e}function tn(e){return e.instantiationMode==="EAGER"}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class nn{constructor(t){this.name=t,this.providers=new Map}addComponent(t){const n=this.getProvider(t.name);if(n.isComponentSet())throw new Error(`Component ${t.name} has already been registered with ${this.name}`);n.setComponent(t)}addOrOverwriteComponent(t){this.getProvider(t.name).isComponentSet()&&this.providers.delete(t.name),this.addComponent(t)}getProvider(t){if(this.providers.has(t))return this.providers.get(t);const n=new Qt(t,this);return this.providers.set(t,n),n}getProviders(){return Array.from(this.providers.values())}}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */var b;(function(e){e[e.DEBUG=0]="DEBUG",e[e.VERBOSE=1]="VERBOSE",e[e.INFO=2]="INFO",e[e.WARN=3]="WARN",e[e.ERROR=4]="ERROR",e[e.SILENT=5]="SILENT"})(b||(b={}));const rn={debug:b.DEBUG,verbose:b.VERBOSE,info:b.INFO,warn:b.WARN,error:b.ERROR,silent:b.SILENT},sn=b.INFO,on={[b.DEBUG]:"log",[b.VERBOSE]:"log",[b.INFO]:"info",[b.WARN]:"warn",[b.ERROR]:"error"},an=(e,t,...n)=>{if(t<e.logLevel)return;const r=new Date().toISOString(),s=on[t];if(s)console[s](`[${r}]  ${e.name}:`,...n);else throw new Error(`Attempted to log a message with an invalid logType (value: ${t})`)};class cn{constructor(t){this.name=t,this._logLevel=sn,this._logHandler=an,this._userLogHandler=null}get logLevel(){return this._logLevel}set logLevel(t){if(!(t in b))throw new TypeError(`Invalid value "${t}" assigned to \`logLevel\``);this._logLevel=t}setLogLevel(t){this._logLevel=typeof t=="string"?rn[t]:t}get logHandler(){return this._logHandler}set logHandler(t){if(typeof t!="function")throw new TypeError("Value assigned to `logHandler` must be a function");this._logHandler=t}get userLogHandler(){return this._userLogHandler}set userLogHandler(t){this._userLogHandler=t}debug(...t){this._userLogHandler&&this._userLogHandler(this,b.DEBUG,...t),this._logHandler(this,b.DEBUG,...t)}log(...t){this._userLogHandler&&this._userLogHandler(this,b.VERBOSE,...t),this._logHandler(this,b.VERBOSE,...t)}info(...t){this._userLogHandler&&this._userLogHandler(this,b.INFO,...t),this._logHandler(this,b.INFO,...t)}warn(...t){this._userLogHandler&&this._userLogHandler(this,b.WARN,...t),this._logHandler(this,b.WARN,...t)}error(...t){this._userLogHandler&&this._userLogHandler(this,b.ERROR,...t),this._logHandler(this,b.ERROR,...t)}}const dn=(e,t)=>t.some(n=>e instanceof n);let Re,Le;function ln(){return Re||(Re=[IDBDatabase,IDBObjectStore,IDBIndex,IDBCursor,IDBTransaction])}function un(){return Le||(Le=[IDBCursor.prototype.advance,IDBCursor.prototype.continue,IDBCursor.prototype.continuePrimaryKey])}const it=new WeakMap,ge=new WeakMap,ot=new WeakMap,se=new WeakMap,Ie=new WeakMap;function fn(e){const t=new Promise((n,r)=>{const s=()=>{e.removeEventListener("success",i),e.removeEventListener("error",o)},i=()=>{n(S(e.result)),s()},o=()=>{r(e.error),s()};e.addEventListener("success",i),e.addEventListener("error",o)});return t.then(n=>{n instanceof IDBCursor&&it.set(n,e)}).catch(()=>{}),Ie.set(t,e),t}function hn(e){if(ge.has(e))return;const t=new Promise((n,r)=>{const s=()=>{e.removeEventListener("complete",i),e.removeEventListener("error",o),e.removeEventListener("abort",o)},i=()=>{n(),s()},o=()=>{r(e.error||new DOMException("AbortError","AbortError")),s()};e.addEventListener("complete",i),e.addEventListener("error",o),e.addEventListener("abort",o)});ge.set(e,t)}let me={get(e,t,n){if(e instanceof IDBTransaction){if(t==="done")return ge.get(e);if(t==="objectStoreNames")return e.objectStoreNames||ot.get(e);if(t==="store")return n.objectStoreNames[1]?void 0:n.objectStore(n.objectStoreNames[0])}return S(e[t])},set(e,t,n){return e[t]=n,!0},has(e,t){return e instanceof IDBTransaction&&(t==="done"||t==="store")?!0:t in e}};function pn(e){me=e(me)}function gn(e){return e===IDBDatabase.prototype.transaction&&!("objectStoreNames"in IDBTransaction.prototype)?function(t,...n){const r=e.call(ie(this),t,...n);return ot.set(r,t.sort?t.sort():[t]),S(r)}:un().includes(e)?function(...t){return e.apply(ie(this),t),S(it.get(this))}:function(...t){return S(e.apply(ie(this),t))}}function mn(e){return typeof e=="function"?gn(e):(e instanceof IDBTransaction&&hn(e),dn(e,ln())?new Proxy(e,me):e)}function S(e){if(e instanceof IDBRequest)return fn(e);if(se.has(e))return se.get(e);const t=mn(e);return t!==e&&(se.set(e,t),Ie.set(t,e)),t}const ie=e=>Ie.get(e);function Z(e,t,{blocked:n,upgrade:r,blocking:s,terminated:i}={}){const o=indexedDB.open(e,t),l=S(o);return r&&o.addEventListener("upgradeneeded",f=>{r(S(o.result),f.oldVersion,f.newVersion,S(o.transaction),f)}),n&&o.addEventListener("blocked",f=>n(f.oldVersion,f.newVersion,f)),l.then(f=>{i&&f.addEventListener("close",()=>i()),s&&f.addEventListener("versionchange",p=>s(p.oldVersion,p.newVersion,p))}).catch(()=>{}),l}function oe(e,{blocked:t}={}){const n=indexedDB.deleteDatabase(e);return t&&n.addEventListener("blocked",r=>t(r.oldVersion,r)),S(n).then(()=>{})}const bn=["get","getKey","getAll","getAllKeys","count"],yn=["put","add","delete","clear"],ae=new Map;function Pe(e,t){if(!(e instanceof IDBDatabase&&!(t in e)&&typeof t=="string"))return;if(ae.get(t))return ae.get(t);const n=t.replace(/FromIndex$/,""),r=t!==n,s=yn.includes(n);if(!(n in(r?IDBIndex:IDBObjectStore).prototype)||!(s||bn.includes(n)))return;const i=async function(o,...l){const f=this.transaction(o,s?"readwrite":"readonly");let p=f.store;return r&&(p=p.index(l.shift())),(await Promise.all([p[n](...l),s&&f.done]))[0]};return ae.set(t,i),i}pn(e=>({...e,get:(t,n,r)=>Pe(t,n)||e.get(t,n,r),has:(t,n)=>!!Pe(t,n)||e.has(t,n)}));/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class wn{constructor(t){this.container=t}getPlatformInfoString(){return this.container.getProviders().map(n=>{if(En(n)){const r=n.getImmediate();return`${r.library}/${r.version}`}else return null}).filter(n=>n).join(" ")}}function En(e){const t=e.getComponent();return(t==null?void 0:t.type)==="VERSION"}const be="@firebase/app",je="0.11.2";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const _=new cn("@firebase/app"),In="@firebase/app-compat",vn="@firebase/analytics-compat",Sn="@firebase/analytics",_n="@firebase/app-check-compat",Tn="@firebase/app-check",An="@firebase/auth",Cn="@firebase/auth-compat",Dn="@firebase/database",kn="@firebase/data-connect",On="@firebase/database-compat",Mn="@firebase/functions",$n="@firebase/functions-compat",Nn="@firebase/installations",Bn="@firebase/installations-compat",Rn="@firebase/messaging",Ln="@firebase/messaging-compat",Pn="@firebase/performance",jn="@firebase/performance-compat",Fn="@firebase/remote-config",xn="@firebase/remote-config-compat",Hn="@firebase/storage",Vn="@firebase/storage-compat",qn="@firebase/firestore",Un="@firebase/vertexai",Kn="@firebase/firestore-compat",Wn="firebase";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const ye="[DEFAULT]",zn={[be]:"fire-core",[In]:"fire-core-compat",[Sn]:"fire-analytics",[vn]:"fire-analytics-compat",[Tn]:"fire-app-check",[_n]:"fire-app-check-compat",[An]:"fire-auth",[Cn]:"fire-auth-compat",[Dn]:"fire-rtdb",[kn]:"fire-data-connect",[On]:"fire-rtdb-compat",[Mn]:"fire-fn",[$n]:"fire-fn-compat",[Nn]:"fire-iid",[Bn]:"fire-iid-compat",[Rn]:"fire-fcm",[Ln]:"fire-fcm-compat",[Pn]:"fire-perf",[jn]:"fire-perf-compat",[Fn]:"fire-rc",[xn]:"fire-rc-compat",[Hn]:"fire-gcs",[Vn]:"fire-gcs-compat",[qn]:"fire-fst",[Kn]:"fire-fst-compat",[Un]:"fire-vertex","fire-js":"fire-js",[Wn]:"fire-js-all"};/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const J=new Map,Gn=new Map,we=new Map;function Fe(e,t){try{e.container.addComponent(t)}catch(n){_.debug(`Component ${t.name} failed to register with FirebaseApp ${e.name}`,n)}}function M(e){const t=e.name;if(we.has(t))return _.debug(`There were multiple attempts to register component ${t}.`),!1;we.set(t,e);for(const n of J.values())Fe(n,e);for(const n of Gn.values())Fe(n,e);return!0}function ve(e,t){const n=e.container.getProvider("heartbeat").getImmediate({optional:!0});return n&&n.triggerHeartbeat(),e.container.getProvider(t)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Jn={"no-app":"No Firebase App '{$appName}' has been created - call initializeApp() first","bad-app-name":"Illegal App name: '{$appName}'","duplicate-app":"Firebase App named '{$appName}' already exists with different options or config","app-deleted":"Firebase App named '{$appName}' already deleted","server-app-deleted":"Firebase Server App has been deleted","no-options":"Need to provide options, when not being deployed to hosting via source.","invalid-app-argument":"firebase.{$appName}() takes either no argument or a Firebase App instance.","invalid-log-argument":"First argument to `onLog` must be null or a function.","idb-open":"Error thrown when opening IndexedDB. Original error: {$originalErrorMessage}.","idb-get":"Error thrown when reading from IndexedDB. Original error: {$originalErrorMessage}.","idb-set":"Error thrown when writing to IndexedDB. Original error: {$originalErrorMessage}.","idb-delete":"Error thrown when deleting from IndexedDB. Original error: {$originalErrorMessage}.","finalization-registry-not-supported":"FirebaseServerApp deleteOnDeref field defined but the JS runtime does not support FinalizationRegistry.","invalid-server-app-environment":"FirebaseServerApp is not for use in browser environments."},A=new Y("app","Firebase",Jn);/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class Xn{constructor(t,n,r){this._isDeleted=!1,this._options=Object.assign({},t),this._config=Object.assign({},n),this._name=n.name,this._automaticDataCollectionEnabled=n.automaticDataCollectionEnabled,this._container=r,this.container.addComponent(new D("app",()=>this,"PUBLIC"))}get automaticDataCollectionEnabled(){return this.checkDestroyed(),this._automaticDataCollectionEnabled}set automaticDataCollectionEnabled(t){this.checkDestroyed(),this._automaticDataCollectionEnabled=t}get name(){return this.checkDestroyed(),this._name}get options(){return this.checkDestroyed(),this._options}get config(){return this.checkDestroyed(),this._config}get container(){return this._container}get isDeleted(){return this._isDeleted}set isDeleted(t){this._isDeleted=t}checkDestroyed(){if(this.isDeleted)throw A.create("app-deleted",{appName:this._name})}}function at(e,t={}){let n=e;typeof t!="object"&&(t={name:t});const r=Object.assign({name:ye,automaticDataCollectionEnabled:!1},t),s=r.name;if(typeof s!="string"||!s)throw A.create("bad-app-name",{appName:String(s)});if(n||(n=tt()),!n)throw A.create("no-options");const i=J.get(s);if(i){if(pe(n,i.options)&&pe(r,i.config))return i;throw A.create("duplicate-app",{appName:s})}const o=new nn(s);for(const f of we.values())o.addComponent(f);const l=new Xn(n,r,o);return J.set(s,l),l}function Yn(e=ye){const t=J.get(e);if(!t&&e===ye&&tt())return at();if(!t)throw A.create("no-app",{appName:e});return t}function C(e,t,n){var r;let s=(r=zn[e])!==null&&r!==void 0?r:e;n&&(s+=`-${n}`);const i=s.match(/\s|\//),o=t.match(/\s|\//);if(i||o){const l=[`Unable to register library "${s}" with version "${t}":`];i&&l.push(`library name "${s}" contains illegal characters (whitespace or "/")`),i&&o&&l.push("and"),o&&l.push(`version name "${t}" contains illegal characters (whitespace or "/")`),_.warn(l.join(" "));return}M(new D(`${s}-version`,()=>({library:s,version:t}),"VERSION"))}/**
 * @license
 * Copyright 2021 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Zn="firebase-heartbeat-database",Qn=1,q="firebase-heartbeat-store";let ce=null;function ct(){return ce||(ce=Z(Zn,Qn,{upgrade:(e,t)=>{switch(t){case 0:try{e.createObjectStore(q)}catch(n){console.warn(n)}}}}).catch(e=>{throw A.create("idb-open",{originalErrorMessage:e.message})})),ce}async function er(e){try{const n=(await ct()).transaction(q),r=await n.objectStore(q).get(dt(e));return await n.done,r}catch(t){if(t instanceof j)_.warn(t.message);else{const n=A.create("idb-get",{originalErrorMessage:t==null?void 0:t.message});_.warn(n.message)}}}async function xe(e,t){try{const r=(await ct()).transaction(q,"readwrite");await r.objectStore(q).put(t,dt(e)),await r.done}catch(n){if(n instanceof j)_.warn(n.message);else{const r=A.create("idb-set",{originalErrorMessage:n==null?void 0:n.message});_.warn(r.message)}}}function dt(e){return`${e.name}!${e.options.appId}`}/**
 * @license
 * Copyright 2021 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const tr=1024,nr=30;class rr{constructor(t){this.container=t,this._heartbeatsCache=null;const n=this.container.getProvider("app").getImmediate();this._storage=new ir(n),this._heartbeatsCachePromise=this._storage.read().then(r=>(this._heartbeatsCache=r,r))}async triggerHeartbeat(){var t,n;try{const s=this.container.getProvider("platform-logger").getImmediate().getPlatformInfoString(),i=He();if(((t=this._heartbeatsCache)===null||t===void 0?void 0:t.heartbeats)==null&&(this._heartbeatsCache=await this._heartbeatsCachePromise,((n=this._heartbeatsCache)===null||n===void 0?void 0:n.heartbeats)==null)||this._heartbeatsCache.lastSentHeartbeatDate===i||this._heartbeatsCache.heartbeats.some(o=>o.date===i))return;if(this._heartbeatsCache.heartbeats.push({date:i,agent:s}),this._heartbeatsCache.heartbeats.length>nr){const o=or(this._heartbeatsCache.heartbeats);this._heartbeatsCache.heartbeats.splice(o,1)}return this._storage.overwrite(this._heartbeatsCache)}catch(r){_.warn(r)}}async getHeartbeatsHeader(){var t;try{if(this._heartbeatsCache===null&&await this._heartbeatsCachePromise,((t=this._heartbeatsCache)===null||t===void 0?void 0:t.heartbeats)==null||this._heartbeatsCache.heartbeats.length===0)return"";const n=He(),{heartbeatsToSend:r,unsentEntries:s}=sr(this._heartbeatsCache.heartbeats),i=et(JSON.stringify({version:2,heartbeats:r}));return this._heartbeatsCache.lastSentHeartbeatDate=n,s.length>0?(this._heartbeatsCache.heartbeats=s,await this._storage.overwrite(this._heartbeatsCache)):(this._heartbeatsCache.heartbeats=[],this._storage.overwrite(this._heartbeatsCache)),i}catch(n){return _.warn(n),""}}}function He(){return new Date().toISOString().substring(0,10)}function sr(e,t=tr){const n=[];let r=e.slice();for(const s of e){const i=n.find(o=>o.agent===s.agent);if(i){if(i.dates.push(s.date),Ve(n)>t){i.dates.pop();break}}else if(n.push({agent:s.agent,dates:[s.date]}),Ve(n)>t){n.pop();break}r=r.slice(1)}return{heartbeatsToSend:n,unsentEntries:r}}class ir{constructor(t){this.app=t,this._canUseIndexedDBPromise=this.runIndexedDBEnvironmentCheck()}async runIndexedDBEnvironmentCheck(){return nt()?rt().then(()=>!0).catch(()=>!1):!1}async read(){if(await this._canUseIndexedDBPromise){const n=await er(this.app);return n!=null&&n.heartbeats?n:{heartbeats:[]}}else return{heartbeats:[]}}async overwrite(t){var n;if(await this._canUseIndexedDBPromise){const s=await this.read();return xe(this.app,{lastSentHeartbeatDate:(n=t.lastSentHeartbeatDate)!==null&&n!==void 0?n:s.lastSentHeartbeatDate,heartbeats:t.heartbeats})}else return}async add(t){var n;if(await this._canUseIndexedDBPromise){const s=await this.read();return xe(this.app,{lastSentHeartbeatDate:(n=t.lastSentHeartbeatDate)!==null&&n!==void 0?n:s.lastSentHeartbeatDate,heartbeats:[...s.heartbeats,...t.heartbeats]})}else return}}function Ve(e){return et(JSON.stringify({version:2,heartbeats:e})).length}function or(e){if(e.length===0)return-1;let t=0,n=e[0].date;for(let r=1;r<e.length;r++)e[r].date<n&&(n=e[r].date,t=r);return t}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function ar(e){M(new D("platform-logger",t=>new wn(t),"PRIVATE")),M(new D("heartbeat",t=>new rr(t),"PRIVATE")),C(be,je,e),C(be,je,"esm2017"),C("fire-js","")}ar("");var cr="firebase",dr="11.4.0";/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */C(cr,dr,"app");const lt="@firebase/installations",Se="0.6.13";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const ut=1e4,ft=`w:${Se}`,ht="FIS_v2",lr="https://firebaseinstallations.googleapis.com/v1",ur=60*60*1e3,fr="installations",hr="Installations";/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const pr={"missing-app-config-values":'Missing App configuration value: "{$valueName}"',"not-registered":"Firebase Installation is not registered.","installation-not-found":"Firebase Installation not found.","request-failed":'{$requestName} request failed with error "{$serverCode} {$serverStatus}: {$serverMessage}"',"app-offline":"Could not process request. Application offline.","delete-pending-registration":"Can't delete installation while there is a pending registration request."},$=new Y(fr,hr,pr);function pt(e){return e instanceof j&&e.code.includes("request-failed")}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function gt({projectId:e}){return`${lr}/projects/${e}/installations`}function mt(e){return{token:e.token,requestStatus:2,expiresIn:mr(e.expiresIn),creationTime:Date.now()}}async function bt(e,t){const r=(await t.json()).error;return $.create("request-failed",{requestName:e,serverCode:r.code,serverMessage:r.message,serverStatus:r.status})}function yt({apiKey:e}){return new Headers({"Content-Type":"application/json",Accept:"application/json","x-goog-api-key":e})}function gr(e,{refreshToken:t}){const n=yt(e);return n.append("Authorization",br(t)),n}async function wt(e){const t=await e();return t.status>=500&&t.status<600?e():t}function mr(e){return Number(e.replace("s","000"))}function br(e){return`${ht} ${e}`}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function yr({appConfig:e,heartbeatServiceProvider:t},{fid:n}){const r=gt(e),s=yt(e),i=t.getImmediate({optional:!0});if(i){const p=await i.getHeartbeatsHeader();p&&s.append("x-firebase-client",p)}const o={fid:n,authVersion:ht,appId:e.appId,sdkVersion:ft},l={method:"POST",headers:s,body:JSON.stringify(o)},f=await wt(()=>fetch(r,l));if(f.ok){const p=await f.json();return{fid:p.fid||n,registrationStatus:2,refreshToken:p.refreshToken,authToken:mt(p.authToken)}}else throw await bt("Create Installation",f)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Et(e){return new Promise(t=>{setTimeout(t,e)})}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function wr(e){return btoa(String.fromCharCode(...e)).replace(/\+/g,"-").replace(/\//g,"_")}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Er=/^[cdef][\w-]{21}$/,Ee="";function Ir(){try{const e=new Uint8Array(17);(self.crypto||self.msCrypto).getRandomValues(e),e[0]=112+e[0]%16;const n=vr(e);return Er.test(n)?n:Ee}catch{return Ee}}function vr(e){return wr(e).substr(0,22)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Q(e){return`${e.appName}!${e.appId}`}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const It=new Map;function vt(e,t){const n=Q(e);St(n,t),Sr(n,t)}function St(e,t){const n=It.get(e);if(n)for(const r of n)r(t)}function Sr(e,t){const n=_r();n&&n.postMessage({key:e,fid:t}),Tr()}let O=null;function _r(){return!O&&"BroadcastChannel"in self&&(O=new BroadcastChannel("[Firebase] FID Change"),O.onmessage=e=>{St(e.data.key,e.data.fid)}),O}function Tr(){It.size===0&&O&&(O.close(),O=null)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Ar="firebase-installations-database",Cr=1,N="firebase-installations-store";let de=null;function _e(){return de||(de=Z(Ar,Cr,{upgrade:(e,t)=>{switch(t){case 0:e.createObjectStore(N)}}})),de}async function X(e,t){const n=Q(e),s=(await _e()).transaction(N,"readwrite"),i=s.objectStore(N),o=await i.get(n);return await i.put(t,n),await s.done,(!o||o.fid!==t.fid)&&vt(e,t.fid),t}async function _t(e){const t=Q(e),r=(await _e()).transaction(N,"readwrite");await r.objectStore(N).delete(t),await r.done}async function ee(e,t){const n=Q(e),s=(await _e()).transaction(N,"readwrite"),i=s.objectStore(N),o=await i.get(n),l=t(o);return l===void 0?await i.delete(n):await i.put(l,n),await s.done,l&&(!o||o.fid!==l.fid)&&vt(e,l.fid),l}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Te(e){let t;const n=await ee(e.appConfig,r=>{const s=Dr(r),i=kr(e,s);return t=i.registrationPromise,i.installationEntry});return n.fid===Ee?{installationEntry:await t}:{installationEntry:n,registrationPromise:t}}function Dr(e){const t=e||{fid:Ir(),registrationStatus:0};return Tt(t)}function kr(e,t){if(t.registrationStatus===0){if(!navigator.onLine){const s=Promise.reject($.create("app-offline"));return{installationEntry:t,registrationPromise:s}}const n={fid:t.fid,registrationStatus:1,registrationTime:Date.now()},r=Or(e,n);return{installationEntry:n,registrationPromise:r}}else return t.registrationStatus===1?{installationEntry:t,registrationPromise:Mr(e)}:{installationEntry:t}}async function Or(e,t){try{const n=await yr(e,t);return X(e.appConfig,n)}catch(n){throw pt(n)&&n.customData.serverCode===409?await _t(e.appConfig):await X(e.appConfig,{fid:t.fid,registrationStatus:0}),n}}async function Mr(e){let t=await qe(e.appConfig);for(;t.registrationStatus===1;)await Et(100),t=await qe(e.appConfig);if(t.registrationStatus===0){const{installationEntry:n,registrationPromise:r}=await Te(e);return r||n}return t}function qe(e){return ee(e,t=>{if(!t)throw $.create("installation-not-found");return Tt(t)})}function Tt(e){return $r(e)?{fid:e.fid,registrationStatus:0}:e}function $r(e){return e.registrationStatus===1&&e.registrationTime+ut<Date.now()}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Nr({appConfig:e,heartbeatServiceProvider:t},n){const r=Br(e,n),s=gr(e,n),i=t.getImmediate({optional:!0});if(i){const p=await i.getHeartbeatsHeader();p&&s.append("x-firebase-client",p)}const o={installation:{sdkVersion:ft,appId:e.appId}},l={method:"POST",headers:s,body:JSON.stringify(o)},f=await wt(()=>fetch(r,l));if(f.ok){const p=await f.json();return mt(p)}else throw await bt("Generate Auth Token",f)}function Br(e,{fid:t}){return`${gt(e)}/${t}/authTokens:generate`}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Ae(e,t=!1){let n;const r=await ee(e.appConfig,i=>{if(!At(i))throw $.create("not-registered");const o=i.authToken;if(!t&&Pr(o))return i;if(o.requestStatus===1)return n=Rr(e,t),i;{if(!navigator.onLine)throw $.create("app-offline");const l=Fr(i);return n=Lr(e,l),l}});return n?await n:r.authToken}async function Rr(e,t){let n=await Ue(e.appConfig);for(;n.authToken.requestStatus===1;)await Et(100),n=await Ue(e.appConfig);const r=n.authToken;return r.requestStatus===0?Ae(e,t):r}function Ue(e){return ee(e,t=>{if(!At(t))throw $.create("not-registered");const n=t.authToken;return xr(n)?Object.assign(Object.assign({},t),{authToken:{requestStatus:0}}):t})}async function Lr(e,t){try{const n=await Nr(e,t),r=Object.assign(Object.assign({},t),{authToken:n});return await X(e.appConfig,r),n}catch(n){if(pt(n)&&(n.customData.serverCode===401||n.customData.serverCode===404))await _t(e.appConfig);else{const r=Object.assign(Object.assign({},t),{authToken:{requestStatus:0}});await X(e.appConfig,r)}throw n}}function At(e){return e!==void 0&&e.registrationStatus===2}function Pr(e){return e.requestStatus===2&&!jr(e)}function jr(e){const t=Date.now();return t<e.creationTime||e.creationTime+e.expiresIn<t+ur}function Fr(e){const t={requestStatus:1,requestTime:Date.now()};return Object.assign(Object.assign({},e),{authToken:t})}function xr(e){return e.requestStatus===1&&e.requestTime+ut<Date.now()}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Hr(e){const t=e,{installationEntry:n,registrationPromise:r}=await Te(t);return r?r.catch(console.error):Ae(t).catch(console.error),n.fid}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Vr(e,t=!1){const n=e;return await qr(n),(await Ae(n,t)).token}async function qr(e){const{registrationPromise:t}=await Te(e);t&&await t}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Ur(e){if(!e||!e.options)throw le("App Configuration");if(!e.name)throw le("App Name");const t=["projectId","apiKey","appId"];for(const n of t)if(!e.options[n])throw le(n);return{appName:e.name,projectId:e.options.projectId,apiKey:e.options.apiKey,appId:e.options.appId}}function le(e){return $.create("missing-app-config-values",{valueName:e})}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Ct="installations",Kr="installations-internal",Wr=e=>{const t=e.getProvider("app").getImmediate(),n=Ur(t),r=ve(t,"heartbeat");return{app:t,appConfig:n,heartbeatServiceProvider:r,_delete:()=>Promise.resolve()}},zr=e=>{const t=e.getProvider("app").getImmediate(),n=ve(t,Ct).getImmediate();return{getId:()=>Hr(n),getToken:s=>Vr(n,s)}};function Gr(){M(new D(Ct,Wr,"PUBLIC")),M(new D(Kr,zr,"PRIVATE"))}Gr();C(lt,Se);C(lt,Se,"esm2017");/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const Jr="/firebase-messaging-sw.js",Xr="/firebase-cloud-messaging-push-scope",Dt="BDOU99-h67HcA6JeFXHbSNMu7e2yNNu3RzoMj8TM4W88jITfq7ZmPvIM1Iv-4_l2LxQcYwhqby2xGpWwzjfAnG4",Yr="https://fcmregistrations.googleapis.com/v1",kt="google.c.a.c_id",Zr="google.c.a.c_l",Qr="google.c.a.ts",es="google.c.a.e",Ke=1e4;var We;(function(e){e[e.DATA_MESSAGE=1]="DATA_MESSAGE",e[e.DISPLAY_NOTIFICATION=3]="DISPLAY_NOTIFICATION"})(We||(We={}));/**
 * @license
 * Copyright 2018 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except
 * in compliance with the License. You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under the License
 * is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 * or implied. See the License for the specific language governing permissions and limitations under
 * the License.
 */var U;(function(e){e.PUSH_RECEIVED="push-received",e.NOTIFICATION_CLICKED="notification-clicked"})(U||(U={}));/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function v(e){const t=new Uint8Array(e);return btoa(String.fromCharCode(...t)).replace(/=/g,"").replace(/\+/g,"-").replace(/\//g,"_")}function ts(e){const t="=".repeat((4-e.length%4)%4),n=(e+t).replace(/\-/g,"+").replace(/_/g,"/"),r=atob(n),s=new Uint8Array(r.length);for(let i=0;i<r.length;++i)s[i]=r.charCodeAt(i);return s}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const ue="fcm_token_details_db",ns=5,ze="fcm_token_object_Store";async function rs(e){if("databases"in indexedDB&&!(await indexedDB.databases()).map(i=>i.name).includes(ue))return null;let t=null;return(await Z(ue,ns,{upgrade:async(r,s,i,o)=>{var l;if(s<2||!r.objectStoreNames.contains(ze))return;const f=o.objectStore(ze),p=await f.index("fcmSenderId").get(e);if(await f.clear(),!!p){if(s===2){const m=p;if(!m.auth||!m.p256dh||!m.endpoint)return;t={token:m.fcmToken,createTime:(l=m.createTime)!==null&&l!==void 0?l:Date.now(),subscriptionOptions:{auth:m.auth,p256dh:m.p256dh,endpoint:m.endpoint,swScope:m.swScope,vapidKey:typeof m.vapidKey=="string"?m.vapidKey:v(m.vapidKey)}}}else if(s===3){const m=p;t={token:m.fcmToken,createTime:m.createTime,subscriptionOptions:{auth:v(m.auth),p256dh:v(m.p256dh),endpoint:m.endpoint,swScope:m.swScope,vapidKey:v(m.vapidKey)}}}else if(s===4){const m=p;t={token:m.fcmToken,createTime:m.createTime,subscriptionOptions:{auth:v(m.auth),p256dh:v(m.p256dh),endpoint:m.endpoint,swScope:m.swScope,vapidKey:v(m.vapidKey)}}}}}})).close(),await oe(ue),await oe("fcm_vapid_details_db"),await oe("undefined"),ss(t)?t:null}function ss(e){if(!e||!e.subscriptionOptions)return!1;const{subscriptionOptions:t}=e;return typeof e.createTime=="number"&&e.createTime>0&&typeof e.token=="string"&&e.token.length>0&&typeof t.auth=="string"&&t.auth.length>0&&typeof t.p256dh=="string"&&t.p256dh.length>0&&typeof t.endpoint=="string"&&t.endpoint.length>0&&typeof t.swScope=="string"&&t.swScope.length>0&&typeof t.vapidKey=="string"&&t.vapidKey.length>0}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const is="firebase-messaging-database",os=1,K="firebase-messaging-store";let fe=null;function Ot(){return fe||(fe=Z(is,os,{upgrade:(e,t)=>{switch(t){case 0:e.createObjectStore(K)}}})),fe}async function as(e){const t=Mt(e),r=await(await Ot()).transaction(K).objectStore(K).get(t);if(r)return r;{const s=await rs(e.appConfig.senderId);if(s)return await Ce(e,s),s}}async function Ce(e,t){const n=Mt(e),s=(await Ot()).transaction(K,"readwrite");return await s.objectStore(K).put(t,n),await s.done,t}function Mt({appConfig:e}){return e.appId}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const cs={"missing-app-config-values":'Missing App configuration value: "{$valueName}"',"only-available-in-window":"This method is available in a Window context.","only-available-in-sw":"This method is available in a service worker context.","permission-default":"The notification permission was not granted and dismissed instead.","permission-blocked":"The notification permission was not granted and blocked instead.","unsupported-browser":"This browser doesn't support the API's required to use the Firebase SDK.","indexed-db-unsupported":"This browser doesn't support indexedDb.open() (ex. Safari iFrame, Firefox Private Browsing, etc)","failed-service-worker-registration":"We are unable to register the default service worker. {$browserErrorMessage}","token-subscribe-failed":"A problem occurred while subscribing the user to FCM: {$errorInfo}","token-subscribe-no-token":"FCM returned no token when subscribing the user to push.","token-unsubscribe-failed":"A problem occurred while unsubscribing the user from FCM: {$errorInfo}","token-update-failed":"A problem occurred while updating the user from FCM: {$errorInfo}","token-update-no-token":"FCM returned no token when updating the user to push.","use-sw-after-get-token":"The useServiceWorker() method may only be called once and must be called before calling getToken() to ensure your service worker is used.","invalid-sw-registration":"The input to useServiceWorker() must be a ServiceWorkerRegistration.","invalid-bg-handler":"The input to setBackgroundMessageHandler() must be a function.","invalid-vapid-key":"The public VAPID key must be a string.","use-vapid-key-after-get-token":"The usePublicVapidKey() method may only be called once and must be called before calling getToken() to ensure your VAPID key is used."},w=new Y("messaging","Messaging",cs);/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function ds(e,t){const n=await ke(e),r=$t(t),s={method:"POST",headers:n,body:JSON.stringify(r)};let i;try{i=await(await fetch(De(e.appConfig),s)).json()}catch(o){throw w.create("token-subscribe-failed",{errorInfo:o==null?void 0:o.toString()})}if(i.error){const o=i.error.message;throw w.create("token-subscribe-failed",{errorInfo:o})}if(!i.token)throw w.create("token-subscribe-no-token");return i.token}async function ls(e,t){const n=await ke(e),r=$t(t.subscriptionOptions),s={method:"PATCH",headers:n,body:JSON.stringify(r)};let i;try{i=await(await fetch(`${De(e.appConfig)}/${t.token}`,s)).json()}catch(o){throw w.create("token-update-failed",{errorInfo:o==null?void 0:o.toString()})}if(i.error){const o=i.error.message;throw w.create("token-update-failed",{errorInfo:o})}if(!i.token)throw w.create("token-update-no-token");return i.token}async function us(e,t){const r={method:"DELETE",headers:await ke(e)};try{const i=await(await fetch(`${De(e.appConfig)}/${t}`,r)).json();if(i.error){const o=i.error.message;throw w.create("token-unsubscribe-failed",{errorInfo:o})}}catch(s){throw w.create("token-unsubscribe-failed",{errorInfo:s==null?void 0:s.toString()})}}function De({projectId:e}){return`${Yr}/projects/${e}/registrations`}async function ke({appConfig:e,installations:t}){const n=await t.getToken();return new Headers({"Content-Type":"application/json",Accept:"application/json","x-goog-api-key":e.apiKey,"x-goog-firebase-installations-auth":`FIS ${n}`})}function $t({p256dh:e,auth:t,endpoint:n,vapidKey:r}){const s={web:{endpoint:n,auth:t,p256dh:e}};return r!==Dt&&(s.web.applicationPubKey=r),s}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const fs=7*24*60*60*1e3;async function hs(e){const t=await gs(e.swRegistration,e.vapidKey),n={vapidKey:e.vapidKey,swScope:e.swRegistration.scope,endpoint:t.endpoint,auth:v(t.getKey("auth")),p256dh:v(t.getKey("p256dh"))},r=await as(e.firebaseDependencies);if(r){if(ms(r.subscriptionOptions,n))return Date.now()>=r.createTime+fs?ps(e,{token:r.token,createTime:Date.now(),subscriptionOptions:n}):r.token;try{await us(e.firebaseDependencies,r.token)}catch(s){console.warn(s)}return Ge(e.firebaseDependencies,n)}else return Ge(e.firebaseDependencies,n)}async function ps(e,t){try{const n=await ls(e.firebaseDependencies,t),r=Object.assign(Object.assign({},t),{token:n,createTime:Date.now()});return await Ce(e.firebaseDependencies,r),n}catch(n){throw n}}async function Ge(e,t){const r={token:await ds(e,t),createTime:Date.now(),subscriptionOptions:t};return await Ce(e,r),r.token}async function gs(e,t){const n=await e.pushManager.getSubscription();return n||e.pushManager.subscribe({userVisibleOnly:!0,applicationServerKey:ts(t)})}function ms(e,t){const n=t.vapidKey===e.vapidKey,r=t.endpoint===e.endpoint,s=t.auth===e.auth,i=t.p256dh===e.p256dh;return n&&r&&s&&i}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Je(e){const t={from:e.from,collapseKey:e.collapse_key,messageId:e.fcmMessageId};return bs(t,e),ys(t,e),ws(t,e),t}function bs(e,t){if(!t.notification)return;e.notification={};const n=t.notification.title;n&&(e.notification.title=n);const r=t.notification.body;r&&(e.notification.body=r);const s=t.notification.image;s&&(e.notification.image=s);const i=t.notification.icon;i&&(e.notification.icon=i)}function ys(e,t){t.data&&(e.data=t.data)}function ws(e,t){var n,r,s,i,o;if(!t.fcmOptions&&!(!((n=t.notification)===null||n===void 0)&&n.click_action))return;e.fcmOptions={};const l=(s=(r=t.fcmOptions)===null||r===void 0?void 0:r.link)!==null&&s!==void 0?s:(i=t.notification)===null||i===void 0?void 0:i.click_action;l&&(e.fcmOptions.link=l);const f=(o=t.fcmOptions)===null||o===void 0?void 0:o.analytics_label;f&&(e.fcmOptions.analyticsLabel=f)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Es(e){return typeof e=="object"&&!!e&&kt in e}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */Is("AzSCbw63g1R0nCw85jG8","Iaya3yLKwmgvh7cF0q4");function Is(e,t){const n=[];for(let r=0;r<e.length;r++)n.push(e.charAt(r)),r<t.length&&n.push(t.charAt(r));return n.join("")}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function vs(e){if(!e||!e.options)throw he("App Configuration Object");if(!e.name)throw he("App Name");const t=["projectId","apiKey","appId","messagingSenderId"],{options:n}=e;for(const r of t)if(!n[r])throw he(r);return{appName:e.name,projectId:n.projectId,apiKey:n.apiKey,appId:n.appId,senderId:n.messagingSenderId}}function he(e){return w.create("missing-app-config-values",{valueName:e})}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */class Ss{constructor(t,n,r){this.deliveryMetricsExportedToBigQueryEnabled=!1,this.onBackgroundMessageHandler=null,this.onMessageHandler=null,this.logEvents=[],this.isLogServiceStarted=!1;const s=vs(t);this.firebaseDependencies={app:t,appConfig:s,installations:n,analyticsProvider:r}}_delete(){return Promise.resolve()}}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function _s(e){try{e.swRegistration=await navigator.serviceWorker.register(Jr,{scope:Xr}),e.swRegistration.update().catch(()=>{}),await Ts(e.swRegistration)}catch(t){throw w.create("failed-service-worker-registration",{browserErrorMessage:t==null?void 0:t.message})}}async function Ts(e){return new Promise((t,n)=>{const r=setTimeout(()=>n(new Error(`Service worker not registered after ${Ke} ms`)),Ke),s=e.installing||e.waiting;e.active?(clearTimeout(r),t()):s?s.onstatechange=i=>{var o;((o=i.target)===null||o===void 0?void 0:o.state)==="activated"&&(s.onstatechange=null,clearTimeout(r),t())}:(clearTimeout(r),n(new Error("No incoming service worker found.")))})}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function As(e,t){if(!t&&!e.swRegistration&&await _s(e),!(!t&&e.swRegistration)){if(!(t instanceof ServiceWorkerRegistration))throw w.create("invalid-sw-registration");e.swRegistration=t}}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Cs(e,t){t?e.vapidKey=t:e.vapidKey||(e.vapidKey=Dt)}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Ds(e,t){if(!navigator)throw w.create("only-available-in-window");if(Notification.permission==="default"&&await Notification.requestPermission(),Notification.permission!=="granted")throw w.create("permission-blocked");return await Cs(e,t==null?void 0:t.vapidKey),await As(e,t==null?void 0:t.serviceWorkerRegistration),hs(e)}/**
 * @license
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function ks(e,t,n){const r=Os(t);(await e.firebaseDependencies.analyticsProvider.get()).logEvent(r,{message_id:n[kt],message_name:n[Zr],message_time:n[Qr],message_device_time:Math.floor(Date.now()/1e3)})}function Os(e){switch(e){case U.NOTIFICATION_CLICKED:return"notification_open";case U.PUSH_RECEIVED:return"notification_foreground";default:throw new Error}}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Ms(e,t){const n=t.data;if(!n.isFirebaseMessaging)return;e.onMessageHandler&&n.messageType===U.PUSH_RECEIVED&&(typeof e.onMessageHandler=="function"?e.onMessageHandler(Je(n)):e.onMessageHandler.next(Je(n)));const r=n.data;Es(r)&&r[es]==="1"&&await ks(e,n.messageType,r)}const Xe="@firebase/messaging",Ye="0.12.17";/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */const $s=e=>{const t=new Ss(e.getProvider("app").getImmediate(),e.getProvider("installations-internal").getImmediate(),e.getProvider("analytics-internal"));return navigator.serviceWorker.addEventListener("message",n=>Ms(t,n)),t},Ns=e=>{const t=e.getProvider("messaging").getImmediate();return{getToken:r=>Ds(t,r)}};function Bs(){M(new D("messaging",$s,"PUBLIC")),M(new D("messaging-internal",Ns,"PRIVATE")),C(Xe,Ye),C(Xe,Ye,"esm2017")}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */async function Rs(){try{await rt()}catch{return!1}return typeof window<"u"&&nt()&&Jt()&&"serviceWorker"in navigator&&"PushManager"in window&&"Notification"in window&&"fetch"in window&&ServiceWorkerRegistration.prototype.hasOwnProperty("showNotification")&&PushSubscription.prototype.hasOwnProperty("getKey")}/**
 * @license
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Ls(e,t){if(!navigator)throw w.create("only-available-in-window");return e.onMessageHandler=t,()=>{e.onMessageHandler=null}}/**
 * @license
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */function Ps(e=Yn()){return Rs().then(t=>{if(!t)throw w.create("unsupported-browser")},t=>{throw w.create("indexed-db-unsupported")}),ve(st(e),"messaging").getImmediate()}function js(e,t){return e=st(e),Ls(e,t)}Bs();document.addEventListener("DOMContentLoaded",()=>{const e=window.Laravel.user.id,t=document.querySelector('meta[name="csrf-token"]').getAttribute("content"),n=window.pinImgUrl,r=window.unpinImgUrl,s=window.deleteImgUrl;let i=null,o=null,l=new Set,f=!1;function p(a,d){Notification.permission==="granted"&&new Notification(a,{body:d})}function m(a){const d=a.parentElement,c=document.createElement("button"),u=document.createElement("div");c.textContent="😉",c.type="button",c.classList.add("emoji-button"),u.classList.add("emoji-picker"),u.style.position="absolute",u.style.bottom="50px",u.style.left="10px";const g=["😀","😁","😂","🤣","😃","😄","😅","😆","😉","😊","😍","😘","😜","😎","😭","😡","😇","😈","🙃","🤔","😥","😓","🤩","🥳","🤯","🤬","🤡","👻","💀","👽","🤖","🎃","🐱","🐶","🐭","🐹","🐰","🦊","🐻","🐼","🦁","🐮","🐷","🐸","🐵","🐔","🐧","🐦","🌹","🌻","🌺","🌷","🌼","🍎","🍓","🍒","🍇","🍉","🍋","🍊","🍌","🥝","🍍","🥭"];let h="";g.forEach(y=>{h+=`<span class="emoji-item">${y}</span>`}),u.innerHTML=h,u.addEventListener("click",y=>{if(y.target.classList.contains("emoji-item")){const z=y.target.textContent,x=a.selectionStart,G=a.value.substring(0,x),I=a.value.substring(x);a.value=G+z+I;const H=x+z.length;a.selectionStart=H,a.selectionEnd=H,a.focus()}}),d.appendChild(c),d.appendChild(u),u.style.display="none",c.addEventListener("click",y=>{y.stopPropagation(),u.style.display=u.style.display==="none"?"flex":"none"}),document.addEventListener("click",y=>{!u.contains(y.target)&&!c.contains(y.target)&&(u.style.display="none")})}function E(a){return new Date(a).toLocaleTimeString("ru-RU",{hour:"2-digit",minute:"2-digit"})}function T(a){const d={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"};return a.replace(/[&<>"']/g,c=>d[c])}function B(){const a=document.getElementById("chat-messages");a.scrollTop=a.scrollHeight}function R(){document.querySelectorAll("#chat-messages ul li").forEach(a=>{a.style.display=f?a.classList.contains("pinned")?"":"none":""})}function te(a,d){const u=document.getElementById("chat-messages").querySelector("ul");let g="";a.forEach(h=>{if(!l.has(h.id)){if(h.message_type==="notification"||h.is_system)g+=`
                        <li class="system-notification" data-id="${h.id}">
                            ${h.message}
                            <span class="message-time">${E(h.created_at)}</span>
                        </li>
                    `;else{const y=h.sender_id===d,z=h.message_type==="notification"?"notification-message":y?"my-message":"other-message",x=h.is_pinned?"pinned":"";let G="";y&&h.is_read&&(G='<span class="read-status">✓✓</span>');let I="";h.message&&h.message.trim()!==""&&(h.message_type==="notification"?I+=h.message:I+=`<div>${T(h.message)}</div>`),h.attachments&&h.attachments.length>0&&h.attachments.forEach(V=>{V.mime&&V.mime.startsWith("image/")?I+=`<div><img src="${V.url}" alt="Image" style="max-width:100%; border-radius:4px;"></div>`:I+=`<div><a href="${V.url}" target="_blank">${T(V.original_file_name)}</a></div>`}),I.trim()===""&&(I='<div style="color:#888;">[Пустое сообщение]</div>');let H="";y&&(H=`
                            <div class="message-controls">
                                <button class="delete-message" data-id="${h.id}"><img src="${s}" alt="Удалить"></button>
                                ${h.is_pinned?`<button class="unpin-message" data-id="${h.id}"><img src="${r}" alt="Открепить"></button>`:`<button class="pin-message" data-id="${h.id}"><img src="${n}" alt="Закрепить"></button>`}
                            </div>
                        `),g+=`
                        <li class="${z} ${x}" data-id="${h.id}">
                            <div><strong>${y?"Вы":T(h.sender_name||"Неизвестно")}</strong></div>
                            ${I}
                            ${H}
                            <span class="message-time">${E(h.created_at)}</span>
                            ${G}
                        </li>
                    `,h.sender_id!==d&&p("Новое сообщение",h.message)}l.add(h.id)}}),g&&(u.insertAdjacentHTML("beforeend",g),B(),Nt(),R())}function Nt(){document.querySelectorAll(".delete-message").forEach(a=>{a.onclick=function(){const d=this.getAttribute("data-id");confirm("Удалить сообщение?")&&fetch(`/chats/${o}/${i}/messages/${d}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":t,"Content-Type":"application/json"}}).then(c=>c.json()).then(c=>{c.success?this.closest("li").remove():alert(c.error||"Ошибка удаления сообщения")}).catch(c=>console.error("Ошибка:",c))}}),document.querySelectorAll(".pin-message").forEach(a=>{a.onclick=function(){const d=this.getAttribute("data-id");fetch(`/chats/${o}/${i}/messages/${d}/pin`,{method:"POST",headers:{"X-CSRF-TOKEN":t,"Content-Type":"application/json"}}).then(c=>c.json()).then(c=>{if(c.success){this.innerHTML=`<img src="${r}" alt="Открепить">`,this.classList.remove("pin-message"),this.classList.add("unpin-message");let u=this.closest("li");if(u.classList.add("pinned"),u&&!u.querySelector(".pinned-label")){let g=document.createElement("span");g.classList.add("pinned-label"),g.textContent=" [Закреплено]",u.querySelector("div").appendChild(g)}R()}else alert(c.error||"Ошибка закрепления сообщения")}).catch(c=>console.error("Ошибка:",c))}}),document.querySelectorAll(".unpin-message").forEach(a=>{a.onclick=function(){const d=this.getAttribute("data-id");fetch(`/chats/${o}/${i}/messages/${d}/unpin`,{method:"POST",headers:{"X-CSRF-TOKEN":t,"Content-Type":"application/json"}}).then(c=>c.json()).then(c=>{if(c.success){this.innerHTML=`<img src="${n}" alt="Закрепить">`,this.classList.remove("unpin-message"),this.classList.add("pin-message");let u=this.closest("li");u.classList.remove("pinned");let g=u.querySelector(".pinned-label");g&&g.remove(),R()}else alert(c.error||"Ошибка открепления сообщения")}).catch(c=>console.error("Ошибка:",c))}})}function Oe(a,d){i=a,o=d;const u=document.getElementById("chat-messages").querySelector("ul");u.innerHTML="",l.clear();const g=document.querySelector(`[data-chat-id="${a}"][data-chat-type="${d}"] h5`),h=document.getElementById("chat-header");h.textContent=g?g.textContent:"Выберите чат для общения",fetch(`/chats/${d}/${a}/messages`).then(y=>{if(!y.ok)throw new Error("Network response was not ok");return y.json()}).then(y=>{te(y.messages,e),Me(a,d)}).catch(y=>{console.error("Ошибка загрузки сообщений:",y),p("Ошибка","Не удалось загрузить сообщения. Проверьте соединение с интернетом.")})}function ne(){if(!i||!P.value.trim()&&!document.querySelector(".file-input").files[0])return;const a=P.value.trim(),c=document.querySelector(".file-input").files;let u=new FormData;u.append("message",a);for(let g=0;g<c.length;g++)u.append("files[]",c[g]);fetch(`/chats/${o}/${i}/messages`,{method:"POST",headers:{"X-CSRF-TOKEN":t},body:u}).then(g=>g.ok?g.json():g.text().then(h=>{throw new Error(h)})).then(g=>{g.message&&(te([g.message],g.message.sender_id),P.value="",document.querySelector(".file-input").value="")}).catch(g=>console.error("Ошибка при отправке сообщения:",g))}function Me(a,d){fetch(`/chats/${d}/${a}/mark-read`,{method:"POST",headers:{"X-CSRF-TOKEN":t}}).catch(c=>console.error("Ошибка при пометке сообщений как прочитанных:",c))}function Bt(){fetch("/chats/unread-counts",{method:"GET",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":t}}).then(a=>{if(!a.ok)throw new Error("Network response was not ok");return a.json()}).then(a=>{a.unread_counts&&a.unread_counts.forEach(d=>{d.unread_count>0&&p("Новое сообщение",`У вас ${d.unread_count} новых сообщений в чате ${d.name}`)})}).catch(a=>console.error("Ошибка при проверке новых сообщений:",a))}setInterval(Bt,5e3);const L=document.getElementById("chat-list");L&&L.addEventListener("click",a=>{const d=a.target.closest("li");if(!d)return;const c=d.getAttribute("data-chat-id"),u=d.getAttribute("data-chat-type");i===c&&o===u||Oe(c,u)});const W=document.getElementById("search-chats"),F=document.getElementById("search-results");W&&W.addEventListener("input",function(){const a=W.value.trim().toLowerCase();a===""?(F.style.display="none",Array.from(L.children).forEach(d=>{d.style.display="flex"})):(Array.from(L.children).forEach(d=>{const c=d.querySelector("h5").textContent.toLowerCase();d.style.display=c.includes(a)?"flex":"none"}),fetch("/chats/search",{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":t},body:JSON.stringify({query:a})}).then(d=>d.json()).then(d=>{let c="";d.chats&&d.chats.length>0&&(c+="<h5>Чаты</h5><ul>",d.chats.forEach(u=>{c+=`<li data-chat-id="${u.id}" data-chat-type="${u.type}">${u.name}</li>`}),c+="</ul>"),d.messages&&d.messages.length>0&&(c+="<h5>Сообщения</h5><ul>",d.messages.forEach(u=>{let g=u.chat_id,h="group";g||(h="personal",g=u.sender_id==e?u.receiver_id:u.sender_id),c+=`<li data-chat-id="${g}" data-chat-type="${h}" data-message-id="${u.id}">
                                <strong>${u.sender_name}:</strong> ${u.message.substring(0,50)}...
                                <br><small>${E(u.created_at)}</small>
                            </li>`}),c+="</ul>"),F.innerHTML=c,F.style.display=c.trim()===""?"none":"block",Array.from(F.querySelectorAll("li")).forEach(u=>{u.addEventListener("click",function(){const g=this.getAttribute("data-chat-id"),h=this.getAttribute("data-chat-type"),y=this.getAttribute("data-message-id");Oe(g,h),W.value="",F.style.display="none",y&&setTimeout(()=>{},1e3)})})}).catch(d=>console.error("Ошибка поиска:",d)))});function $e(){const a=document.querySelector(".attach-file"),d=document.querySelector(".file-input");a&&d&&(a.addEventListener("click",()=>{d.click()}),d.addEventListener("change",()=>{d.files.length>0&&ne()}))}document.readyState!=="loading"?$e():document.addEventListener("DOMContentLoaded",$e);const Ne=document.getElementById("send-message"),P=document.getElementById("chat-message");Ne&&Ne.addEventListener("click",ne),P&&P.addEventListener("keypress",a=>{a.key==="Enter"&&!a.shiftKey&&(a.preventDefault(),ne())}),m(P);function Rt(){Notification.permission==="granted"?p("Тестовое уведомление","Это тестовое уведомление для проверки работоспособности."):Notification.permission!=="denied"&&Notification.requestPermission().then(a=>{a==="granted"&&p("Тестовое уведомление","Это тестовое уведомление для проверки работоспособности.")})}Rt(),document.addEventListener("DOMContentLoaded",()=>{const a=L?L.querySelector("li"):null;a&&a.click()}),setInterval(()=>{if(i&&o){const d=document.getElementById("chat-messages").querySelector("ul");fetch(`/chats/${o}/${i}/new-messages`,{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":t},body:JSON.stringify({last_message_id:d.lastElementChild?parseInt(d.lastElementChild.getAttribute("data-id")):0})}).then(c=>{if(!c.ok)throw new Error("Network response was not ok");return c.json()}).then(c=>{c.messages&&(te(c.messages,c.current_user_id),Me(i,o))}).catch(c=>{console.error("Ошибка при получении новых сообщений:",c),p("Ошибка","Не удалось получить новые сообщения. Проверьте соединение с интернетом.")})}},1e3),document.addEventListener("click",function(a){if(a.target.matches(".notification-message a[data-message-id]")){a.preventDefault();const d=a.target.dataset.messageId,c=document.querySelector(`li[data-id="${d}"]`);c&&(c.scrollIntoView({behavior:"smooth",block:"center"}),c.style.backgroundColor="#007ab6",setTimeout(()=>{c.style.backgroundColor=""},2e3))}});const re=document.getElementById("toggle-pinned");re&&re.addEventListener("click",()=>{f=!f,re.textContent=f?"Показать все сообщения":"Показать только закрепленные",R()});const Lt=at({apiKey:"AIzaSyB6N1n8dW95YGMMuTsZMRnJY1En7lK2s2M",authDomain:"dlk-diz.firebaseapp.com",projectId:"dlk-diz",storageBucket:"dlk-diz.firebasestorage.app",messagingSenderId:"209164982906",appId:"1:209164982906:web:0836fbb02e7effd80679c3"}),Pt=Ps(Lt);js(Pt,a=>{console.log("Message received. ",a),new Notification(a.notification.title,{body:a.notification.body,icon:a.notification.icon})})});
