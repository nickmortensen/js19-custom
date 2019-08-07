/**
 * Controls the behaviours of custom metabox fields.
 *
 * @author CMB2 team
 * @see    https://github.com/CMB2/CMB2
 */

// TODO: fix this.
// JQMIGRATE: jQuery.fn.attr('value') no longer gets properties

/**
 * Custom jQuery for Custom Metaboxes and Fields
 */
window.CMB2 = window.CMB2 || {};
(function (window, document, $, cmb, undefined) {
  

  // localization strings
  let l10n = window.cmb2_l10;
  let {setTimeout} = window;
  let $document;
  let $id = function (selector) {
    return $(document.getElementById(selector));
  };
  let defaults = {
    idNumber: false,
    repeatEls: 'input:not([type="button"],[id^=filelist]),select,textarea,.cmb2-media-status',
    noEmpty: 'input:not([type="button"]):not([type="radio"]):not([type="checkbox"]),textarea',
    repeatUpdate: 'input:not([type="button"]),select,textarea,label',
    styleBreakPoint: 450,
    mediaHandlers: {},
    defaults: {
      time_picker: l10n.defaults.time_picker,
      date_picker: l10n.defaults.date_picker,
      color_picker: l10n.defaults.color_picker || {},
    },
    media: {
      frames: {},
    },
  };

  cmb.metabox = function () {
    if (cmb.$metabox) {
      return cmb.$metabox;
    }
    cmb.$metabox = $('.cmb2-wrap > .cmb2-metabox');
    return cmb.$metabox;
  };

  cmb.init = function () {
    $document = $(document);

    // Setup the CMB2 object defaults.
    $.extend(cmb, defaults);

    cmb.trigger('cmb_pre_init');

    let $metabox = cmb.metabox();
    let $repeatGroup = $metabox.find('.cmb-repeatable-group');

    /**
     * Initialize time/date/color pickers
     */
    cmb.initPickers($metabox.find('input[type="text"].cmb2-timepicker'), $metabox.find('input[type="text"].cmb2-datepicker'), $metabox.find('input[type="text"].cmb2-colorpicker'));

    // Insert toggle button into DOM wherever there is multicheck. credit: Genesis Framework
    $(`<p><span class="button-secondary cmb-multicheck-toggle">${  l10n.strings.check_toggle  }</span></p>`).insertBefore('.cmb2-checkbox-list:not(.no-select-all)');

    // Make File List drag/drop sortable:
    cmb.makeListSortable();

    $metabox
      .on('change', '.cmb2_upload_file', function () {
        cmb.media.field = $(this).attr('id');
        $id(`${cmb.media.field  }_id`).val('');
      })
      // Media/file management
      .on('click', '.cmb-multicheck-toggle', cmb.toggleCheckBoxes)
      .on('click', '.cmb2-upload-button', cmb.handleMedia)
      .on('click', '.cmb-attach-list li, .cmb2-media-status .img-status img, .cmb2-media-status .file-status > span', cmb.handleFileClick)
      .on('click', '.cmb2-remove-file-button', cmb.handleRemoveMedia)
      // Repeatable content
      .on('click', '.cmb-add-group-row', cmb.addGroupRow)
      .on('click', '.cmb-add-row-button', cmb.addAjaxRow)
      .on('click', '.cmb-remove-group-row', cmb.removeGroupRow)
      .on('click', '.cmb-remove-row-button', cmb.removeAjaxRow)
      // Ajax oEmbed display
      .on('keyup paste focusout', '.cmb2-oembed', cmb.maybeOembed)
      // Reset titles when removing a row
      .on('cmb2_remove_row', '.cmb-repeatable-group', cmb.resetTitlesAndIterator)
      .on('click', '.cmbhandle, .cmbhandle + .cmbhandle-title', cmb.toggleHandle);

    if ($repeatGroup.length) {
      $repeatGroup
        .filter('.sortable').each(function () {
          // Add sorting arrows
          $(this).find('.cmb-remove-group-row-button').before(`<a class="button-secondary cmb-shift-rows move-up alignleft" href="#"><span class="${  l10n.up_arrow_class  }"></span></a> <a class="button-secondary cmb-shift-rows move-down alignleft" href="#"><span class="${  l10n.down_arrow_class  }"></span></a>`);
        })
        .on('click', '.cmb-shift-rows', cmb.shiftRows)
        .on('cmb2_add_row', cmb.emptyValue);
    }

    // on pageload
    setTimeout(cmb.resizeoEmbeds, 500);
    // and on window resize
    $(window).on('resize', cmb.resizeoEmbeds);

    cmb.trigger('cmb_init');
  };

  cmb.resetTitlesAndIterator = function (evt) {
    if (!evt.group) {
      return;
    }

    // Loop repeatable group tables
    $('.cmb-repeatable-group.repeatable').each(function () {
      let $table = $(this);
      let groupTitle = $table.find('.cmb-add-group-row').data('grouptitle');

      // Loop repeatable group table rows
      $table.find('.cmb-repeatable-grouping').each(function (rowindex) {
        let $row = $(this);
        let $rowTitle = $row.find('h3.cmb-group-title');
        // Reset rows iterator
        $row.data('iterator', rowindex);
        // Reset rows title
        if ($rowTitle.length) {
          $rowTitle.text(groupTitle.replace('{#}', (rowindex + 1)));
        }
      });
    });
  };

  cmb.toggleHandle = function (evt) {
    evt.preventDefault();
    cmb.trigger('postbox-toggled', $(this).parent('.postbox').toggleClass('closed'));
  };

  cmb.toggleCheckBoxes = function (evt) {
    evt.preventDefault();
    let $this = $(this);
    let $multicheck = $this.closest('.cmb-td').find('input[type=checkbox]:not([disabled])');

    // If the button has already been clicked once...
    if ($this.data('checked')) {
      // clear the checkboxes and remove the flag
      $multicheck.prop('checked', false);
      $this.data('checked', false);
    }
    // Otherwise mark the checkboxes and add a flag
    else {
      $multicheck.prop('checked', true);
      $this.data('checked', true);
    }
  };

  cmb.handleMedia = function (evt) {
    evt.preventDefault();

    let $el = $(this);
    cmb.attach_id = !$el.hasClass('cmb2-upload-list') ? $el.closest('.cmb-td').find('.cmb2-upload-file-id').val() : false;
    // Clean up default 0 value
    cmb.attach_id = cmb.attach_id !== '0' ? cmb.attach_id : false;

    cmb._handleMedia($el.prev('input.cmb2-upload-file').attr('id'), $el.hasClass('cmb2-upload-list'));
  };

  cmb.handleFileClick = function (evt) {
    evt.preventDefault();

    let $el = $(this);
    let $td = $el.closest('.cmb-td');
    let isList = $td.find('.cmb2-upload-button').hasClass('cmb2-upload-list');
    cmb.attach_id = isList ? $el.find('input[type="hidden"]').data('id') : $td.find('.cmb2-upload-file-id').val();

    if (cmb.attach_id) {
      cmb._handleMedia($td.find('input.cmb2-upload-file').attr('id'), isList, cmb.attach_id);
    }
  };

  cmb._handleMedia = function (id, isList) {
    if (!wp) {
      return;
    }

    let media; var 
handlers;

    handlers = cmb.mediaHandlers;
    media = cmb.media;
    media.field = id;
    media.$field = $id(media.field);
    media.fieldData = media.$field.data();
    media.previewSize = media.fieldData.previewsize;
    media.sizeName = media.fieldData.sizename;
    media.fieldName = media.$field.attr('name');
    media.isList = isList;

    // If this field's media frame already exists, reopen it.
    if (id in media.frames) {
      return media.frames[id].open();
    }

    // Create the media frame.
    media.frames[id] = wp.media({
      title: cmb.metabox().find(`label[for="${  id  }"]`).text(),
      library: media.fieldData.queryargs || {},
      button: {
        text: l10n.strings[isList ? 'upload_files' : 'upload_file'],
      },
      multiple: isList ? 'add' : false,
    });

    // Enable the additional media filters: https://github.com/CMB2/CMB2/issues/873
    media.frames[id].states.first().set('filterable', 'all');

    cmb.trigger('cmb_media_modal_init', media);

    handlers.list = function (selection, returnIt) {
      // Setup our fileGroup array
      let fileGroup = [];
      let attachmentHtml;

      if (!handlers.list.templates) {
        handlers.list.templates = {
          image: wp.template('cmb2-list-image'),
          file: wp.template('cmb2-list-file'),
        };
      }

      // Loop through each attachment
      selection.each((attachment) => {

        // Image preview or standard generic output if it's not an image.
        attachmentHtml = handlers.getAttachmentHtml(attachment, 'list');

        // Add our file to our fileGroup array
        fileGroup.push(attachmentHtml);
      });

      if (!returnIt) {
        // Append each item from our fileGroup array to .cmb2-media-status
        media.$field.siblings('.cmb2-media-status').append(fileGroup);
      } else {
        return fileGroup;
      }
    };

    handlers.single = function (selection) {
      if (!handlers.single.templates) {
        handlers.single.templates = {
          image: wp.template('cmb2-single-image'),
          file: wp.template('cmb2-single-file'),
        };
      }

      // Only get one file from the uploader
      let attachment = selection.first();

      media.$field.val(attachment.get('url'));
      $id(`${media.field  }_id`).val(attachment.get('id'));

      // Image preview or standard generic output if it's not an image.
      let attachmentHtml = handlers.getAttachmentHtml(attachment, 'single');

      // add/display our output
      media.$field.siblings('.cmb2-media-status').slideDown().html(attachmentHtml);
    };

    handlers.getAttachmentHtml = function (attachment, templatesId) {
      let isImage = attachment.get('type') === 'image';
      let data = handlers.prepareData(attachment, isImage);

      // Image preview or standard generic output if it's not an image.
      return handlers[templatesId].templates[isImage ? 'image' : 'file'](data);
    };

    handlers.prepareData = function (data, image) {
      if (image) {
        // Set the correct image size data
        handlers.getImageData.call(data, 50);
      }

      data = data.toJSON();
      data.mediaField = media.field;
      data.mediaFieldName = media.fieldName;
      data.stringRemoveImage = l10n.strings.remove_image;
      data.stringFile = l10n.strings.file;
      data.stringDownload = l10n.strings.download;
      data.stringRemoveFile = l10n.strings.remove_file;

      return data;
    };

    handlers.getImageData = function (fallbackSize) {
      // Preview size dimensions
      let previewW = media.previewSize[0] || fallbackSize;
      let previewH = media.previewSize[1] || fallbackSize;

      // Image dimensions and url
      let url = this.get('url');
      let width = this.get('width');
      let height = this.get('height');
      let sizes = this.get('sizes');

      // Get the correct dimensions and url if a named size is set and exists
      // fallback to the 'large' size
      if (sizes) {
        if (sizes[media.sizeName]) {
          url = sizes[media.sizeName].url;
          width = sizes[media.sizeName].width;
          height = sizes[media.sizeName].height;
        } else if (sizes.large) {
          url = sizes.large.url;
          width = sizes.large.width;
          height = sizes.large.height;
        }
      }

      // Fit the image in to the preview size, keeping the correct aspect ratio
      if (width > previewW) {
        height = Math.floor(previewW * height / width);
        width = previewW;
      }

      if (height > previewH) {
        width = Math.floor(previewH * width / height);
        height = previewH;
      }

      if (!width) {
        width = previewW;
      }

      if (!height) {
        height = this.get('filename').split('.').pop() === 'svg' ? '100%' : previewH;
      }

      this.set('sizeUrl', url);
      this.set('sizeWidth', width);
      this.set('sizeHeight', height);

      return this;
    };

    handlers.selectFile = function () {
      let selection = media.frames[id].state().get('selection');
      let type = isList ? 'list' : 'single';

      if (cmb.attach_id && isList) {
        $(`[data-id="${  cmb.attach_id  }"]`).parents('li').replaceWith(handlers.list(selection, true));
      } else {
        handlers[type](selection);
      }

      cmb.trigger('cmb_media_modal_select', selection, media);
    };

    handlers.openModal = function () {
      let selection = media.frames[id].state().get('selection');
      let attach;

      if (!cmb.attach_id) {
        selection.reset();
      } else {
        attach = wp.media.attachment(cmb.attach_id);
        attach.fetch();
        selection.set(attach ? [attach] : []);
      }

      cmb.trigger('cmb_media_modal_open', selection, media);
    };

    // When a file is selected, run a callback.
    media.frames[id]
      .on('select', handlers.selectFile)
      .on('open', handlers.openModal);

    // Finally, open the modal
    media.frames[id].open();
  };

  cmb.handleRemoveMedia = function (evt) {
    evt.preventDefault();
    let $this = $(this);
    if ($this.is('.cmb-attach-list .cmb2-remove-file-button')) {
      $this.parents('.cmb2-media-item').remove();
      return false;
    }

    cmb.media.field = $this.attr('rel');

    cmb.metabox().find(`input#${  cmb.media.field}`).val('');
    cmb.metabox().find(`input#${  cmb.media.field  }_id`).val('');
    $this.parents('.cmb2-media-status').html('');

    return false;
  };

  cmb.cleanRow = function ($row, prevNum, group) {
    let $elements = $row.find(cmb.repeatUpdate);
    if (group) {
      let $other = $row.find('[id]').not(cmb.repeatUpdate);

      // Remove extra ajaxed rows
      $row.find('.cmb-repeat-table .cmb-repeat-row:not(:first-child)').remove();

      // Update all elements w/ an ID
      if ($other.length) {
        $other.each(function () {
          let $_this = $(this);
          let oldID = $_this.attr('id');
          let newID = oldID.replace(`_${  prevNum}`, `_${  cmb.idNumber}`);
          let $buttons = $row.find(`[data-selector="${  oldID  }"]`);
          $_this.attr('id', newID);

          // Replace data-selector vars
          if ($buttons.length) {
            $buttons.attr('data-selector', newID).data('selector', newID);
          }
        });
      }
    }

    $elements.filter(':checked').prop('checked', false);
    $elements.filter(':selected').prop('selected', false);

    if ($row.find('h3.cmb-group-title').length) {
      $row.find('h3.cmb-group-title').text($row.data('title').replace('{#}', (cmb.idNumber + 1)));
    }

    $elements.each(function () {
      cmb.elReplacements($(this), prevNum);
    });

    return cmb;
  };

  cmb.elReplacements = function ($newInput, prevNum) {
    let oldFor = $newInput.attr('for');
    let oldVal = $newInput.val();
    let type = $newInput.prop('type');
    let checkable = type === 'radio' || type === 'checkbox' ? oldVal : false;
    // var $next  = $newInput.next();
    let attrs = {};
    let newID; var 
oldID;
    if (oldFor) {
      attrs = {
        for: oldFor.replace(`_${  prevNum}`, `_${  cmb.idNumber}`),
      };
    } else {
      let oldName = $newInput.attr('name');
      // Replace 'name' attribute key
      let newName = oldName ? oldName.replace(`[${  prevNum  }]`, `[${  cmb.idNumber  }]`) : '';
      oldID = $newInput.attr('id');
      newID = oldID ? oldID.replace(`_${  prevNum}`, `_${  cmb.idNumber}`) : '';
      attrs = {
        id: newID,
        name: newName,
        // value: '',
        'data-iterator': cmb.idNumber,
      };
    }

    // Clear out old values
    if (undefined !== typeof (oldVal) && oldVal || checkable) {
      attrs.value = checkable || '';
    }

    // Clear out textarea values
    if ($newInput.prop('tagName') === 'TEXTAREA') {
      $newInput.html('');
    }

    if (checkable) {
      $newInput.removeAttr('checked');
    }

    $newInput
      .removeClass('hasDatepicker')
      .attr(attrs).val(checkable || '');

    return $newInput;
  };

  cmb.newRowHousekeeping = function ($row) {
    let $colorPicker = $row.find('.wp-picker-container');
    let $list = $row.find('.cmb2-media-status');

    if ($colorPicker.length) {
      // Need to clean-up colorpicker before appending
      $colorPicker.each(function () {
        let $td = $(this).parent();
        $td.html($td.find('input[type="text"].cmb2-colorpicker').attr('style', ''));
      });
    }

    // Need to clean-up colorpicker before appending
    if ($list.length) {
      $list.empty();
    }

    return cmb;
  };

  cmb.afterRowInsert = function ($row) {
    // Init pickers from new row
    cmb.initPickers($row.find('input[type="text"].cmb2-timepicker'), $row.find('input[type="text"].cmb2-datepicker'), $row.find('input[type="text"].cmb2-colorpicker'));
  };

  cmb.updateNameAttr = function () {
    let $this = $(this);
    let name = $this.attr('name'); // get current name

    // If name is defined
    if (typeof name !== 'undefined') {
      let prevNum = parseInt($this.parents('.cmb-repeatable-grouping').data('iterator'), 10);
      let newNum = prevNum - 1; // Subtract 1 to get new iterator number

      // Update field name attributes so data is not orphaned when a row is removed and post is saved
      let $newName = name.replace(`[${  prevNum  }]`, `[${  newNum  }]`);

      // New name with replaced iterator
      $this.attr('name', $newName);
    }
  };

  cmb.emptyValue = function (evt, row) {
    $(cmb.noEmpty, row).val('');
  };

  cmb.addGroupRow = function (evt) {
    evt.preventDefault();

    let $this = $(this);

    // before anything significant happens
    cmb.triggerElement($this, 'cmb2_add_group_row_start', $this);

    let $table = $id($this.data('selector'));
    let $oldRow = $table.find('.cmb-repeatable-grouping').last();
    let prevNum = parseInt($oldRow.data('iterator'), 10);
    cmb.idNumber = parseInt(prevNum, 10) + 1;
    let $row = $oldRow.clone();

    // Make sure the next number doesn't exist.
    while ($table.find(`.cmb-repeatable-grouping[data-iterator="${  cmb.idNumber  }"]`).length > 0) {
      cmb.idNumber++;
    }

    cmb.newRowHousekeeping($row.data('title', $this.data('grouptitle'))).cleanRow($row, prevNum, true);
    $row.find('.cmb-add-row-button').prop('disabled', false);

    let $newRow = $(`<div class="postbox cmb-row cmb-repeatable-grouping" data-iterator="${  cmb.idNumber  }">${  $row.html()  }</div>`);
    $oldRow.after($newRow);

    cmb.afterRowInsert($newRow);

    if ($table.find('.cmb-repeatable-grouping').length <= 1) {
      $table.find('.cmb-remove-group-row').prop('disabled', true);
    } else {
      $table.find('.cmb-remove-group-row').prop('disabled', false);
    }

    cmb.triggerElement($table, {
      type: 'cmb2_add_row',
      group: true,
    }, $newRow);
  };

  cmb.addAjaxRow = function (evt) {
    evt.preventDefault();

    let $this = $(this);
    let $table = $id($this.data('selector'));
    let $emptyrow = $table.find('.empty-row');
    let prevNum = parseInt($emptyrow.find('[data-iterator]').data('iterator'), 10);
    cmb.idNumber = parseInt(prevNum, 10) + 1;
    let $row = $emptyrow.clone();

    cmb.newRowHousekeeping($row).cleanRow($row, prevNum);

    $emptyrow.removeClass('empty-row hidden').addClass('cmb-repeat-row');
    $emptyrow.after($row);

    cmb.afterRowInsert($row);

    cmb.triggerElement($table, {
      type: 'cmb2_add_row',
      group: false,
    }, $row);

    $table.find('.cmb-remove-row-button').removeClass('button-disabled');
  };

  cmb.removeGroupRow = function (evt) {
    evt.preventDefault();

    let $this = $(this);
    let $table = $id($this.data('selector'));
    let $parent = $this.parents('.cmb-repeatable-grouping');
    let number = $table.find('.cmb-repeatable-grouping').length;

    // Needs to always be at least one group.
    if (number < 2) {
      return;
    }

    cmb.triggerElement($table, 'cmb2_remove_group_row_start', $this);

    // when a group is removed loop through all next groups and update fields names
    $parent.nextAll('.cmb-repeatable-grouping').find(cmb.repeatEls).each(cmb.updateNameAttr);

    $parent.remove();

    if (number <= 2) {
      $table.find('.cmb-remove-group-row').prop('disabled', true);
    } else {
      $table.find('.cmb-remove-group-row').prop('disabled', false);
    }

    cmb.triggerElement($table, {
      type: 'cmb2_remove_row',
      group: true,
    });
  };

  cmb.removeAjaxRow = function (evt) {
    evt.preventDefault();

    let $this = $(this);

    // Check if disabled
    if ($this.hasClass('button-disabled')) {
      return;
    }

    let $parent = $this.parents('.cmb-row');
    let $table = $this.parents('.cmb-repeat-table');
    let number = $table.find('.cmb-row').length;

    if (number > 2) {
      if ($parent.hasClass('empty-row')) {
        $parent.prev().addClass('empty-row').removeClass('cmb-repeat-row');
      }
      $this.parents('.cmb-repeat-table .cmb-row').remove();
      if (number === 3) {
        $table.find('.cmb-remove-row-button').addClass('button-disabled');
      }

      cmb.triggerElement($table, {
        type: 'cmb2_remove_row',
        group: false,
      });
    } else {
      $this.addClass('button-disabled');
    }
  };

  cmb.shiftRows = function (evt) {
    evt.preventDefault();

    let $this = $(this);
    let $from = $this.parents('.cmb-repeatable-grouping');
    let $goto = $this.hasClass('move-up') ? $from.prev('.cmb-repeatable-grouping') : $from.next('.cmb-repeatable-grouping');

    // Before shift occurs.
    cmb.triggerElement($this, 'cmb2_shift_rows_enter', $this, $from, $goto);

    if (!$goto.length) {
      return;
    }

    // About to shift
    cmb.triggerElement($this, 'cmb2_shift_rows_start', $this, $from, $goto);

    let inputVals = [];
    // Loop this item's fields
    $from.find(cmb.repeatEls).each(function () {
      let $element = $(this);
      let elType = $element.attr('type');
      let val;

      if ($element.hasClass('cmb2-media-status')) {
        // special case for image previews
        val = $element.html();
      } else if (elType === 'checkbox' || elType === 'radio') {
        val = $element.is(':checked');
      } else if ($element.prop('tagName') === 'select') {
        val = $element.is(':selected');
      } else {
        val = $element.val();
      }

      // Get all the current values per element
      inputVals.push({
        val,
        $: $element,
      });
    });
    // And swap them all
    $goto.find(cmb.repeatEls).each(function (index) {
      let $element = $(this);
      let elType = $element.attr('type');
      let val;

      if ($element.hasClass('cmb2-media-status')) {
        let toRowId = $element.closest('.cmb-repeatable-grouping').attr('data-iterator');
        let fromRowId = inputVals[index].$.closest('.cmb-repeatable-grouping').attr('data-iterator');

        // special case for image previews
        val = $element.html();
        $element.html(inputVals[index].val);
        inputVals[index].$.html(val);

        inputVals[index].$.find('input').each(function () {
          let name = $(this).attr('name');
          name = name.replace(`[${  toRowId  }]`, `[${  fromRowId  }]`);
          $(this).attr('name', name);
        });
        $element.find('input').each(function () {
          let name = $(this).attr('name');
          name = name.replace(`[${  fromRowId  }]`, `[${  toRowId  }]`);
          $(this).attr('name', name);
        });
      }
      // handle checkbox swapping
      else if (elType === 'checkbox') {
        inputVals[index].$.prop('checked', $element.is(':checked'));
        $element.prop('checked', inputVals[index].val);
      }
      // handle radio swapping
      else if (elType === 'radio') {
        if ($element.is(':checked')) {
          inputVals[index].$.attr('data-checked', 'true');
        }
        if (inputVals[index].$.is(':checked')) {
          $element.attr('data-checked', 'true');
        }
      }
      // handle select swapping
      else if ($element.prop('tagName') === 'select') {
        inputVals[index].$.prop('selected', $element.is(':selected'));
        $element.prop('selected', inputVals[index].val);
      }
      // handle normal input swapping
      else {
        inputVals[index].$.val($element.val());
        $element.val(inputVals[index].val);
      }
    });

    $from.find('input[data-checked=true]').prop('checked', true).removeAttr('data-checked');
    $goto.find('input[data-checked=true]').prop('checked', true).removeAttr('data-checked');

    // trigger color picker change event
    $from.find('input[type="text"].cmb2-colorpicker').trigger('change');
    $goto.find('input[type="text"].cmb2-colorpicker').trigger('change');

    // shift done
    cmb.triggerElement($this, 'cmb2_shift_rows_complete', $this, $from, $goto);
  };

  cmb.initPickers = function ($timePickers, $datePickers, $colorPickers) {
    // Initialize jQuery UI timepickers
    cmb.initDateTimePickers($timePickers, 'timepicker', 'time_picker');
    // Initialize jQuery UI datepickers
    cmb.initDateTimePickers($datePickers, 'datepicker', 'date_picker');
    // Initialize color picker
    cmb.initColorPickers($colorPickers);
  };

  cmb.initDateTimePickers = function ($selector, method, defaultKey) {
    if ($selector.length) {
      $selector[method]('destroy').each(function () {
        let $this = $(this);
        let fieldOpts = $this.data(method) || {};
        let options = $.extend({}, cmb.defaults[defaultKey], fieldOpts);
        $this[method](cmb.datePickerSetupOpts(fieldOpts, options, method));
      });
    }
  };

  cmb.datePickerSetupOpts = function (fieldOpts, options, method) {
    let existing = $.extend({}, options);

    options.beforeShow = function (input, inst) {
      if (method === 'timepicker') {
        cmb.addTimePickerClasses(inst.dpDiv);
      }

      // Wrap datepicker w/ class to narrow the scope of jQuery UI CSS and prevent conflicts
      $id('ui-datepicker-div').addClass('cmb2-element');

      // Let's be sure to call beforeShow if it was added
      if (typeof existing.beforeShow === 'function') {
        existing.beforeShow(input, inst);
      }
    };

    if (method === 'timepicker') {
      options.onChangeMonthYear = function (year, month, inst, picker) {
        cmb.addTimePickerClasses(inst.dpDiv);

        // Let's be sure to call onChangeMonthYear if it was added
        if (typeof existing.onChangeMonthYear === 'function') {
          existing.onChangeMonthYear(year, month, inst, picker);
        }
      };
    }

    options.onClose = function (dateText, inst) {
      // Remove the class when we're done with it (and hide to remove FOUC).
      $id('ui-datepicker-div').removeClass('cmb2-element').hide();

      // Let's be sure to call onClose if it was added
      if (typeof existing.onClose === 'function') {
        existing.onClose(dateText, inst);
      }
    };

    return options;
  };

  // Adds classes to timepicker buttons.
  cmb.addTimePickerClasses = function ($picker) {
    let func = cmb.addTimePickerClasses;
    func.count = func.count || 0;

    // Wait a bit to let the timepicker render, since these are pre-render events.
    setTimeout(() => {
      if ($picker.find('.ui-priority-secondary').length) {
        $picker.find('.ui-priority-secondary').addClass('button-secondary');
        $picker.find('.ui-priority-primary').addClass('button-primary');
        func.count = 0;
      } else if (func.count < 5) {
        func.count++;
        func($picker);
      }
    }, 10);
  };

  cmb.initColorPickers = function ($selector) {
    if (!$selector.length) {
      return;
    }
    if (typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function') {
      $selector.each(function () {
        let $this = $(this);
        let fieldOpts = $this.data('colorpicker') || {};
        $this.wpColorPicker($.extend({}, cmb.defaults.color_picker, fieldOpts));
      });
    } else {
      $selector.each(function (i) {
        $(this).after(`<div id="picker-${  i  }" style="z-index: 1000; background: #EEE; border: 1px solid #CCC; position: absolute; display: block;"></div>`);
        $id(`picker-${  i}`).hide().farbtastic($(this));
      })
        .focus(function () {
          $(this).next().show();
        })
        .blur(function () {
          $(this).next().hide();
        });
    }
  };

  cmb.makeListSortable = function () {
    let $filelist = cmb.metabox().find('.cmb2-media-status.cmb-attach-list');
    if ($filelist.length) {
      $filelist.sortable({
        cursor: 'move',
      }).disableSelection();
    }
  };

  cmb.maybeOembed = function (evt) {
    let $this = $(this);

    let m = {
      focusout () {
        setTimeout(function () {
          // if it's been 2 seconds, hide our spinner
          cmb.spinner('.cmb2-metabox', true);
        }, 2000);
      },
      keyup () {
        var betw = function (min, max) {
          return (evt.which <= max && evt.which >= min);
        };
        // Only Ajax on normal keystrokes
        if (betw(48, 90) || betw(96, 111) || betw(8, 9) || evt.which === 187 || evt.which === 190) {
          // fire our ajax function
          cmb.doAjax($this, evt);
        }
      },
      paste () {
        // paste event is fired before the value is filled, so wait a bit
        setTimeout(function () {
          cmb.doAjax($this);
        }, 100);
      },
    };

    m[evt.type]();
  };

  /**
   * Resize oEmbed videos to fit in their respective metaboxes
   */
  cmb.resizeoEmbeds = function () {
    cmb.metabox().each(function () {
      let $this = $(this);
      let $tableWrap = $this.parents('.inside');
      let isSide = $this.parents('.inner-sidebar').length || $this.parents('#side-sortables').length;
      let isSmall = isSide;
      let isSmallest = false;
      if (!$tableWrap.length) {
        return true; // continue
      }

      // Calculate new width
      let tableW = $tableWrap.width();

      if (cmb.styleBreakPoint > tableW) {
        isSmall = true;
        isSmallest = (cmb.styleBreakPoint - 62) > tableW;
      }

      tableW = isSmall ? tableW : Math.round(($tableWrap.width() * 0.82) * 0.97);
      let newWidth = tableW - 30;
      if (isSmall && !isSide && !isSmallest) {
        newWidth -= 75;
      }
      if (newWidth > 639) {
        return true; // continue
      }

      let $embeds = $this.find('.cmb-type-oembed .embed-status');
      let $children = $embeds.children().not('.cmb2-remove-wrapper');
      if (!$children.length) {
        return true; // continue
      }

      $children.each(function () {
        let $this = $(this);
        let iwidth = $this.width();
        let iheight = $this.height();
        let _newWidth = newWidth;
        if ($this.parents('.cmb-repeat-row').length && !isSmall) {
          // Make room for our repeatable "remove" button column
          _newWidth = newWidth - 91;
          _newWidth = tableW < 785 ? _newWidth - 15 : _newWidth;
        }
        // Calc new height
        let newHeight = Math.round((_newWidth * iheight) / iwidth);
        $this.width(_newWidth).height(newHeight);
      });
    });
  };

  /**
   * Safely log things if query var is set
   * @since  1.0.0
   */
  cmb.log = function () {
    if (l10n.script_debug && console && typeof console.log === 'function') {
      console.log.apply(console, arguments);
    }
  };

  cmb.spinner = function ($context, hide) {
    let m = hide ? 'removeClass' : 'addClass';
    $('.cmb-spinner', $context)[m]('is-active');
  };

  // function for running our ajax
  cmb.doAjax = function ($obj) {
    // get typed value
    let oembed_url = $obj.val();
    // only proceed if the field contains more than 6 characters
    if (oembed_url.length < 6) {
      return;
    }

    // get field id
    let field_id = $obj.attr('id');
    let $context = $obj.closest('.cmb-td');
    let $embed_container = $context.find('.embed-status');
    let $embed_wrap = $context.find('.embed_wrap');
    let $child_el = $embed_container.find(':first-child');
    let oembed_width = $embed_container.length && $child_el.length ? $child_el.width() : $obj.width();

    cmb.log('oembed_url', oembed_url, field_id);

    // show our spinner
    cmb.spinner($context);
    // clear out previous results
    $embed_wrap.html('');
    // and run our ajax function
    setTimeout(() => {
      // if they haven't typed in 500 ms
      if ($('.cmb2-oembed:focus').val() !== oembed_url) {
        return;
      }
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: l10n.ajaxurl,
        data: {
          'action': 'cmb2_oembed_handler',
          'oembed_url': oembed_url,
          'oembed_width': oembed_width > 300 ? oembed_width : 300,
          'field_id': field_id,
          'object_id': $obj.data('objectid'),
          'object_type': $obj.data('objecttype'),
          'cmb2_ajax_nonce': l10n.ajax_nonce
        },
        success: function (response) {
          cmb.log(response);
          // hide our spinner
          cmb.spinner($context, true);
          // and populate our results from ajax response
          $embed_wrap.html(response.data);
        }
      });

    }, 500);
  };

  cmb.trigger = function (evtName) {
    let args = Array.prototype.slice.call(arguments, 1);
    args.push(cmb);
    $document.trigger(evtName, args);
  };

  cmb.triggerElement = function ($el, evtName) {
    let args = Array.prototype.slice.call(arguments, 2);
    args.push(cmb);
    $el.trigger(evtName, args);
  };

  $(cmb.init);
}(window, document, jQuery, window.CMB2));
