# Multi-Authentication-Package-php
<h3>Authentication Package using</h3>

<p>pdf417 barcode (US Driver License)</p>
<p>code39 barcode (College IDs)</p>
<p>OpenID(various OpenID providers like Yahoo, steam, myspace, etc)</p>
<p>OAuth(clever)</p>

<h4>Libraries used:</h4>
<a href='https://github.com/PeculiarVentures/js-zxing-pdf417'>js-zxing-pdf417</a></br>
<a href='https://github.com/meltingice/CamanJS'>CamanJS</a></br>
<a href='https://github.com/jhuckaby/webcamjs'>WebcamJS</a></br>
<a href='https://github.com/serratus/quaggaJS'>QuaggaJS</a></br>
<a href='https://github.com/twbs/bootstrap'>Bootstrap</a></br>
<a href='https://github.com/matula/laravel-lightopenid'>LightOpenID</a></br>
<a href='https://github.com/Clever/clever-oauth-examples/tree/master/php'>Clever</a></br>

<h4>Steps</h4>

<h5>Clever - OAuth:</h5>

Note: A registered clever account has to exist to use this login feature.

<ul>
<li>Create an app for your website in <a href='https://clever.com/developers'>clever</a> developer console.</li>
<li>Create a redirect url</li>
<li>Note the client token and client secret.</li>
<li>Refer clever-example.php to see where to input the client token, client secret and redirect url.</li>
</ul>

Visit <a href='https://dev.clever.com/'>here</a> for more detailed information.

<h5>LightOpenID:</h5>


<ul>
<li>Create an account in any one of the OpenID providers. See <a href='http://openid.net/get-an-openid/'>here</a> for list of OpenID providers</li>
<li>Each provider has a specific OpenID url. Note that url and refer openid-example.php to see where to use it.</li>
</ul>

Visit <a href='https://github.com/iignatov/LightOpenID'>here</a> for more detailed information.

<h5>Pdf417 Barcode</h5>

<p>I added a little code to <a href='https://github.com/PeculiarVentures/js-zxing-pdf417'>js-zxing-pdf417</a></br> so that, a webcam can be used to read the barcode. Also I used camanJS to manipulate image from webcam in case the default image is not readable by the library. As an alternate method, an image can be uploaded too.</p>

<h6>Requirements:</h6> <p> Since the library needs an excellant quality image, a webcam with manual focus would be more appropriate to get a sharper image.</p>

<p>Refer pdf417-example.php to see the complete usage</p>




