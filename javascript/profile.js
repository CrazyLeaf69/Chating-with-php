$(document).ready(async function(){
  var token = "gqefLsr-j3RSR4AHtaEkdQ_UAoDhcUudk0qnYJzxKBYZiLmie3xcDrFg5oC-qVoD";
  songIdArray = $('.vidIdsOfPlaylist').text().split(' | ');
  if (songIdArray[0] == "") {
    songIdArray.splice(0, 1);
  }
  songIdArray.forEach(element => {
    Promises.push( fetch(`https://api.genius.com/songs/${element}?access_token=${token}`) );
  });
  Promise.all( Promises )
  .then( files => {
    files.forEach(file=>{
      process ( file.json() )
    })
    sortAndDisplay();
  })
  .catch(err=>{

  });
  let process = (prom) => {
    prom.then(data=>{
      if (data.meta.status == 200) {
        getSongInfo(data)
      }
    })
  }
  $('.vidIdsOfPlaylist').text('');
});
let Promises = [];
let resultValues = [];
let songIdArray;
function getSongInfo(data, i) {
    const titleWfeat = data.response.song.title_with_featured;
    const img = data.response.song.header_image_thumbnail_url;
    const artist = data.response.song.primary_artist.name;
    const medias = data.response.song.media;
    const views = data.response.song.stats.pageviews;
    const songid = data.response.song.id;
    medias.forEach(element => {
      if (element.provider == "youtube") {
        ytid = element.url.split('=')[1];
      }
    });
    resultValues.push({songid: songid, titleWfeat: titleWfeat, 
    img: img, artist: artist, medias: medias, views: views})
}

function sortAndDisplay() {
  setTimeout(() => {
    if (resultValues.length != songIdArray.length) {
      // results not ready yet
      sortAndDisplay();
      return;
    }
    // results ready
    for (let i = 0; i < songIdArray.length; i++) {
      const OrderedId = songIdArray[i];
      for (let j = 0; j < resultValues.length; j++) {
        const element = resultValues[j];
        if (element.songid == OrderedId) {
        showResults = document.querySelector(".popularList");
        showResults.innerHTML += `
        <tbody class="popularItem">
          <tr id="pad">
            <td class="nm">${i+1}</td>
            <td class="thumbnail fonts">
              <img class='playlist-img' src="${element.img}" alt="song image">
            </td>
            <td class="ellipsis fonts" style="width: 40%;">
              <a href="lyrics.php?song=${element.songid}" style="color: black;">
              <span class="title">${element.titleWfeat}</span>
            </td></a>
            <td class="ellipsis fonts" style="width: 26%;">
              <span class="artist">${element.artist}</span>
            </td>
            <td class="ellipsis fonts">
              <span style="text-align: right;">${toPrefix(element.views)}</span>
            </td>
            <td class="ellipsis fonts remove">
              <span>
                <button class="Remove-From-Playlist"><i class="fas fa-trash-alt"></i></button>
              </span>
            </td>
          </tr>
        </tbody>`;
        // avsluta loopen
        j = resultValues.length;
        }
      }
    }
    $(".Remove-From-Playlist").click(function() {
      var i = $(this).parent().parent().parent().parent().index();
      var form = document.getElementById("form-id");
      songIdArray.splice(i-1, 1);
      $(".playlist").attr("value", songIdArray.join(" | "));
      document.getElementById("hiddenBtn").addEventListener("click", function () {
        form.submit();
      });
      document.getElementById("hiddenBtn").click();
    });
  }, 0);
}

// -------------------------------------------------
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