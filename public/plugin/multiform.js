/*!
 * MultiForm v1.0.0-beta (https://github.com/mvanorder/multiform)
 * Copyright 2018 Malcolm VanOrder
 * MIT License (https://raw.githubusercontent.com/mvanorder/multiform/master/LICENSE)
 */
'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

if (!Array.from) {
  Array.from = function () {
    var toStr = Object.prototype.toString;
    var isCallable = function isCallable(fn) {
      return typeof fn === 'function' || toStr.call(fn) === '[object Function]';
    };
    var toInteger = function toInteger(value) {
      var number = Number(value);
      if (isNaN(number)) {
        return 0;
      }
      if (number === 0 || !isFinite(number)) {
        return number;
      }
      return (number > 0 ? 1 : -1) * Math.floor(Math.abs(number));
    };
    var maxSafeInteger = Math.pow(2, 53) - 1;
    var toLength = function toLength(value) {
      var len = toInteger(value);
      return Math.min(Math.max(len, 0), maxSafeInteger);
    };

    // The length property of the from method is 1.
    return function from(arrayLike /*, mapFn, thisArg */) {
      // 1. Let C be the this value.
      var C = this;

      // 2. Let items be ToObject(arrayLike).
      var items = Object(arrayLike);

      // 3. ReturnIfAbrupt(items).
      if (arrayLike == null) {
        throw new TypeError('Array.from requires an array-like object - not null or undefined');
      }

      // 4. If mapfn is undefined, then let mapping be false.
      var mapFn = arguments.length > 1 ? arguments[1] : void undefined;
      var T;
      if (typeof mapFn !== 'undefined') {
        // 5. else
        // 5. a If IsCallable(mapfn) is false, throw a TypeError exception.
        if (!isCallable(mapFn)) {
          throw new TypeError('Array.from: when provided, the second argument must be a function');
        }

        // 5. b. If thisArg was supplied, let T be thisArg; else let T be undefined.
        if (arguments.length > 2) {
          T = arguments[2];
        }
      }

      // 10. Let lenValue be Get(items, "length").
      // 11. Let len be ToLength(lenValue).
      var len = toLength(items.length);

      // 13. If IsConstructor(C) is true, then
      // 13. a. Let A be the result of calling the [[Construct]] internal method
      // of C with an argument list containing the single item len.
      // 14. a. Else, Let A be ArrayCreate(len).
      var A = isCallable(C) ? Object(new C(len)) : new Array(len);

      // 16. Let k be 0.
      var k = 0;
      // 17. Repeat, while k < len… (also steps a - h)
      var kValue;
      while (k < len) {
        kValue = items[k];
        if (mapFn) {
          A[k] = typeof T === 'undefined' ? mapFn(kValue, k) : mapFn.call(T, kValue, k);
        } else {
          A[k] = kValue;
        }
        k += 1;
      }
      // 18. Let putStatus be Put(A, "length", len, true).
      A.length = len;
      // 20. Return A.
      return A;
    };
  }();
}

if (!String.prototype.includes) {
  String.prototype.includes = function (search, start) {
    'use strict';

    if (typeof start !== 'number') {
      start = 0;
    }

    if (start + search.length > this.length) {
      return false;
    } else {
      return this.indexOf(search, start) !== -1;
    }
  };
}

// https://tc39.github.io/ecma262/#sec-array.prototype.includes
if (!Array.prototype.includes) {
  Object.defineProperty(Array.prototype, 'includes', {
    value: function value(searchElement, fromIndex) {

      if (this == null) {
        throw new TypeError('"this" is null or not defined');
      }

      // 1. Let O be ? ToObject(this value).
      var o = Object(this);

      // 2. Let len be ? ToLength(? Get(O, "length")).
      var len = o.length >>> 0;

      // 3. If len is 0, return false.
      if (len === 0) {
        return false;
      }

      // 4. Let n be ? ToInteger(fromIndex).
      //    (If fromIndex is undefined, this step produces the value 0.)
      var n = fromIndex | 0;

      // 5. If n ≥ 0, then
      //  a. Let k be n.
      // 6. Else n < 0,
      //  a. Let k be len + n.
      //  b. If k < 0, let k be 0.
      var k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

      function sameValueZero(x, y) {
        return x === y || typeof x === 'number' && typeof y === 'number' && isNaN(x) && isNaN(y);
      }

      // 7. Repeat, while k < len
      while (k < len) {
        // a. Let elementK be the result of ? Get(O, ! ToString(k)).
        // b. If SameValueZero(searchElement, elementK) is true, return true.
        if (sameValueZero(o[k], searchElement)) {
          return true;
        }
        // c. Increase k by 1.
        k++;
      }

      // 8. Return false
      return false;
    }
  });
}
;var FORM_ELEMENTS = ["DATALIST", "INPUT", "OPTGROUP", "SELECT", "TEXTAREA"];

/**
 * Clone nodes and add a prefix to ids, names, and for attributes on fields and labels.
 * @param {object} nodes - A nodes list of array of nodes to be cloned.
 * @param {string} prefix - The prefix to be added to the ids, names, and for attributes.
 */
function cloneFormNodes(nodes, prefix) {
  var newNodes = new Array();

  for (var i = 0; i < nodes.length; i++) {
    // Ignore all #text, #comment and #document nodes as they thrown an illegal character error in
    // createElement().
    if (!nodes[i].nodeName.includes('#')) {
      // Use createElement to create clones for all except #text nodes to avoid modifying the original.
      newNodes[i] = document.createElement(nodes[i].nodeName);

      // Copy all attributes from the original node to the new node
      for (var attrIndex = 0, attrSize = nodes[i].attributes.length; attrIndex < attrSize; attrIndex++) {
        newNodes[i].setAttribute(nodes[i].attributes[attrIndex].name, nodes[i].attributes[attrIndex].value);
      }

      if (FORM_ELEMENTS.includes(nodes[i].nodeName)) {
        // Prefix ids and names on fields.
        newNodes[i].name = prefix + nodes[i].name;
        newNodes[i].id = prefix + nodes[i].id;
      } else if (nodes[i].nodeName == "LABEL") {
        // Prefix for attributes on labels.
        newNodes[i].setAttribute('for', prefix + nodes[i].getAttribute('for'));
      } else {
        // If an element doesn't fall into either of the above statements then only apply the prefix if an is or name
        // exists.
        if (nodes[i].id) {
          newNodes[i].id = prefix + nodes[i].id;
        }
        if (nodes[i].name) {
          newNodes[i].name = prefix + nodes[i].name;
        }
      }
    } else {
      // Clone any simple #text nodes.
      newNodes[i] = nodes[i].cloneNode(true);
    }

    // If the current node has children, process them as well.
    if (nodes[i].childNodes.length > 0) {
      var newChildNodes = cloneFormNodes(nodes[i].childNodes, prefix);
      for (var childNodeIndex = 0, size = newChildNodes.length; childNodeIndex < size; childNodeIndex++) {
        newNodes[i].appendChild(newChildNodes[childNodeIndex]);
      }
    }
  }
  return newNodes;
}

var Template = function () {

  /**
   * Represents a template instance of the form to be replicated.
   * @constructor
   * @param {object} baseObject - The DOM object containing the form objects to
   * be templated.
   * @param {string} prefix - The prefix to set on all field names.
   */
  function Template(args) {
    var _this = this;

    _classCallCheck(this, Template);

    var baseObject = args.baseObject;
    this.nodes = new Array();
    this.prefix = args.prefix;
    this.currentIteration = args.iteration || 0;
    this.classList = [];
    this.removeButton = args.removeButton || undefined;
    this.removeButtonContainer = args.removeButtonContainer || undefined;

    // Build a list of classes to be used on instanaces of the template.
    for (var i = 0; i < baseObject.classList.length; i++) {
      this.classList.push(baseObject.classList[i]);
    }

    // Create a template list of nodes from the nodes in the baseObject and
    // remove the original nodes.
    Array.from(baseObject.childNodes).forEach(function (node, nodeIndex, listObj) {
      _this.nodes.push(node.cloneNode(true));
      baseObject.removeChild(node);
    }, this);
  }

  /**
   * Creates a new instance from the template.
   * @return {object} A div element containing a clone of the nodes in this
   * template.
   */


  _createClass(Template, [{
    key: 'instance',
    value: function instance() {
      var instanceContainer = document.createElement('div');
      var removeButton = this.removeButton || document.createElement('div');
      var instance_prefix = this.prefix + "_" + this.currentIteration.toString() + "-";
      var nodes = cloneFormNodes(this.nodes, instance_prefix);

      // Add each class from the template to the new instance.
      for (var classIndex in this.classList) {
        instanceContainer.classList.add(this.classList[classIndex]);
      }

      // Create a button to remove this instance.
      if (this.removeButton) {
        removeButton = this.removeButton.cloneNode(true);
      } else {
        removeButton.innerHTML = 'Remove';
      }

      // Set the removeButton's type only if it's not already set.
      if (!removeButton.getAttribute('type')) {
        removeButton.setAttribute('type', 'button');
      }

      // Add additional classes
      removeButton.classList.add('btn');
      if ($(removeButton).filter("*[class^='btn-']").length == 0) {
        removeButton.classList.add('btn-danger');
      }
      removeButton.classList.add('multiform-remove');

      // Set the item container ID and the remove button data to point to it.
      instanceContainer.id = instance_prefix + 'item_container';
      removeButton.setAttribute('data-itemcontainer', instanceContainer.id);

      // Create a set of nodes and populate the new container.
      for (var node in nodes) {
        instanceContainer.appendChild(nodes[node]);
      }

      var removeButtonContainer = undefined;
      // Append the remove button last.
      if (this.removeButtonContainer) {
        removeButtonContainer = this.removeButtonContainer.cloneNode(true);
        instanceContainer.appendChild(removeButtonContainer);
        removeButtonContainer.appendChild(removeButton);
      } else {
        instanceContainer.appendChild(removeButton);
      }

      // Increment the iteration counter.
      this.currentIteration++;
      $(removeButton).click(function () {
        instanceContainer.parentElement.removeChild(instanceContainer);
      });

      return instanceContainer;
    }
  }]);

  return Template;
}();

/**
 * Represents the container for the multiform instances and controls.
 * @constructor
 * @param {object} containerObject - The DOM object containing multiform.
 */


var multiFormInstance = function () {
  _createClass(multiFormInstance, [{
    key: 'setupControls',
    value: function setupControls() {
      if (this.controlsContainerTemplate) {
        this.controlsContainer = this.controlsContainerTemplate.cloneNode(true);
        this.controlsContainerTemplate.parentElement.removeChild(this.controlsContainerTemplate);
      } else {
        this.controlsContainer = document.createElement('div');
        // Set the controls container's ID to <prefix>-multiform_controls
        this.controlsContainer.setAttribute('id', this.prefix + '-multiform_controls');
      }

      // Locate a template for the add button or create one, then clone and remove
      // the template if it exists inside the container.
      if (this.addButtonTemplate) {
        if ($(this.container).find(this.addButtonTemplate).length) {
          this.addButton = this.addButtonTemplate.cloneNode(true);
          this.controlsContainer.appendChild(this.addButton);
          this.container.removeChild(this.addButtonTemplate);
        } else {
          this.addButton = this.addButtonTemplate;
        }
      } else {
        this.addButton = document.createElement('div');
        this.addButton.innerHTML = 'Add';
        this.controlsContainer.appendChild(this.addButton);
      }

      // Add btn class
      this.addButton.classList.add('btn');
      // Only add btn-success if another type of button hasn't been set
      if ($(this.addButton).filter("*[class^='btn-']").length == 0) {
        this.addButton.classList.add('btn-success');
      }
      // Set the controls container's ID to <prefix>-multiform_add
      this.addButton.setAttribute('id', this.prefix + '-multiform_add');
      // Set the removeButton's type only if it's not already set.
      if (!this.addButton.getAttribute('type')) {
        this.addButton.setAttribute('type', 'button');
      }
    }
  }, {
    key: 'setupRemoveButton',
    value: function setupRemoveButton() {
      // Clone the remove button template and remove the original
      // Clone remove button from template or create remove button, then
      if (this.removeButtonTemplate && this.removeButtonContainerTemplate) {
        this.removeButtonContainerTemplate.removeChild(this.removeButtonTemplate);
        this.removeButtonContainerTemplate.parentElement.removeChild(this.removeButtonContainerTemplate);
        this.removeButton = this.removeButtonTemplate;
        this.removeButtonContainer = this.removeButtonContainerTemplate;
      } else if (this.removeButtonContainerTemplate) {
        this.removeButton = document.createElement('div');
        this.removeButton.innerHTML = 'Remove';
        removeButtonContainerTemplate.removeChild(this.removeButtonTemplate);
      } else if (this.removeButtonTemplate) {
        this.removeButton = this.removeButtonTemplate.cloneNode(true);
        this.container.removeChild(this.removeButtonTemplate);
      } else {
        this.removeButton = document.createElement('div');
        this.removeButton.innerHTML = 'Remove';
      }

      this.removeButton.classList.add(this.prefix + '-multiform_remove');
    }
  }]);

  function multiFormInstance(container, args) {
    var _this2 = this;

    _classCallCheck(this, multiFormInstance);

    this.container = container;
    this.prefix = $(this.container).data('prefix');
    this.controlsContainerTemplate = $('#' + this.prefix + '-multiform_controls')[0];
    this.controlsContainer = undefined;
    this.addButtonTemplate = $('#' + this.prefix + '-add_button')[0] || undefined;
    this.addButton = undefined;
    this.removeButton = undefined;
    this.removeButtonContainerTemplate = $(this.container).children('.remove-container')[0] || undefined;
    this.removeButtonTemplate = $(this.removeButtonContainerTemplate || this.container).children('.remove-button')[0] || undefined;
    this.items = new Array();
    var items = $('.' + this.prefix + '-multiform_item');
    this.postAddFunction = undefined;
    if (args) {
      this.postAddFunction = args.postAddFunction;
    }

    this.setupControls();
    this.setupRemoveButton();

    // Create a template object from container with remaining elements
    this.template = new Template({
      baseObject: this.container,
      prefix: this.prefix,
      removeButton: this.removeButton,
      removeButtonContainer: this.removeButtonContainer
    });

    // Add controls container before items
    this.container.appendChild(this.controlsContainer);

    // Build the list of items generated from items with a class of
    // <prefix>-multiform_item
    this.addItem = function (index, item) {
      _this2.items[index] = new Template({
        baseObject: item,
        prefix: _this2.prefix,
        removeButton: _this2.removeButton,
        removeButtonContainer: _this2.removeButtonContainer,
        iteration: index
      }).instance();
      _this2.container.appendChild(_this2.items[index]);
      item.parentElement.removeChild(item);
    };
    items.each(this.addItem, this);

    // Start new item itterations after the prepopulated items.
    this.template.currentIteration = items.length;

    // Create an instance of the template to start the form.
    this.container.appendChild(this.template.instance());

    // When the add button is clicked create an instance of the template and
    // append it to the container.
    $("#" + this.prefix + "-multiform_add").click(function () {
      _this2.container.appendChild(_this2.template.instance());

      if (_this2.postAddFunction) {
        _this2.postAddFunction();
      }
    });
    if (args) {
      // Remove all classes from the container.
      for (var i = 0; i < this.container.classList.length + 1; i++) {
        this.container.classList.remove(this.container.classList[this.container.classList.length - 1]);
      }
      // Add specified classes to the container.
      this.container.classList.add(args.containerClassList);
    }
  }

  return multiFormInstance;
}();

var multiForm = {};

(function ($) {
  multiForm.forms = {};

  /**
   * Build a template for a multi-record form from a jQuery selector.
   * @param {function} func - An optional function to be called on add button
   * click and after the appendChild completes.
   */
  $.fn.multiFormTemplate = function (args) {
    // Iterate each template
    this.each(function () {
      var template_prefix = $(this).data('prefix');

      // Create the container for all form entries.
      multiForm.forms[template_prefix] = new multiFormInstance(this, args);
    });
  };
})(jQuery);
