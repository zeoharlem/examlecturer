
$(document).ready(function() {
    $('#fileupload').on('change', function(e){
        var file = $('#files').prop('files')[0];
        //var formData = new formData(this);
        $.ajax({
            url: "http://localhost/examlecturer/results/uploadAjax", // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: new FormData(this),     // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,        // To send DOMDocument or non processed data file it is set to false
            beforeSend: function(){
                $(this).find('.addFile').html('Loading...');
            },
            success: function(data){
                var stringy = $.parseJSON(JSON.stringify(data));
                if(stringy.return){
                    window.alert('File was uploaded into databse');
                    window.location.reload();
                }
                else{
                    window.alert('Unable to upload. Contact Administrator')
                }
            }
        });
    });
    
    $('#startPackage').on('click', function(){
        var session = $('#session option:selected').val();
        var semester = $('#semester option:selected').val();
        var serialForm = $('#packageform').serialize();
        
        bootbox.confirm('Create Module for <strong>session '
                +session+'/semester '+semester+'</strong>', function(result){
            if(result){
                var serials = serialForm + '&session=' + session + '&semester=' + semester;
                $.post('http://localhost/examiner/packages/packageForm', serials, function(data){
                    var stringJson = $.parseJSON(JSON.stringify(data));
                    if(stringJson.status == 'OK'){
                        bootbox.alert("Package for "
                                +stringJson.data['session']
                                +stringJson.data['semester']
                                +stringJson.data['department']
                                +stringJson.data['level'], function(){
                            location.href = window.location.href;
                        })
                    }
                    else{
                        bootbox.alert(stringJson.data)
                    }
                })
            }
        })
    })
    
    //Mark Adjust Function()
    
    //Prevent Douyble form submission plugin
    // jQuery plugin to prevent double submission of forms
    jQuery.fn.preventDoubleSubmission = function () {
        $(this).on('submit', function (e) {
            var $form = $(this);

            if ($form.data('submitted') === true) {
                // Previously submitted - don't submit again
                alert('Form already submitted. Please wait.');
                e.preventDefault();
            } else {
                // Mark it so that the next submit can be ignored
                // ADDED requirement that form be valid
                if($form.valid()) {
                    $form.data('submitted', true);
                }
            }
        });

        // Keep chainability
        return this;
    };
    
    $('form').preventDoubleSubmission();
});
/**
 * @param {string} boxId
 * @param {string} checkBox
 * @returns {undefined}
 */
function checkBox(boxId, checkBox){
    $(boxId).bind('change', function(){
        if($(this).is(':checked')){
            $(checkBox).prop('checked', true);
        }
        else{
            $(checkBox).prop('checked', false);
        }
    })
}

/**
 * @param {type} variable
 * @returns {getQueryVar.pair|Boolean}
 */
function getQueryVar(variable){
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for(var i=0; i<vars.length; i++){
            var pair = vars[i].split("=");
            if(pair[0] == variable){
                return pair[1];
        }
    }
    return(false);
}

/**
 * @param {type} data
 * @returns {getKey.data}
 */
function getKey(data){
    for(var prop in data){
        if(data.hasOwnProperty(prop) && typeof(prop) !== 'function'){
            return prop;
        }
    }
}

/**
 * @param {type} str
 * @returns {String}
 */
function ucwords(str) {
 return (str + '')
    .replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1) {
      return $1.toUpperCase();
    });
}

/**
 * @author PHPJS site
 * @param {type} number
 * @param {type} decimals
 * @param {type} dec_point
 * @param {type} thousands_sep
 * @returns {unresolved}
 */
function number_format(number, decimals, dec_point, thousands_sep) {
  //  discuss at: http://phpjs.org/functions/number_format/
  // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: davook
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Theriault
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Michael White (http://getsprink.com)
  // bugfixed by: Benjamin Lupton
  // bugfixed by: Allan Jensen (http://www.winternet.no)
  // bugfixed by: Howard Yeend
  // bugfixed by: Diogo Resende
  // bugfixed by: Rival
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  //  revised by: Luke Smith (http://lucassmith.name)
  //    input by: Kheang Hok Chin (http://www.distantia.ca/)
  //    input by: Jay Klehr
  //    input by: Amir Habibi (http://www.residence-mixte.com/)
  //    input by: Amirouche
  //   example 1: number_format(1234.56);
  //   returns 1: '1,235'
  //   example 2: number_format(1234.56, 2, ',', ' ');
  //   returns 2: '1 234,56'
  //   example 3: number_format(1234.5678, 2, '.', '');
  //   returns 3: '1234.57'
  //   example 4: number_format(67, 2, ',', '.');
  //   returns 4: '67,00'
  //   example 5: number_format(1000);
  //   returns 5: '1,000'
  //   example 6: number_format(67.311, 2);
  //   returns 6: '67.31'
  //   example 7: number_format(1000.55, 1);
  //   returns 7: '1,000.6'
  //   example 8: number_format(67000, 5, ',', '.');
  //   returns 8: '67.000,00000'
  //   example 9: number_format(0.9, 0);
  //   returns 9: '1'
  //  example 10: number_format('1.20', 2);
  //  returns 10: '1.20'
  //  example 11: number_format('1.20', 4);
  //  returns 11: '1.2000'
  //  example 12: number_format('1.2000', 3);
  //  returns 12: '1.200'
  //  example 13: number_format('1 000,50', 2, '.', ' ');
  //  returns 13: '100 050.00'
  //  example 14: number_format(1e-8, 8, '.', '');
  //  returns 14: '0.00000001'

  number = (number + '')
    .replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}
