<?php



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$url = 'http://ec2-52-214-189-182.eu-west-1.compute.amazonaws.com/musicscorer/spiceContent.php';
 
//Initiate cURL.
$ch = curl_init($url);
 
//The JSON data.

 
$jsonData = '{
    "ResourceList1":"abc",
   "ResourceList":[
      {
         "ISRC":"ZA41S1801687",
         "ResourceCode":"1013140396",
         "ResourceType":"SoundRecording",
         "ResourceSubType":"MusicalWorkSoundRecording",
         "Title":"Lembaran Baru",
         "LanguageCodes":[
            "id"
         ],
         "CountryOfOrigin":[
            "ID"
         ],
         "Duration":249,
         "TerritoryCodes":[
            "ID"
         ],
         "Release":{
            "Title":"Lembaran Baru",
            "UPC":"",
            "ReleaseType":"Album",
            "ReleaseImageUrls":{
               "xs":"http://cdn.mziiki.com/101/3140/397/08/101314039708125_0.jpg",
               "s":"http://cdn.mziiki.com/101/3140/397/08/101314039708126_0.jpg",
               "m":"http://cdn.mziiki.com/101/3140/397/08/101314039708127_0.jpg",
               "l":"http://cdn.mziiki.com/101/3140/397/08/101314039708128_0.jpg"
            }
         },
         "DisplayArtists":[
            {
               "Name":"Adit Marciano",
               "Role":"MainArtist",
               "ArtistImageUrls":{
                  "xs":"http://cdn.mziiki.com/101/3140/423/08/101314042308125_0.jpg",
                  "s":"http://cdn.mziiki.com/101/3140/423/08/101314042308126_0.jpg",
                  "m":"http://cdn.mziiki.com/101/3140/423/08/101314042308127_0.jpg",
                  "l":"http://cdn.mziiki.com/101/3140/423/08/101314042308128_0.jpg"
               }
            }
         ],
         "Genres":[
            {
               "Genre":"Pop",
               "GenreImageUrls":{
                  "xs":"http://cdn.mziiki.com/707/0223/612/08/707022361208125_0.jpg",
                  "s":"http://cdn.mziiki.com/707/0223/612/08/707022361208126_0.jpg",
                  "m":"http://cdn.mziiki.com/707/0223/612/08/707022361208127_0.jpg",
                  "l":"http://cdn.mziiki.com/707/0223/612/08/707022361208128_0.jpg"
               }
            }
         ],	 
		"ResourceFiles": {
			"Artwork": "http://cdn.mziiki.com/101/3140/397/08/101314039708128_0.jpg",
			"OriginalTrack": "http://cdn.mziiki.com/101/3140/396/07/101314039607057_0.mp3",
			"Karaoke": "http://cdn.mziiki.com/101/3140/396/07/1013140396_01_030_audkrk.mp3",
			"Lyrics": "http://horizon.spiceafrica.com/lyrics/1013140396_01_030_lyrics.docx"
		},
         "status":true,
         "message":"Successfull"
      }
   ]
}';

//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonData);
 
//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);
 
//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
 
//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
 
//Execute the request
$result = curl_exec($ch);