(function() {
  // https://stackoverflow.com/questions/31223341/detecting-scroll-direction

  // var header = document.getElementById('header');
  // if(!header) return ;
  // var header_height = header.offsetHeight || header.scrollHeight || header.clientHeight;
  var header_height = 55;

  var lastScrollTop = 0;

  window.addEventListener('scroll', function() {
    var st = window.pageYOffset || document.documentElement.scrollTop; // Credits: "https://github.com/qeremy/so/blob/master/so.dom.js#L426"
    var to_add, to_remove;

    if (st > lastScrollTop && st >= header_height) { // down
      to_add = 'scrolling--down';
      to_remove = 'scrolling--up';
    } else {
      to_add = 'scrolling--up';
      to_remove = 'scrolling--down';
    }

    document.body.classList.add(to_add);
    document.body.classList.remove(to_remove);

    lastScrollTop = st <= 0 ? 0 : st; // For Mobile or negative scrolling
  }, {
    capture: true,
    passive: true
  });
})();
