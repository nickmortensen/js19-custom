/**
 * Custom CMB2 Swithc Field Javascript.
 * Enabling the click event will make this feel like it is a switch button.

 * @author Nick Mortensen
 * @package js19-custom
 * @license GPL-2.0+
 * @since 5.0.1
 * @link https://www.proy.info/how-to-create-cmb2-switch-field/
 */

window.CMB2 = (function(window, document, $, undefined){
	'use strict';
	$(".cmb2-enable").click(function(){
        var parent = $(this).parents('.cmb2-switch');
        $('.cmb2-disable',parent).removeClass('selected');
        $(this).addClass('selected');
    });
    $(".cmb2-disable").click(function(){
        var parent = $(this).parents('.cmb2-switch');
        $('.cmb2-enable',parent).removeClass('selected');
        $(this).addClass('selected');
    });
})(window, document, jQuery);