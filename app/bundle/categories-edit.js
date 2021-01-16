/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./app/views/categories-edit.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./app/components/categories-content.vue":
/*!***********************************************!*\
  !*** ./app/components/categories-content.vue ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _categories_content_vue_vue_type_template_id_5c61be56___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./categories-content.vue?vue&type=template&id=5c61be56& */ \"./app/components/categories-content.vue?vue&type=template&id=5c61be56&\");\n/* harmony import */ var _categories_content_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./categories-content.vue?vue&type=script&lang=js& */ \"./app/components/categories-content.vue?vue&type=script&lang=js&\");\n/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ \"./node_modules/vue-loader/lib/runtime/componentNormalizer.js\");\n\n\n\n\n\n/* normalize component */\n\nvar component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(\n  _categories_content_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[\"default\"],\n  _categories_content_vue_vue_type_template_id_5c61be56___WEBPACK_IMPORTED_MODULE_0__[\"render\"],\n  _categories_content_vue_vue_type_template_id_5c61be56___WEBPACK_IMPORTED_MODULE_0__[\"staticRenderFns\"],\n  false,\n  null,\n  null,\n  null\n  \n)\n\n/* hot reload */\nif (false) { var api; }\ncomponent.options.__file = \"app/components/categories-content.vue\"\n/* harmony default export */ __webpack_exports__[\"default\"] = (component.exports);\n\n//# sourceURL=webpack:///./app/components/categories-content.vue?");

/***/ }),

/***/ "./app/components/categories-content.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./app/components/categories-content.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_babel_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_categories_content_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/babel-loader/lib!../../node_modules/vue-loader/lib??vue-loader-options!./categories-content.vue?vue&type=script&lang=js& */ \"./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./app/components/categories-content.vue?vue&type=script&lang=js&\");\n/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__[\"default\"] = (_node_modules_babel_loader_lib_index_js_node_modules_vue_loader_lib_index_js_vue_loader_options_categories_content_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__[\"default\"]); \n\n//# sourceURL=webpack:///./app/components/categories-content.vue?");

/***/ }),

/***/ "./app/components/categories-content.vue?vue&type=template&id=5c61be56&":
/*!******************************************************************************!*\
  !*** ./app/components/categories-content.vue?vue&type=template&id=5c61be56& ***!
  \******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_categories_content_vue_vue_type_template_id_5c61be56___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../node_modules/vue-loader/lib??vue-loader-options!./categories-content.vue?vue&type=template&id=5c61be56& */ \"./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./app/components/categories-content.vue?vue&type=template&id=5c61be56&\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_categories_content_vue_vue_type_template_id_5c61be56___WEBPACK_IMPORTED_MODULE_0__[\"render\"]; });\n\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"staticRenderFns\", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_categories_content_vue_vue_type_template_id_5c61be56___WEBPACK_IMPORTED_MODULE_0__[\"staticRenderFns\"]; });\n\n\n\n//# sourceURL=webpack:///./app/components/categories-content.vue?");

/***/ }),

/***/ "./app/views/categories-edit.js":
/*!**************************************!*\
  !*** ./app/views/categories-edit.js ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _components_categories_content_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/categories-content.vue */ \"./app/components/categories-content.vue\");\n/* eslint-disable no-restricted-syntax */\n\nconst categories = {\n  el: '#app',\n  name: 'CategoriesEdit',\n\n  data() {\n    return _.merge({\n      sections: [],\n      active: this.$session.get('categories.edit.tab.active', 0)\n    }, window.$data);\n  },\n\n  created() {\n    const sections = [];\n\n    _.forIn(this.$options.components, (component, name) => {\n      if (component.section) {\n        sections.push(_.extend({\n          name,\n          priority: 0\n        }, component.section));\n      }\n    });\n\n    this.$set(this, 'sections', _.sortBy(sections, 'priority'));\n  },\n\n  mounted() {\n    const vm = this;\n    this.tab = UIkit.tab('#tab', {\n      connect: '#content'\n    });\n    UIkit.util.on(this.tab.connects, 'show', (e, tab) => {\n      if (tab != vm.tab) return;\n\n      for (const index in tab.toggles) {\n        if (tab.toggles[index].classList.contains('uk-active')) {\n          vm.$session.set('categories.edit.tab.active', index);\n          vm.active = index;\n          break;\n        }\n      }\n    });\n    this.tab.show(this.active);\n  },\n\n  methods: {\n    submit() {\n      this.$http.post('admin/api/blog/category', {\n        id: this.category.id,\n        data: this.category\n      }).then(res => {\n        const response = res.data;\n\n        if (!this.category.id) {\n          window.history.replaceState({}, '', this.$url.route('admin/blog/categories/edit', {\n            id: response.category.id,\n            type: response.category.type\n          }));\n        }\n\n        this.$set(this, 'category', response.category);\n        this.$notify(this.$trans('Saved'));\n      }).catch(err => {\n        this.$notify(err.data, 'danger');\n      });\n    }\n\n  },\n  components: {\n    Section: _components_categories_content_vue__WEBPACK_IMPORTED_MODULE_0__[\"default\"]\n  }\n};\n/* harmony default export */ __webpack_exports__[\"default\"] = (categories);\nwindow.Categories = categories;\nVue.ready(window.Categories);\n\n//# sourceURL=webpack:///./app/views/categories-edit.js?");

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader/lib/index.js?!./app/components/categories-content.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options!./app/components/categories-content.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n//\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  props: ['category', 'data'],\n  section: {\n    label: 'Settings',\n    priorty: 0\n  }\n});\n\n//# sourceURL=webpack:///./app/components/categories-content.vue?./node_modules/babel-loader/lib!./node_modules/vue-loader/lib??vue-loader-options");

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./app/components/categories-content.vue?vue&type=template&id=5c61be56&":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./app/components/categories-content.vue?vue&type=template&id=5c61be56& ***!
  \************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return render; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"staticRenderFns\", function() { return staticRenderFns; });\nvar render = function() {\n  var _vm = this\n  var _h = _vm.$createElement\n  var _c = _vm._self._c || _h\n  return _c(\"div\", [\n    _c(\"div\", { attrs: { \"uk-grid\": \"\" } }, [\n      _c(\"div\", { staticClass: \"uk-width-expand@s\" }, [\n        _c(\"div\", { staticClass: \"uk-margin\" }, [\n          _c(\"label\", { staticClass: \"uk-form-label\" }, [\n            _vm._v(_vm._s(_vm._f(\"trans\")(\"Title\")))\n          ]),\n          _vm._v(\" \"),\n          _c(\"div\", { staticClass: \"uk-form-controls\" }, [\n            _c(\"input\", {\n              directives: [\n                {\n                  name: \"model\",\n                  rawName: \"v-model\",\n                  value: _vm.category.title,\n                  expression: \"category.title\"\n                }\n              ],\n              staticClass: \"uk-input uk-form-large uk-width-expand\",\n              attrs: { type: \"text\", required: \"\" },\n              domProps: { value: _vm.category.title },\n              on: {\n                input: function($event) {\n                  if ($event.target.composing) {\n                    return\n                  }\n                  _vm.$set(_vm.category, \"title\", $event.target.value)\n                }\n              }\n            })\n          ])\n        ]),\n        _vm._v(\" \"),\n        _c(\"div\", { staticClass: \"uk-margin\" }, [\n          _c(\"label\", { staticClass: \"uk-form-label\" }, [\n            _vm._v(_vm._s(_vm._f(\"trans\")(\"Excerpt\")))\n          ]),\n          _vm._v(\" \"),\n          _c(\n            \"div\",\n            { staticClass: \"uk-form-controls\" },\n            [\n              _c(\"v-editor\", {\n                attrs: {\n                  options: { markdown: _vm.category.data.markdown, height: 300 }\n                },\n                model: {\n                  value: _vm.category.excerpt,\n                  callback: function($$v) {\n                    _vm.$set(_vm.category, \"excerpt\", $$v)\n                  },\n                  expression: \"category.excerpt\"\n                }\n              })\n            ],\n            1\n          )\n        ])\n      ]),\n      _vm._v(\" \"),\n      _c(\"div\", { staticClass: \"uk-width-medium@s\" }, [\n        _c(\"div\", { staticClass: \"uk-margin\" }, [\n          _c(\"label\", { staticClass: \"uk-form-label\" }, [\n            _vm._v(_vm._s(_vm._f(\"trans\")(\"Status\")))\n          ]),\n          _vm._v(\" \"),\n          _c(\"div\", { staticClass: \"uk-form-controls\" }, [\n            _c(\n              \"select\",\n              {\n                directives: [\n                  {\n                    name: \"model\",\n                    rawName: \"v-model\",\n                    value: _vm.category.status,\n                    expression: \"category.status\"\n                  }\n                ],\n                staticClass: \"uk-select uk-width-expand\",\n                on: {\n                  change: function($event) {\n                    var $$selectedVal = Array.prototype.filter\n                      .call($event.target.options, function(o) {\n                        return o.selected\n                      })\n                      .map(function(o) {\n                        var val = \"_value\" in o ? o._value : o.value\n                        return val\n                      })\n                    _vm.$set(\n                      _vm.category,\n                      \"status\",\n                      $event.target.multiple ? $$selectedVal : $$selectedVal[0]\n                    )\n                  }\n                }\n              },\n              _vm._l(_vm.data.statuses, function(status, id) {\n                return _c(\"option\", { key: id, domProps: { value: id } }, [\n                  _vm._v(\n                    \"\\n                            \" +\n                      _vm._s(status) +\n                      \"\\n                        \"\n                  )\n                ])\n              }),\n              0\n            )\n          ])\n        ]),\n        _vm._v(\" \"),\n        _c(\"div\", { staticClass: \"uk-margin\" }, [\n          _c(\"label\", { staticClass: \"uk-form-label\" }, [\n            _vm._v(_vm._s(_vm._f(\"trans\")(\"Slug\")))\n          ]),\n          _vm._v(\" \"),\n          _c(\"div\", { staticClass: \"uk-form-controls\" }, [\n            _c(\"input\", {\n              directives: [\n                {\n                  name: \"model\",\n                  rawName: \"v-model\",\n                  value: _vm.category.slug,\n                  expression: \"category.slug\"\n                }\n              ],\n              staticClass: \"uk-input uk-width-expand\",\n              attrs: { type: \"text\" },\n              domProps: { value: _vm.category.slug },\n              on: {\n                input: function($event) {\n                  if ($event.target.composing) {\n                    return\n                  }\n                  _vm.$set(_vm.category, \"slug\", $event.target.value)\n                }\n              }\n            })\n          ])\n        ]),\n        _vm._v(\" \"),\n        _c(\"div\", { staticClass: \"uk-margin\" }, [\n          _c(\"label\", { staticClass: \"uk-form-label\" }, [\n            _vm._v(_vm._s(_vm._f(\"trans\")(\"Publish on\")))\n          ]),\n          _vm._v(\" \"),\n          _c(\n            \"div\",\n            { staticClass: \"uk-form-controls\" },\n            [\n              _c(\"input-date\", {\n                model: {\n                  value: _vm.category.date,\n                  callback: function($$v) {\n                    _vm.$set(_vm.category, \"date\", $$v)\n                  },\n                  expression: \"category.date\"\n                }\n              })\n            ],\n            1\n          )\n        ]),\n        _vm._v(\" \"),\n        _c(\"div\", { staticClass: \"uk-margin\" }, [\n          _c(\"label\", { staticClass: \"uk-form-label\" }, [\n            _vm._v(_vm._s(_vm._f(\"trans\")(\"User\")))\n          ]),\n          _vm._v(\" \"),\n          _c(\"div\", { staticClass: \"uk-form-controls\" }, [\n            _c(\n              \"select\",\n              {\n                directives: [\n                  {\n                    name: \"model\",\n                    rawName: \"v-model\",\n                    value: _vm.category.user_id,\n                    expression: \"category.user_id\"\n                  }\n                ],\n                staticClass: \"uk-select uk-width-expand\",\n                on: {\n                  change: function($event) {\n                    var $$selectedVal = Array.prototype.filter\n                      .call($event.target.options, function(o) {\n                        return o.selected\n                      })\n                      .map(function(o) {\n                        var val = \"_value\" in o ? o._value : o.value\n                        return val\n                      })\n                    _vm.$set(\n                      _vm.category,\n                      \"user_id\",\n                      $event.target.multiple ? $$selectedVal : $$selectedVal[0]\n                    )\n                  }\n                }\n              },\n              _vm._l(_vm.data.users, function(user) {\n                return _c(\n                  \"option\",\n                  { key: user.id, domProps: { value: user.id } },\n                  [\n                    _vm._v(\n                      \"\\n                            \" +\n                        _vm._s(user.name) +\n                        \" - \" +\n                        _vm._s(user.username) +\n                        \"\\n                        \"\n                    )\n                  ]\n                )\n              }),\n              0\n            )\n          ])\n        ]),\n        _vm._v(\" \"),\n        _c(\"div\", { staticClass: \"uk-margin\" }, [\n          _c(\"label\", { staticClass: \"uk-form-label\" }, [\n            _vm._v(_vm._s(_vm._f(\"trans\")(\"Restrict Access\")))\n          ]),\n          _vm._v(\" \"),\n          _c(\n            \"div\",\n            { staticClass: \"uk-form-controls uk-form-controls-text\" },\n            _vm._l(_vm.data.roles, function(role) {\n              return _c(\"p\", { key: role.id, staticClass: \"uk-margin-small\" }, [\n                _c(\"label\", [\n                  _c(\"input\", {\n                    directives: [\n                      {\n                        name: \"model\",\n                        rawName: \"v-model\",\n                        value: _vm.category.roles,\n                        expression: \"category.roles\"\n                      }\n                    ],\n                    staticClass: \"uk-checkbox\",\n                    attrs: { type: \"checkbox\", number: \"\" },\n                    domProps: {\n                      value: role.id,\n                      checked: Array.isArray(_vm.category.roles)\n                        ? _vm._i(_vm.category.roles, role.id) > -1\n                        : _vm.category.roles\n                    },\n                    on: {\n                      change: function($event) {\n                        var $$a = _vm.category.roles,\n                          $$el = $event.target,\n                          $$c = $$el.checked ? true : false\n                        if (Array.isArray($$a)) {\n                          var $$v = role.id,\n                            $$i = _vm._i($$a, $$v)\n                          if ($$el.checked) {\n                            $$i < 0 &&\n                              _vm.$set(_vm.category, \"roles\", $$a.concat([$$v]))\n                          } else {\n                            $$i > -1 &&\n                              _vm.$set(\n                                _vm.category,\n                                \"roles\",\n                                $$a.slice(0, $$i).concat($$a.slice($$i + 1))\n                              )\n                          }\n                        } else {\n                          _vm.$set(_vm.category, \"roles\", $$c)\n                        }\n                      }\n                    }\n                  }),\n                  _c(\"span\", { staticClass: \"uk-margin-small-left\" }, [\n                    _vm._v(_vm._s(role.name))\n                  ])\n                ])\n              ])\n            }),\n            0\n          )\n        ]),\n        _vm._v(\" \"),\n        _c(\"div\", { staticClass: \"uk-margin\" }, [\n          _c(\"label\", { staticClass: \"uk-form-label\" }, [\n            _vm._v(_vm._s(_vm._f(\"trans\")(\"Options\")))\n          ]),\n          _vm._v(\" \"),\n          _c(\"div\", { staticClass: \"uk-form-controls uk-form-controls-text\" }, [\n            _c(\"p\", { staticClass: \"uk-margin-small\" }, [\n              _c(\"label\", [\n                _c(\"input\", {\n                  directives: [\n                    {\n                      name: \"model\",\n                      rawName: \"v-model\",\n                      value: _vm.category.data.markdown,\n                      expression: \"category.data.markdown\"\n                    }\n                  ],\n                  staticClass: \"uk-checkbox\",\n                  attrs: { type: \"checkbox\", value: \"1\" },\n                  domProps: {\n                    checked: Array.isArray(_vm.category.data.markdown)\n                      ? _vm._i(_vm.category.data.markdown, \"1\") > -1\n                      : _vm.category.data.markdown\n                  },\n                  on: {\n                    change: function($event) {\n                      var $$a = _vm.category.data.markdown,\n                        $$el = $event.target,\n                        $$c = $$el.checked ? true : false\n                      if (Array.isArray($$a)) {\n                        var $$v = \"1\",\n                          $$i = _vm._i($$a, $$v)\n                        if ($$el.checked) {\n                          $$i < 0 &&\n                            _vm.$set(\n                              _vm.category.data,\n                              \"markdown\",\n                              $$a.concat([$$v])\n                            )\n                        } else {\n                          $$i > -1 &&\n                            _vm.$set(\n                              _vm.category.data,\n                              \"markdown\",\n                              $$a.slice(0, $$i).concat($$a.slice($$i + 1))\n                            )\n                        }\n                      } else {\n                        _vm.$set(_vm.category.data, \"markdown\", $$c)\n                      }\n                    }\n                  }\n                }),\n                _c(\"span\", { staticClass: \"uk-margin-small-left\" }, [\n                  _vm._v(_vm._s(_vm._f(\"trans\")(\"Enable Markdown\")))\n                ])\n              ])\n            ])\n          ])\n        ])\n      ])\n    ])\n  ])\n}\nvar staticRenderFns = []\nrender._withStripped = true\n\n\n\n//# sourceURL=webpack:///./app/components/categories-content.vue?./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options");

/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"default\", function() { return normalizeComponent; });\n/* globals __VUE_SSR_CONTEXT__ */\n\n// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).\n// This module is a runtime utility for cleaner component module output and will\n// be included in the final webpack user bundle.\n\nfunction normalizeComponent (\n  scriptExports,\n  render,\n  staticRenderFns,\n  functionalTemplate,\n  injectStyles,\n  scopeId,\n  moduleIdentifier, /* server only */\n  shadowMode /* vue-cli only */\n) {\n  // Vue.extend constructor export interop\n  var options = typeof scriptExports === 'function'\n    ? scriptExports.options\n    : scriptExports\n\n  // render functions\n  if (render) {\n    options.render = render\n    options.staticRenderFns = staticRenderFns\n    options._compiled = true\n  }\n\n  // functional template\n  if (functionalTemplate) {\n    options.functional = true\n  }\n\n  // scopedId\n  if (scopeId) {\n    options._scopeId = 'data-v-' + scopeId\n  }\n\n  var hook\n  if (moduleIdentifier) { // server build\n    hook = function (context) {\n      // 2.3 injection\n      context =\n        context || // cached call\n        (this.$vnode && this.$vnode.ssrContext) || // stateful\n        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional\n      // 2.2 with runInNewContext: true\n      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {\n        context = __VUE_SSR_CONTEXT__\n      }\n      // inject component styles\n      if (injectStyles) {\n        injectStyles.call(this, context)\n      }\n      // register component module identifier for async chunk inferrence\n      if (context && context._registeredComponents) {\n        context._registeredComponents.add(moduleIdentifier)\n      }\n    }\n    // used by ssr in case component is cached and beforeCreate\n    // never gets called\n    options._ssrRegister = hook\n  } else if (injectStyles) {\n    hook = shadowMode\n      ? function () {\n        injectStyles.call(\n          this,\n          (options.functional ? this.parent : this).$root.$options.shadowRoot\n        )\n      }\n      : injectStyles\n  }\n\n  if (hook) {\n    if (options.functional) {\n      // for template-only hot-reload because in that case the render fn doesn't\n      // go through the normalizer\n      options._injectStyles = hook\n      // register for functional component in vue file\n      var originalRender = options.render\n      options.render = function renderWithStyleInjection (h, context) {\n        hook.call(context)\n        return originalRender(h, context)\n      }\n    } else {\n      // inject component registration as beforeCreate hook\n      var existing = options.beforeCreate\n      options.beforeCreate = existing\n        ? [].concat(existing, hook)\n        : [hook]\n    }\n  }\n\n  return {\n    exports: scriptExports,\n    options: options\n  }\n}\n\n\n//# sourceURL=webpack:///./node_modules/vue-loader/lib/runtime/componentNormalizer.js?");

/***/ })

/******/ });