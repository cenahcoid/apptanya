var fileDisplayPicture = new FileReader();
var ufsmax = 10;
var frmax = 400;
var wmax = 1080;
var hmax = 720;
var main_id = 'idisplay_picture';

//define function for checking file extension type
!function(n){n.fn.checkFileType=function(e){return e=n.extend({allowedExtensions:[],success:function(){},error:function(){}},e),this.each(function(){n(this).on("change",function(){var s=n(this).val().toLowerCase(),t=s.substring(s.lastIndexOf(".")+1);-1==n.inArray(t,e.allowedExtensions)?(e.error(),n(this).focus()):e.success()})})}}(jQuery);

// check file type extension when currentElement is changed
$(function() {
  var currentElement = $('#'+main_id)
	currentElement.checkFileType({
		allowedExtensions: ['jpg', 'jpeg', 'png'],
		success: function() {
			console.log('Max file size: '+ufsmax+'MB');
			let current_file_size = currentElement[0].files[0].size/1920/1080;
			current_file_size = current_file_size.toFixed(2);
			if(current_file_size > ufsmax){
				console.log('File too big, maximum is '+ufsmax+'MB');
				currentElement.val('');
				return false;
			}else if (current_file_size <= 0){
				console.log('unselected file');
				currentElement.val('');
				return false;
			}else{
				fileDisplayPicture.readAsDataURL(currentElement[0].files[0]);
			}
		},
		error: function() {
			console.log('Invalid image file, please choose other file!');
		}
	})
});

// method for read input file as url for img src element
function readURLImage(input, target) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#'+target).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

// for file upload, convert base64 value of Image.src to file fake path
function DataURIToBlob(dataURI) {
  const splitDataURI = dataURI.split(',')
  const byteString = splitDataURI[0].indexOf('base64') >= 0 ? atob(splitDataURI[1]) : decodeURI(splitDataURI[1])
  const mimeString = splitDataURI[0].split(':')[1].split(';')[0]

  const ia = new Uint8Array(byteString.length)
  for (let i = 0; i < byteString.length; i++)
      ia[i] = byteString.charCodeAt(i)

  return new Blob([ia], { type: mimeString })
}

// attach fileDisplayPicture onload
fileDisplayPicture.onload = function (event) {
  var image = new Image();
  
  image.onload=function(){
    document.getElementById(main_id+"_original").src = image.src;
    var canvas = document.createElement("canvas");
    var context = canvas.getContext("2d");
		console.log('image.width: '+image.width);
		console.log('image.height: '+image.height);
		var sx = 1;
		if (image.width >= wmax && image.height >= hmax) {
			if (image.width >= image.height) {
				sx = wmax / image.width;
				sx = Math.round((sx + Number.EPSILON) * 100) / 100;
			} else {
				sx = hmax / image.height;
				sx = Math.round((sx + Number.EPSILON) * 100) / 100;
			}
		} else if(image.width >= wmax && image.height < hmax) {
			sx = wmax / image.width;
			sx = Math.round((sx + Number.EPSILON) * 100) / 100;
		} else if(image.width < wmax && image.height >= hmax) {
			sx = hmax / image.height;
			sx = Math.round((sx + Number.EPSILON) * 100) / 100;
		}
		canvas.width = image.width*sx;
		canvas.height = image.height*sx;

		console.log('canvas.width: '+canvas.width);
		console.log('canvas.height: '+canvas.height);
    context.drawImage(image, 0, 0, image.width, image.height, 0, 0, canvas.width, canvas.height);
    document.getElementById(main_id+"_resized").src = canvas.toDataURL();
  }
  image.src = event.target.result;
	console.log('final image.width: '+image.width);
	console.log('final image.height: '+image.height);
};

$("#"+main_id).on('change',function(e){
  e.preventDefault();
  readURLImage(this, 'display_picture_show');
});

$('.btn-ganti-display-picture').on('click', function(e){
  e.preventDefault();
  var c = confirm('Yakin ingin ganti foto profil?\n(anda menyetujui ketentuan layanan aplikasi ini)');
  if (!c) {
    return false
  }
  $('#'+main_id).trigger('click');
});

$('#'+main_id).on('change',function(){
	setTimeout(function(){
		$('#display_picture_form').trigger('submit');
	},678);
});

$("#display_picture_form").on('submit', function(e){
  e.preventDefault();
  let display_picture_resized = $("#"+main_id+"_resized").attr("src");
  if (display_picture_resized.length <= 3){
    gritter('<h4>Perhatian</h4><p>File foto belum dipilih</p>', 'info');
    setTimeout(function(){
      gritter('<h4>Info</h4><p>Silakan memilih file pas foto terlebih dahulu</p>', 'default');
      setTimeout(function(){
        $('#ifoto').trigger('click');
      },678);
    },678);
    return false;
  }

  NProgress.start();
	$(".btn-submit").prop("disabled", true);
	$(".icon-submit").addClass("fa-circle-o-notch fa-spin");
	$('#display_picture_show').attr('src', 'https://karirsbp-prod.b-cdn.net/skin/front/img/ajax-loader.gif');

  var url = '<?=base_url("api_web/display_picture/change")?>';
  var fd = new FormData();
  fd.append("display_picture", DataURIToBlob($("#"+main_id+"_resized").attr("src")), "display-picture.jpg");
  $.ajax({
		type: $(this).attr('method'),
    url: url,
    data: fd,
    processData: false,
    contentType: false,
    success: function(respon){
      if(respon.status == 200){
        $('#display_picture_show').attr('src', respon.data.display_picture);
				gritter("<h4>Berhasil</h4><p>Foto profil berhasil diganti</p>", 'success');
        setTimeout(function(){
          window.location = '<?=base_url('profil')?>';
        }, 4567);
      }else{
        setTimeout(function(){
          gritter("<h4>Gagal</h4><p>"+respon.message+"</p>", 'warning');
        }, 666);
      }
			$(".icon-submit").removeClass("fa-spin");
			$(".icon-submit").removeClass("fa-circle-o-notch");
			$(".btn-submit").prop("disabled",false);
			NProgress.done();
    },
    error:function(){
      setTimeout(function(){
        gritter("<h4>Error</h4><p>Tidak dapat ganti foto saat ini, coba beberapa saat lagi</p>", 'danger');
      }, 666);
  		$(".icon-submit").removeClass("fa-spin");
  		$(".icon-submit").removeClass("fa-circle-o-notch");
  		$(".btn-submit").prop("disabled", false);
  		NProgress.done();
    }
  });
});
