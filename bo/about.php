<script type="text/javascript">
var keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

function decode(input) {
   var output = "";
   var chr1, chr2, chr3;
   var enc1, enc2, enc3, enc4;
   var i = 0;

   // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
   input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

   do {
      enc1 = keyStr.indexOf(input.charAt(i++));
      enc2 = keyStr.indexOf(input.charAt(i++));
      enc3 = keyStr.indexOf(input.charAt(i++));
      enc4 = keyStr.indexOf(input.charAt(i++));

      chr1 = (enc1 << 2) | (enc2 >> 4);
      chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
      chr3 = ((enc3 & 3) << 6) | enc4;

      output = output + String.fromCharCode(chr1);

      if (enc3 != 64) {
         output = output + String.fromCharCode(chr2);
      }
      if (enc4 != 64) {
         output = output + String.fromCharCode(chr3);
      }
   } while (i < input.length);

   return output;
}
</script>


<br />
<div id="bo_heading">

   <span style="font-size: 14px;">Jernbane.Net</span>
   <img src="graphics/filler.gif" width="10px" height="23px" />
   
   <img src="graphics/jernbanenet_h28.gif" class="logo_align" />
</div>
<div class="bo_intro">
  <br />
  <?php
  include('about_txt.php');
echo nl2br($tekst);
?>
Du kan kontakte oss på <a class="bo" onfocus="if(this.blur)this.blur()" href="#" OnClick="javascript:location.href=(decode('bWFpbHRvOmplcm5iYW5lLm5ldEBnbWFpbC5jb20='))">
<script type="text/javascript">
document.write(decode('amVybmJhbmUubmV0QGdtYWlsLmNvbQ=='));
</script></a>
<br />
<br />
<br />

</div>
<br /><br />
