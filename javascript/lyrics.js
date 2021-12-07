let yt;
$(document).ready(async function(){
  const videoId = window.location.search.split('=')[1];
  if ($(".fa-plus").length > 0) {
    $("#vidId").attr("value", videoId)
  }
  console.log(videoId);
  await getSong(videoId)
  document.getElementById('target').appendChild( document.getElementById('to_be_moved') )

  Timer = setInterval(() => {
    timer()
  }, 500);

  var slider = document.getElementById("myRange");
  var output = document.getElementById("time");
  slider.oninput = function() {
    clearInterval(Timer);
    output.innerHTML = fancyTimeFormat(this.value);
    var value = (this.value-this.min)/(this.max-this.min)*100
    this.style.background = 'linear-gradient(to right, #82CFD0 0%, #82CFD0 ' + value + '%, #fff ' + value + '%, white 100%)'
  }
  slider.onchange = function() {
    player.seekTo(slider.value);
    Timer = setInterval(() => {
      timer()
    }, 500);
  }
  setTimeout(() => {
    var DurationInSeconds = player.getDuration()
    var FancyDuration = fancyTimeFormat(player.getDuration())
    $(".slider").attr('max', DurationInSeconds)
    $(".totDuration").text(FancyDuration)
  }, 3000);

  $('#playAndPause').on('click', function(e){
    if ($(this).attr("class") == "fas fa-play fa-lg") {
      $(this).attr("class", "fas fa-pause fa-lg")
      play()
    }
    else{
      $(this).attr("class", "fas fa-play fa-lg")
      pause()
    }
  });
});
let ytid;
async function getSong(id) {
    var token = "gqefLsr-j3RSR4AHtaEkdQ_UAoDhcUudk0qnYJzxKBYZiLmie3xcDrFg5oC-qVoD";

    let response = await fetch(`https://api.genius.com/songs/${id}?access_token=${token}`);
    let data = await response.json();
    const titleWfeat = data.response.song.title_with_featured;
    const img = data.response.song.header_image_thumbnail_url;
    const artist = data.response.song.primary_artist.name;
    const views = data.response.song.stats.pageviews;
    const medias = data.response.song.media;
    
    medias.forEach(element => {
      if (element.provider == "youtube") {
        ytid = element.url.split('=')[1];
      }
    });
    if (ytid == undefined) {
      document.querySelector(".content").innerHTML = "Music not available";
    }
    const string = `
    <div class="search-item">
      <img src="${img}" alt="cover image">
      <div class="info">
          <h1>${titleWfeat}</h1>
          <h2>By: ${artist}</h2>
          <h3>Popularity: ${toPrefix(views)}</h2>
      </div>
    </div>`
    let showResults = document.querySelector("#song");
    showResults.innerHTML = string;
    yt = ytid;
    musicPlayer();
}

function musicPlayer() {
    // 2. This code loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;
function onYouTubeIframeAPIReady() {
  player = new YT.Player('player', {
    height: '390',
    width: '640',
    videoId: yt
  });
}
function play() {
 player.playVideo();
}
function pause() {
 player.pauseVideo();
}

// let timerbetwen = 0;
function timer() {
  if (ytid == undefined) {
    return;
  }
  var slider = document.getElementById("myRange");
  var output = document.getElementById("time");
  var TimeInSeconds = !player.getCurrentTime ? 0 : player.getCurrentTime();
  var FancyTime = fancyTimeFormat(TimeInSeconds);
  output.innerHTML = FancyTime;
  slider.value = TimeInSeconds;
  var value = (slider.value-slider.min)/(slider.max-slider.min)*100
  slider.style.background = 'linear-gradient(to right, #82CFD0 0%, #82CFD0 ' + value + '%, #fff ' + value + '%, white 100%)'
}

function fancyTimeFormat(duration)
{   
    // Hours, minutes and seconds
    var hrs = ~~(duration / 3600);
    var mins = ~~((duration % 3600) / 60);
    var secs = ~~duration % 60;

    // Output like "1:01" or "4:03:59" or "123:03:59"
    var ret = "";

    if (hrs > 0) {
        ret += "" + hrs + ":" + (mins < 10 ? "0" : "");
    }

    ret += "" + mins + ":" + (secs < 10 ? "0" : "");
    ret += "" + secs;
    return ret;
}

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