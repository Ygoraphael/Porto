<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<div style="height:200px; margin-bottom:25px;">
	<div class="wide">
		<div class="col-xs-5 line"><hr></div>
		<div class="col-xs-2 logo">CONTACT US</div>
		<div class="col-xs-5 line"><hr></div>
	</div>
</div>
<style>
.wide {
  width:100%;
  height:100%;
  height:calc(100% - 1px);
  background-image:url('<?php echo base_url()?>img/we-want-to-be-a-partner-e1461679264525.jpg');
  background-size:cover;
}

.wide img {
  width:100%;
}

.logo {
  color:#fff;
  font-weight:800;
  font-size:14pt;
  padding:25px;
  text-align:center;
  margin-top:80px;
  font-family: Montserrat,sans-serif;
  font-size: 19px;
  font-weight: 400;
  line-height: 1.5;
}

.line {
  padding-top:20px;
  white-space:no-wrap;
  overflow:hidden;
  text-align:center;
  margin-top:80px;
}
</style>
<div class="container">
	<div class="col-lg-8">
		<form id="contact-form">
			<p>Hello European World,</p>
			<p>My <label for="your-name">name</label> is
			<input type="text" name="your-name" id="your-name" minlength="3" placeholder="(your name here)" required> and</p>
			<p>my
				<label for="email">email address</label> is
				<input type="email" name="your-email" id="email" placeholder="(your email address)" required>
			</p>
			<p> I have a
			<label for="your-message">message</label> for you,</p>
			<p>
				<textarea name="your-message" id="your-message" placeholder="(your msg here)" class="expanding" required></textarea>
			</p>
			<p>
				<button type="submit">
				<svg version="1.1" class="send-icn" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100px" height="36px" viewBox="0 0 100 36" enable-background="new 0 0 100 36" xml:space="preserve">
				<path d="M100,0L100,0 M23.8,7.1L100,0L40.9,36l-4.7-7.5L22,34.8l-4-11L0,30.5L16.4,8.7l5.4,15L23,7L23.8,7.1z M16.8,20.4l-1.5-4.3
				l-5.1,6.7L16.8,20.4z M34.4,25.4l-8.1-13.1L25,29.6L34.4,25.4z M35.2,13.2l8.1,13.1L70,9.9L35.2,13.2z" />
				</svg>
				</button>
			</p>
		</form>
	</div>

	<div class="col-lg-4">
		<div class="text-center header">
			<h2 class="home-widget-title">Global Fragments, Lda</h2>
			<div class="cta-description">
				<p>VAT. 513666613</p>
			</div>
		</div>
		<div class="panel-body text-center" style="color:#A28D5D;">
			<h2>Address</h2>
			<div>
			Av. da Boavista nº 1167 6ºAndar - S/6.1<br>
			4100-130 Porto, Portugal<br><br>
			(+351) 224 100 682<br>
			info@globalfragments.com<br>
			</div>
			<br>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4248.193296439724!2d-8.641109928089572!3d41.15795975934626!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd2465a02fb16e0d%3A0x7ce7bc0a133484a8!2sAv.+da+Boavista+1167%2C+4100-130+Porto!5e0!3m2!1spt-PT!2spt!4v1494348738159" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	</div>
</div>

<script>
// Auto resize input
function resizeInput() {
    $(this).attr('size', $(this).val().length);
}

$('input[type="text"], input[type="email"]')
    // event handler
    .keyup(resizeInput)
    // resize on page load
    .each(resizeInput);


console.clear();
// Adapted from georgepapadakis.me/demo/expanding-textarea.html
(function(){
  
  var textareas = document.querySelectorAll('.expanding'),
      
      resize = function(t) {
        t.style.height = 'auto';
        t.style.overflow = 'hidden'; // Ensure scrollbar doesn't interfere with the true height of the text.
        t.style.height = (t.scrollHeight + t.offset ) + 'px';
        t.style.overflow = '';
      },
      
      attachResize = function(t) {
        if ( t ) {
          console.log('t.className',t.className);
          t.offset = !window.opera ? (t.offsetHeight - t.clientHeight) : (t.offsetHeight + parseInt(window.getComputedStyle(t, null).getPropertyValue('border-top-width')));

          resize(t);

          if ( t.addEventListener ) {
            t.addEventListener('input', function() { resize(t); });
            t.addEventListener('mouseup', function() { resize(t); }); // set height after user resize
          }

          t['attachEvent'] && t.attachEvent('onkeyup', function() { resize(t); });
        }
      };
  
  // IE7 support
  if ( !document.querySelectorAll ) {
  
    function getElementsByClass(searchClass,node,tag) {
      var classElements = new Array();
      node = node || document;
      tag = tag || '*';
      var els = node.getElementsByTagName(tag);
      var elsLen = els.length;
      var pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)");
      for (i = 0, j = 0; i < elsLen; i++) {
        if ( pattern.test(els[i].className) ) {
          classElements[j] = els[i];
          j++;
        }
      }
      return classElements;
    }
    
    textareas = getElementsByClass('expanding');
  }
  
  for (var i = 0; i < textareas.length; i++ ) {
    attachResize(textareas[i]);
  }
  
})();

</script>

<style>

#contact-form {
  max-width: 90%;
  margin: 0 auto;
  text-align:center;
  color:#A28D5D;
}

#contact-form *{
  color:#A28D5D;
}

#contact-form label {
  font-weight: 400;
  cursor: pointer;
}

#contact-form textarea,
#contact-form input {
  border: none;
  outline: none;
  border-radius: 0;
  text-align: center;
  background: none;
  font-weight: 700;
  font-family: 'Lato', georgia;
  font-size: 25px;
  max-width: 90%;
  padding: 1rem;
  border: 2px dashed rgba(255, 255, 255, 0);
  box-sizing: border-box;
  cursor: text;
}

#contact-form textarea {
  text-align: left;
  /* overflow:hidden; */
  
  resize: none;
  width: 90%;
  border-color: rgba(255, 255, 255, 0)
}

#contact-form textarea:focus {
  background-color: rgba(255, 255, 255, 0.2);
  border: 2px dashed rgba(255, 255, 255, 1);
}

#contact-form textarea:focus:required:valid {
  border: 2px solid rgba(255, 255, 255, 0);
  border-bottom: 2px solid rgba(255, 255, 255, 0.2);
}

#contact-form textarea:required:valid {
  border-bottom: 2px solid rgba(255, 255, 255, 0.2);
}

#contact-form input {
  border-bottom: 2px dashed rgba(255, 255, 255, 0.5);
}

#contact-form input:required,
#contact-form textarea:required {
  border-bottom: 2px dashed rgba(255, 255, 255, 0.5);
}

#contact-form input:focus {
  border-bottom: 2px dashed rgba(255, 255, 255, 1);
  background-color: rgba(255, 255, 255, 0.2);
}

#contact-form input:required:valid {
  border-bottom: 2px solid rgba(255, 255, 255, 0.2);
}

#contact-form input:required:invalid {
}

::-webkit-input-placeholder {
  text-align: center;
  font-style: italic;
  font-weight: 400;
}

:-moz-placeholder {
  /* Firefox 18- */
  
  text-align: center;
  font-style: italic;
  font-weight: 400;
}

::-moz-placeholder {
  /* Firefox 19+ */
  
  text-align: center;
  font-style: italic;
  font-weight: 400;
}

:-ms-input-placeholder {
  text-align: center;
  font-style: italic;
  font-weight: 400;
}

.expanding {
  vertical-align: top;
}

.send-icn {
  fill: rgba(162, 141, 93, 1)
}

.send-icn:hover {
  fill: rgba(162, 141, 93, 1)
  cursor: pointer;
}

button {
  background: none;
  border: none;
  outline: none;
  margin: 2vmax;
}

button:hover small {
  opacity: 1;
}

small {
  display: block;
  opacity: 0;
}

.website {
  opacity: 1;
  font-size: 16px;
  color: white;
  position: relative;
  text-align: center;
  display: block;
  margin-top: 7%;
  
}

.website a {
  color: white;
}

</style>