String.prototype.ucfirst = function() {
  return this.charAt(0).toUpperCase() + this.slice(1);
}

// https://gist.github.com/codeguy/6684588#gistcomment-2624012
String.prototype.slugify = function() {
  var str = this;

  str = str.replace(/^\s+|\s+$/g, ''); // trim
  str = str.toLowerCase();

  // remove accents, swap ñ for n, etc
  var from = "àáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
  var to   = "aaaaaeeeeiiiioooouuuunc------";

  for (var i=0, l=from.length ; i<l ; i++) {
      str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
  }

  str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
      .replace(/\s+/g, '-') // collapse whitespace and replace by -
      .replace(/-+/g, '-'); // collapse dashes

  return str;
}

// https://developer.mozilla.org/en-US/docs/Glossary/Base64
function utf8_to_b64( str ) {
  return window.btoa(unescape(encodeURIComponent( str )));
}

// https://stackoverflow.com/questions/3820381/need-a-basename-function-in-javascript#comment29942319_15270931
function basename(path) {
  return path.split(/[\\/]/).pop();
}

function getUrlForCloudinary(image_url, retina) {
  image_url = image_url
    .replace('https:https:', 'https:')
    .replace('https:/cdn-images', 'https://cdn-images');

  var sizes = retina ? '0x500' : '0x250';

  var server_id = image_url.length % CONFIG.THUMBOR_URLS.length;
  var thumbor_url = CONFIG.THUMBOR_URLS[server_id];

  return '//' + thumbor_url + '/unsafe/' + sizes + '/' + utf8_to_b64(image_url) + '_/' + basename(image_url);
}

// from http://locutus.io/php/strings/number_format/
function number_format(number, decimals, dec_point, thousands_sep) {
  // Strip all characters but numerical ones.
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// from https://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript
function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, '\\$&');
  var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

window.addEventListener('error', function(e) {
  if('IMG' === e.target.nodeName) {
    var that = e.target;
    var original_src = that.getAttribute('data-original-src');

    if(original_src) {
      that.removeAttribute('srcset');
      that.src = original_src;
      that.removeAttribute('data-original-src'); // prevent loops in case original_src returns a 404
    }
  }
}, true);

(function() {
  var items = document.querySelectorAll('a[data-href].link-seo-js'), i;
  for (i = 0; i < items.length; ++i) {
    items[i].href = items[i].dataset.href;
    items[i].setAttribute('rel', 'nofollow');
  }
})();

$(function() {

  $('.nested-list a[disabled]').on('click', function(e) {
    e.preventDefault();
    $(this).siblings('ul').toggleClass('close-sidebar');
  });

});
