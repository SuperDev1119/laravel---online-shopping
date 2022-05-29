var Header = function () {
  this.dom = {
    elem: null,
    nav: null,
    menu: null,
    search: {},
    responsiveButton: null
  };

  this.properties = {};
  this.dimensions = {};

  this.is = {};

  return this;
};

Header.prototype.init = function () {
  this.dom.elem = $('.header');
  this.dom.menu = this.dom.elem.find('.header-menu');
  this.dom.responsiveButton = this.dom.elem.find('.header-responsive-button');

  this.dom.searchMobile = this.dom.elem.find('.search-mobile');
  this.dom.searchButton = this.dom.elem.find('.header-search-button');
  this.dom.closeSearchButton = this.dom.elem.find('.search-mobile__close');

  this.dom.searchMobileInput = this.dom.elem.find('.search-mobile__input');

  this.dimensions.width = this.dom.elem.width();
  this.dimensions.height = 0;

  // this.initScroll();
  this.initSearch();

  if (window.matchMedia && window.matchMedia('(max-width: 992px)').matches)
    this.initResponsive();

};

Header.prototype.initScroll = function () {
  var that = this;

  $(window).on('scroll', function () {
    var scroll = $(this).scrollTop();

    if(scroll > that.dimensions.height)
      $('body').addClass('fixed').removeClass('unfixed');
    else
      $('body').addClass('unfixed').removeClass('fixed');
  });

};

Header.prototype.initSearch = function () {
  var that = this;

  this.dom.searchButton.add(this.dom.closeSearchButton)
  .on('click', function () {
    // $('html, body').toggleClass('unscrollable');
    that.dom.searchMobile.toggleClass('search-mobile--opened');
    that.dom.searchMobileInput.focus();
  });
};

Header.prototype.initResponsive = function () {
  var that = this;

  this.dom.responsiveButton.on('click', function (e) {
    e.preventDefault();

    //Disallow scroll when mobile menu is open
    $('body').toggleClass('no-scrollX');

    that.dom.elem.toggleClass('open');
  });

  this.dom.menu.find('li.header-menu-big').on('click', function (e) {
    that.dom.menu.find('.header-menu-big').removeClass('active');
    $(this).addClass('active');
    that.dom.activeMenu = $(this).find('.submenu');
  });

  this.dom.menu.find('.header-menu-big > a:not([data-do-not-prevent-default])').on('click', function (e) {
    e.preventDefault();
  });

  $(this.dom.menu.find('.header-menu-big').get(0)).addClass('active');
  this.dom.activeMenu = $(this.dom.menu.find('.header-menu-big').get(0)).find('.submenu');

};

var header = new Header().init();
