(function() {
  'use strict';

  var ccmds = document.getElementsByClassName('cdel');
  var pcmds = document.getElementsByClassName('pdel');
  var goodbtn = document.getElementsByClassName('goodbtn');
  var goodbtn2 = document.getElementsByClassName('goodbtn2');
  var i;



  for (i = 0; i < pcmds.length; i++) {
     // alert("aa");
    pcmds[i].addEventListener('click', function(e) {
      e.preventDefault();
      //alert("い");
      if(confirm('本当によろしいですか？')) {
        // alert(this.dataset.id);
        document.getElementById('pform_' + this.dataset.id).submit();
      }
    });
  }

  for (i = 0; i < ccmds.length; i++) {
     // alert("あ");
    ccmds[i].addEventListener('click', function(e) {
      e.preventDefault();
      //alert("い");
      if(confirm('本当によろしいですか？')) {
        // alert(this.dataset.id);
        document.getElementById('cform_' + this.dataset.id).submit();
      }
    });
  }

  for (i = 0; i < goodbtn.length; i++) {
     // alert("あ");
    goodbtn[i].addEventListener('click', function(e) {
      e.preventDefault();
      // alert("い");
      //if(confirm('本当によろしいですか？')) {
        // alert(this.dataset.id);
        document.getElementById('goodbtn').submit();
      //}
    });
  }

  for (i = 0; i < goodbtn2.length; i++) {
     // alert("あ");
    goodbtn2[i].addEventListener('click', function(e) {
      e.preventDefault();
      // alert("い");
      // if(confirm('本当によろしいですか？')) {
      //   alert(this.dataset.id);
        document.getElementById('goodbtn2').submit();
      // }
    });
  }

})();
