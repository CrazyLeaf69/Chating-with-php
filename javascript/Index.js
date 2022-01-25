$(document).ready(function(){
  var $this = document.querySelector("input");
  if ($this.value.length > 0) {
    const val = $this.value;
    search(val)
  }
});
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
if (event.target == modal) {
  modal.style.display = "none";
}
}
let ResultList = [];

// $('input').on('input', function(e){
//     var $this = $(this);
//     clearTimeout($this.data('timeout'));

//     $this.data('timeout', setTimeout(function(){
//         ResultList = [];
//         const val = document.querySelector("input").value;
//         search(val)
//     }, 500));
  
// });

$('#searchButton').on('click', function(e){
var $this = document.querySelector("input");
ResultList = [];
const val = $this.value;
search(val)
});
document.addEventListener('keydown', function (event) {
if (event.keyCode == 13) {
  $("#searchButton").click();
}
});

async function search(search) {
var token = "gqefLsr-j3RSR4AHtaEkdQ_UAoDhcUudk0qnYJzxKBYZiLmie3xcDrFg5oC-qVoD";

let response = await fetch(
  "https://api.genius.com/search?access_token=" +
    token + "&q=" + encodeURIComponent(search) + "&per_page=20"
);
let data = await response.json();
// console.log(data);
// console.log("Found this:\n");
data.response.hits.forEach((element, i) => {
  const title = element.result.title;
  const ArtistName = element.result.primary_artist.name;
  const url = element.result.url;
  // picture sorting
  const songURL = element.result.song_art_image_thumbnail_url
  const picZize = songURL.split(".")[songURL.split(".").length-2]
  const midleX = parseInt(picZize.split("x")[1])
  const img = (midleX<320 && midleX>280 && midleX != NaN) ? songURL : "./images/noimage.jpg" ;
  // ---------------------
  const pgwiews = element.result.stats.pageviews;
  const videoId = element.result.id
  // console.log(`${i + 1}: ${title} by ${ArtistName}`);
  ResultList.push({
    title: title, artist: ArtistName, 
    url: url, img: img, wiews: pgwiews, vidId: videoId});
});
sendToSite()
}
function sendToSite() {
  let stringList = "";
  ResultList.forEach(element => {
      stringList+=(`
      <div class="search-item">
        <img src="${element.img}" alt="cover image" href="${element.url}">
        <div class="info">
          <h1>${element.title}</h1>
          <h4>Artist: ${element.artist}</h4>
          <p>Popularity: ${toPrefix(element.wiews)}</p>
          <br>
          <div class="gotolyrics">Go to song --></div><br>
        </div>
      </div>
      `)
  });
  let showResults = document.querySelector("#ResultList");
  while (showResults.firstChild) showResults.removeChild(showResults.firstChild);
  if (!ResultList.length) {
      showResults.innerHTML = "No songs were found"
  } 
  else {
      showResults.innerHTML = (stringList)
  }
  // console.log($("#ResultList .search-item").length);
  $(".gotolyrics").click(function() {
    var i = $(this).parent().parent().index();
    const item = ResultList[i].vidId
    // await localStorage.setItem('videoId', item);
    window.location.href = `lyrics.php?song=${item}`;
  });

}

// 2. This code loads the IFrame Player API code asynchronously.
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;
function onYouTubeIframeAPIReady() {
 player = new YT.Player('player', {
   height: '390',
   width: '640',
   videoId: 'QMokMQ8Bu7Y'
 });
};
function play() {
player.playVideo();
};
function pause() {
player.pauseVideo();
};

function toPrefix (labelValue) {
if (labelValue === undefined) {
  return "unavailable"
}
// Nine Zeroes for Billions
return Math.abs(Number(labelValue)) >= 1.0e+9

? (Math.abs(Number(labelValue)) / 1.0e+9).toFixed(2) + "B"
// Six Zeroes for Millions 
: Math.abs(Number(labelValue)) >= 1.0e+6

? (Math.abs(Number(labelValue)) / 1.0e+6).toFixed(2) + "M"
// Three Zeroes for Thousands
: Math.abs(Number(labelValue)) >= 1.0e+3

? (Math.abs(Number(labelValue)) / 1.0e+3).toFixed(2) + "K"

: Math.abs(Number(labelValue));

}