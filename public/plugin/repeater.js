jQuery.fn.extend({
    createRepeater: function(options = {}) {
	var hasOption = function (optionKey) {
            return options.hasOwnProperty(optionKey);
        };

        var option = function (optionKey) {
            return options[optionKey];
        };

    var addItem = function (items, key, fresh = option('classRepeat')) {
            var itemContent = items;
            var item = itemContent;
            var input = item.find('input,select');



            input.each(function (index, el) {
                var attrName = $(el).data('name');
                $(el).attr("name", attrName + "[" + key + "]" );
                if (fresh === true) {
                    $(el).attr('value', '');
                //    console.log('APAGOU');
                }
            })
            var itemClone = items;

            /* Handling remove btn */
            if (hasOption('classBtnRemove') && option('classBtnRemove') != '') {
                var tmpRemoveButton = option('classBtnRemove');
            }else{
                var tmpRemoveButton = '.remove-btn';
            }

            var removeButton = itemClone.find(tmpRemoveButton);

            if (key == 0) {
                removeButton.attr('disabled', true);
            } else {
                removeButton.attr('disabled', false);
            }

            if (hasOption('afterRemove') && option('afterRemove') != '') {
                var afterRemoveFunction = option('afterRemove');
                removeButton.attr('onclick', '$(this).parents(\'.items\').remove();'+afterRemoveFunction);
            }else{
                removeButton.attr('onclick', '$(this).parents(\'.items\').remove();');
            }



            $("<div class='"+items.attr('class')+"'>" + itemClone.html() + "<div/>").appendTo(repeater);

            if (hasOption('afterInsert') && option('afterInsert') != '') {
                var afterInsertFunction = option('afterInsert');
                afterInsertFunction();
            }


        };

        /* find elements */
        var repeater = this;

        if (hasOption('classRepeat') && option('classRepeat') != '') {
            var tmpItems = option('classRepeat');
        }else{
            var tmpItems = ".items";
        }

        var items = repeater.find(tmpItems);

        var key = 0;

        if (hasOption('classBtnAdd') && option('classBtnAdd') != '') {
            var tmpAddButton = option('classBtnAdd');
        }else{
            var tmpAddButton = ".repeater-add-btn";
        }

        var addButton = $(tmpAddButton);

        items.each(function (index, item) {
            items.remove();
            if (hasOption('showFirstItemToDefault') && option('showFirstItemToDefault') == true) {
                addItem($(item), key);
                key++;
            } else {
                if (items.length > 1) {
                    addItem($(item), key);
                    key++;
                }
            }
        });


        /* handle click and add items */
        addButton.on("click", function () {
            addItem($(items[0]), key,true);
            key++;
        });


    }
});
