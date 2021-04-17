var waveTherapist = WaveSurfer.create({
    container: "#waveform-therapist",
    barHeight: 2,
    barGap: 6,
    partialRender: true,
    scrollParent: true,
    waveColor: 'grey',
    progressColor: '#0015fc',
    cursorColor: 'black',
    plugins: [
        WaveSurfer.spectrogram.create({
            wavesurfer: wavesurfer,
            container: "#spectrogram-therapist",
            fftSamples: 512,
            labels: true
        }),
        WaveSurfer.timeline.create({
            container: '#timeline-therapist',
            timeInterval: timeInterval,
            primaryLabelInterval: primaryLabelInterval,
            secondaryLabelInterval: secondaryLabelInterval,
            primaryColor: '#76e6bc',
            secondaryColor: 'green',
            primaryFontColor: '#000000',
            secondaryFontColor: 'aqcua',
        })

    ]
});

function wavesurferTherapist() {
  $('wave').css("height", "64px");
  var audioTherapist = window.localStorage.getItem("urlTherapist");
  waveTherapist.load(audioTherapist);
  setTimeout(function () {
      $("#chargement-therapist").hide();
  }, 1000);
}

$(document).ready(function () {
// Cacher le bouton spectrogramme du Thérapeute au chargemnt de la page
  $("#player-therapist").hide();
  $("#chargement-therapist").hide();

  $('#playspectro-therapist').on("click", "#record-therapist", function(){
    $(this).replaceWith('<button class="btn-sm" id="stop">Stop</button>');
    $("#chargement-therapist").find('p').html('Enregistrement du fichier audio ...');
    Fr.voice.record();
  }); 

  $('#playspectro-therapist').on("click", "#stop", function () {
    
    $("#chargement-therapist").show();
    Fr.voice.exportMP3(function (url) {
      window.localStorage.setItem("urlTherapist", url);
    }, "URL");
    setTimeout(function () {
      $("#chargement-therapist").hide();
      $("#chargement-therapist").find('p').html('Chargment du spectrogramme ...');
      $("#player-therapist").show('slow');
      $("#stop").hide('slow');
    }, 5000);
  });

  $('#playspectro-therapist').on('click', "#player-therapist", function () {
      $(this).replaceWith(
          '<button class="btn-sm" id="playRecord-therapist">Play</button>'
      );
      $("#chargement-therapist").show();
      wavesurferTherapist();
  });

  $('#playspectro-therapist').on('click', '#playRecord-therapist', function () {
      waveTherapist.playPause();
  });

});