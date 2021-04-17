$(document).ready(function(){
    $('#remote').on("click", "#record", function(){
        $(this).replaceWith('<i class="fas fa-compact-disc fa-2x" id="save"></i>');
        Fr.voice.record();
    });
    

    $('#remote').on("click", "#save", function(){
        $(this).replaceWith('<i class="fas fa-microphone fa-2x" id="record"></i>');
        function upload(blob){
            var formData = new FormData();
            formData.append('file', blob);

            $.ajax({
                url: "/api/audio",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                error: function(err){
                    alert("Quelque chose s'est mal passé. Veuillez enregistrer à nouveau.")
                },
                success: function() {
                    alert("Votre enregistrement a bien été éffectué !");
                }
            });
        }
        Fr.voice.exportMP3(upload, "blob");
    });


});
