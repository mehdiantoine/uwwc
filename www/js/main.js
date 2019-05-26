"use strict";

$(function () {

    /*********************************************************
     *********************** -VARIABLES- *********************
     ********************************************************/

    var btn, menu, url;

    menu = $('#menu');
    btn  = $('.btn-submit');

    /********************************************************
     ********************** -FUNCTIONS- *********************
     *******************************************************/

    var showMenu = function () {
        $('.hidden').toggle();
    };

    // var hideMenu = function () {
    //     $('.menuClickHide').toggle('');
    // }

    var showForm = function () {
        $('.form').slideToggle();
    }

    var showBtn = function () {
        $('.is-showing').slideToggle();
    }

    var rotateArrow = function () {
        $('.fa-arrow-down').toggleClass('rotate-arrow-down');
    }

    /*********************************************************
     ****************** -EVENT LISTENER- *********************
     ********************************************************/


    menu.mouseover(showMenu);
    btn.click(showForm);
    btn.click(rotateArrow);
    btn.click(showBtn);
    // $(document).click(hideMenu);

});
