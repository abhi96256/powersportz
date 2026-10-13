<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About us | Power Sportz';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
  <div class="row">
    <div class="col-md-12 about-sec">
      <section class="about-data">
        <h3>About Us</h3>
        <p> Power Sportz is an online video streaming platform. Power Sportz currently offers over 50,000 hours of TV content and movies, and every major sport covered live. Highly evolved video streaming technology and a high attention to quality of experience across devices and platforms, make Power Sportz the most complete video destination for Over The Top (OTT) video consumers. </p>
        <section class="about-data">
          <h4>A Video Experience Like No Other</h4>
          <p> Seamless Video Playback - Our adaptive video streaming technology ensures that the best possible video quality is played back automatically based on the available bandwidth, therefore making it a great video experience on both mobile networks as well as WiFi internet connections. Our video is optimized to play on mobile networks with inconsistent throughput so that our users don’t have to compromise on their experience on the low end, and play HD quality video on the top end of bandwidth availability. Additionally, our users can manually select the quality of video that suits their taste.</p>

          <p>  Smart Search - Content search on Power Sportz has been optimized to reduce complexity and delay in accessing content. Accurate search results, with lightning fast autocomplete suggestions navigate users to video with minimal navigation friction and ease of use. </p>
          <p> Friendly User Interface - Content organization on Power Sportz is a result of a thoughtful user experience approach and strong design principles that ensure that the user is not overwhelmed with the breadth of content available. Using a mix of algorithms and human curation, users at any stage of their interaction with Power Sportz will discover content and see their experience evolve with their interaction patterns over time. </p>

          <p> Hot Content Catalogue  offers the latest and popular TV, movies and knowledge-based content from India and the world. With content in 8 languages, spanning 15 TV channels, Power Sportz is home to some of the longest running, and highest rated TV content in the country. Our roster of the biggest names in Indian cinema makes Power Sportz the preferred destination for the biggest blockbusters from Bollywood and regional cinema.</p>
          <p> Originals - In our endeavour to drive meaningful engagement with our audience, Power Sportz is investing in generating content keeping in mind the sentiments and attitudes of our consumers and has enjoyed great success with original programming content </p>
        </section>
    </div>
  </div>
  <script src="<?php echo Yii::$app->request->baseUrl ?>/backend/web/js/google_platform.js" async defer></script>
  <script src="<?php echo Yii::$app->request->baseUrl ?>/backend/web/js/google_client.js?onload=handleClientLoad"></script>
  <script src="<?php echo Yii::$app->request->baseUrl ?>/backend/web/js/google_client_platform.js" async defer></script>
  <?php
  $this->registerJs("
var clientId = '10412981768-7q9q88kkdmm1b529mg9aktk7gb1nhe22.apps.googleusercontent.com';
// Enter the API key from the Google Develoepr Console - to handle any unauthenticated
// requests in the code.
// The provided key works for this sample only when run from
// https://google-api-javascript-client.googlecode.com/hg/samples/authSample.html
// To use in your own application, replace this API key with your own.
var apiKey = 'AIzaSyBgMwxzKI70CM5wb2772vtxW6TKC0N_pNg';
// To enter one or more authentication scopes, refer to the documentation for the API.
var scopes = 'https://www.googleapis.com/auth/plus.me';    
function handleClientLoad() {
  console.log('load');
   gapi.client.setApiKey(apiKey);
}
$('.google').click(function(){
 gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, 
              function(authresult){
                if (authResult && !authResult.error) {
                   console.log('login !!!');
                    } else {
                    console.log('Not login');
                  }
              });
});
");
  