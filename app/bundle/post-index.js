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
/******/ 	return __webpack_require__(__webpack_require__.s = "./app/views/post-index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./app/views/post-index.js":
/*!*********************************!*\
  !*** ./app/views/post-index.js ***!
  \*********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nvar Post = {\n  name: 'post',\n  el: '#app',\n\n  data() {\n    return _.merge({\n      posts: false,\n      config: {\n        filter: this.$session.get('posts.filter', {\n          order: 'date desc',\n          limit: 10\n        })\n      },\n      pages: 0,\n      count: '',\n      selected: [],\n      canEditAll: false\n    }, window.$data);\n  },\n\n  mounted() {\n    this.resource = this.$resource('admin/api/blog/post{/id}');\n    this.$watch('config.page', this.load, {\n      immediate: true\n    });\n  },\n\n  watch: {\n    'config.filter': {\n      handler(filter) {\n        if (this.config.page) {\n          this.config.page = 0;\n        } else {\n          this.load();\n        }\n\n        this.$session.set('posts.filter', filter);\n      },\n\n      deep: true\n    }\n  },\n  computed: {\n    statusOptions() {\n      const options = _.map(this.statuses, (status, id) => ({\n        text: status,\n        value: id\n      }));\n\n      return [{\n        label: this.$trans('Filter by'),\n        options\n      }];\n    },\n\n    categoryOptions() {\n      const options = _.map(this.categories, (category, id) => ({\n        text: category.title,\n        value: category.id\n      }));\n\n      return [{\n        label: this.$trans('Filter by'),\n        options\n      }];\n    },\n\n    users() {\n      const options = _.map(this.authors, author => ({\n        text: author.username,\n        value: author.user_id\n      }));\n\n      return [{\n        label: this.$trans('Filter by'),\n        options\n      }];\n    }\n\n  },\n  methods: {\n    active(post) {\n      return this.selected.indexOf(post.id) != -1;\n    },\n\n    save(data) {\n      this.resource.save({\n        id: data.id\n      }, {\n        data\n      }).then(function () {\n        this.load();\n        this.$notify('Post saved.');\n      });\n    },\n\n    status(status) {\n      const posts = this.getSelected();\n      posts.forEach(post => {\n        post.status = status;\n      });\n      this.resource.save({\n        id: 'bulk'\n      }, {\n        posts\n      }).then(function () {\n        this.load();\n        this.$notify('Posts saved.');\n      });\n    },\n\n    remove() {\n      this.resource.delete({\n        id: 'bulk'\n      }, {\n        ids: this.selected\n      }).then(function () {\n        this.load();\n        this.$notify('Posts deleted.');\n      });\n    },\n\n    toggleStatus(post) {\n      post.status = post.status === 2 ? 3 : 2;\n      this.save(post);\n    },\n\n    copy() {\n      if (!this.selected.length) {\n        return;\n      }\n\n      this.resource.save({\n        id: 'copy'\n      }, {\n        ids: this.selected\n      }).then(function () {\n        this.load();\n        this.$notify('Posts copied.');\n      });\n    },\n\n    load() {\n      this.resource.query({\n        filter: this.config.filter,\n        page: this.config.page\n      }).then(function (res) {\n        const {\n          data\n        } = res;\n        this.$set(this, 'posts', data.posts);\n        this.$set(this, 'pages', data.pages);\n        this.$set(this, 'count', data.count);\n        this.$set(this, 'selected', []);\n      });\n    },\n\n    getSelected() {\n      return this.posts.filter(function (post) {\n        return this.selected.indexOf(post.id) !== -1;\n      }, this);\n    },\n\n    getStatusText(post) {\n      return this.statuses[post.status];\n    },\n\n    getCategoriesText(categories) {\n      let data = [];\n\n      _.forEach(categories, category => {\n        data.push(category.title);\n      });\n\n      return _.join(data, ',');\n    }\n\n  }\n};\n/* harmony default export */ __webpack_exports__[\"default\"] = (Post);\nVue.ready(Post);\n\n//# sourceURL=webpack:///./app/views/post-index.js?");

/***/ })

/******/ });