// Backup image loading issues
document.querySelectorAll('img').forEach(function (el, i) {
    el.setAttribute('onerror', 'this.src=\'https://via.placeholder.com/500?text=IMAGE+NOT+FOUND\'');
});

/**
* ================================================
* Popper
* ================================================
*/
import '../../../../node_modules/@popperjs/core/dist/umd/popper.js';

/**
* ================================================
* Bootstrap Js Components
* ================================================
*/
// import 'bootstrap/js/dist/alert';
import '../../../../node_modules/bootstrap/js/dist/button';
// import 'bootstrap/js/dist/carousel';
import '../../../../node_modules/bootstrap/js/dist/collapse';
import '../../../../node_modules/bootstrap/js/dist/dropdown';
import '../../../../node_modules/bootstrap/js/dist/modal';
import '../../../../node_modules/bootstrap/js/dist/offcanvas';
import '../../../../node_modules/bootstrap/js/dist/popover';
// import 'bootstrap/js/dist/scrollspy';
// import 'bootstrap/js/dist/tab';
// import 'bootstrap/js/dist/toast';
import '../../../../node_modules/bootstrap/js/dist/tooltip';

/**
* ================================================
* Form submition handling
* ================================================
*/
let reportForm = document.querySelector('#report-from');
if( document.body.contains(reportForm) ) {
  reportForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const reportForm = document.getElementById('report-from');
    const spinner = reportForm.querySelector('[type="submit"]');
    const formData = new FormData(reportForm);
    const endpoint = reportForm.getAttribute('action');

    spinner.setAttribute('disabled', 'disabled');
    spinner.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

    formData.append('action', 'report_product');

    fetch(endpoint, {
      method: "POST",
      body: formData
    })
    .then((result) => {
      if (result.status != 200) { 
        throw new Error("Bad Server Response"); 
      }
      return result.json();
    })
    .then((response) => {
      // console.log( JSON.parse( response ) );
      if( response == 'ok' ) {
        reportForm.reset();

        spinner.removeAttribute('disabled');
        spinner.innerHTML = '<i class="las la-paper-plane fs-5"></i> أرسل البلاغ';
        
        // console.log(response);
        alert('شكرا! تم تلقي بلاغك بنجاح.');
      } else {
        spinner.removeAttribute('disabled');
        spinner.innerHTML = '<i class="las la-paper-plane fs-5"></i> أرسل البلاغ';

        alert(response);
      }
    })
    .catch((error) => { 
      console.log(error); 
    });

  });
}

let messageForm = document.querySelector('#message-form');
if( document.body.contains(messageForm) ) {
  messageForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const messageForm = document.getElementById('message-form');
    const spinner = messageForm.querySelector('[type="submit"]');
    const formData = new FormData(messageForm);
    const endpoint = messageForm.getAttribute('action');

    spinner.setAttribute('disabled', 'disabled');
    spinner.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

    formData.append('action', 'message');

    fetch(endpoint, {
      method: "POST",
      body: formData
    })
    .then((result) => {
      if (result.status != 200) { 
        throw new Error("Bad Server Response"); 
      }
      return result.json();
    })
    .then((response) => {
      // console.log( JSON.parse( response ) );
      if( response == 'ok' ) {
        messageForm.reset();

        spinner.removeAttribute('disabled');
        spinner.innerHTML = '<i class="las la-paper-plane fs-5"></i> أرسل الرسالة';
        
        // console.log(response);
        alert('شكرا! تم إرسال رسالتك بنجاح، يمكنك متابعة ردود هذه المراسة من لوحة التحكم.');
      } else {
        spinner.removeAttribute('disabled');
        spinner.innerHTML = '<i class="las la-paper-plane fs-5"></i> أرسل الرسالة';

        alert(response);
      }
    })
    .catch((error) => { 
      console.log(error); 
    });

  });
}

let deletePost = document.querySelector('#delete-post');
if( document.body.contains(deletePost) ){
  deletePost.addEventListener('click', function(){
    const endpoint = deletePost.dataset.url;
    const redirect = deletePost.dataset.redirect;
    
    fetch(endpoint, {
      method: "GET"
    })
    .then((result) => {
      alert('تم حذف المنتج بنجاح!');
      window.location.href = redirect;
    })
    .catch((error) => { 
      console.log(error); 
    });
  });
}

