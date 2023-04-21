btnClose = document.getElementsByClassName('btn-close')[0];
alertDismiss = document.getElementsByClassName('alert-dismissible')[0];
btnClose.addEventListener('click', function(){
  alertDismiss.style.display = 'none';
});
