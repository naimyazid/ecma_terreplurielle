var audio = $('#audio').attr('src');

var wavesurfer = WaveSurfer.create({
    container: "#waveform",
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
            container: "#spectrogram",
            fftSamples: 512,
            labels: true
        }),
        WaveSurfer.timeline.create({
            container: '#timeline',
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


function wavesurferPatient(file) {
  var blob = null;
  var rawFile = new XMLHttpRequest();
  rawFile.open("GET", file);
  rawFile.responseType = "blob";
  rawFile.onload = function () {
    blob = rawFile.response;
    try {
      $('wave').css("height", "64px");
      wavesurfer.loadBlob(blob);
      setTimeout(function () {
          $("#chargement-patient").hide();
      }, 1000);
    } catch (err) {
      alert('une erreur est survenue!')
    }
  }
  rawFile.send();
    // $('wave').css("height", "64px");
    // wavesurfer.load(audio);
    // setTimeout(function () {
    //     $("#chargement-patient").hide();
    // }, 1000);
}


$(document).ready(function () {
  $("#chargement-patient").hide();
  //Spectro patient
  $('#player-patient').on('click', function () {
    $(this).replaceWith(
      '<button class="btn-sm" id="playRecord-patient">Play</button>'
    );
    $("#chargement-patient").show();
    wavesurferPatient(audio);
  });

  $('#playspectro-patient').on('click', '#playRecord-patient', function () {
    wavesurfer.playPause();
  });

});





