var form = document.querySelector('form');

var email = document.querySelector('.email');
var passwordinput = document.querySelector('.passwordinput');
var password = document.querySelector('.realpassword');

form.onsubmit = function (e) {
  
  e.preventDefault();
  
  var ep = email.value + '*' + passwordinput.value;
  
  if (password.value == '') {
    password.value = md5(ep);
  }

  form.submit();
  
}