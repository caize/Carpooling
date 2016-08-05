'use strict';
window.success = function(data){
	$('#modal-success').modal('show');
  $('#modal-success').find('.modal-body').html(data.msg);
  setTimeout(function(){
  	if(data.url==''){
  		location.reload();
  	}else{
  		window.location.href = data.url;
  	}
  },2*1000);
}
window.error = function(data){
	$('#modal-danger').modal('show');
  $('#modal-danger').find('.modal-body').html(data.msg);
  setTimeout(function(){
      $('#modal-danger').modal('hide');
  },2*1000);
}
