var choose = document.querySelectorAll('input[type="radio"]')
  , form = document.querySelector('form.choose');

function submit () {
  form.submit();
}

for (var i = choose.length - 1; i >= 0; i--) {

  if (window.addEventListener) {
    choose[i].addEventListener('click', submit, false)
  } else if (window.attachEvent) {
    choose[i].attachEvent('onclick', submit);
  } else {
    choose[i].onclick = submit;
  }

};