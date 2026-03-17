        $(document).ready(function () {
       
            $("img").addClass("img-responsive");
            $('#summernote').summernote({
              height: 300,                 // set editor height
              minHeight: null,             // set minimum height of editor
              maxHeight: null,             // set maximum height of editor
              focus: true,                 // set focus to editable area after initializing summernote
              callbacks: {
                onImageUpload: function(files) {
                  // Procesar carga de imágenes
                  for (let i = 0; i < files.length; i++) {
                    uploadImage(files[i]);
                  }
                }
              },
              popover: {
                image: [
                  ['imagesize', ['imagesize']],
                  ['float', ['floatLeft', 'floatRight', 'floatNone']],
                  ['remove', ['removeMedia']]
                ],
                link: [
                  ['link', ['linkDialogShow', 'unlink']]
                ],
                air: [
                  ['color', ['color']],
                  ['font', ['bold', 'italic', 'underline', 'clear']],
                  ['para', ['ul', 'ol', 'paragraph']],
                  ['table', ['table']],
                  ['insert', ['link', 'picture']]
                ]
              }
            });
         
            window.setTimeout(function() {
                $(".alert").fadeTo(1500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 2000);
         
        });

        /**
         * Función para cargar imágenes en Summernote
         */
        function uploadImage(file) {
          let data = new FormData();
          data.append("file", file);
          data.append("_token", $('meta[name="csrf-token"]').attr('content'));
          
          $.ajax({
            data: data,
            type: "POST",
            url: "/summernote/upload",
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
              $('#summernote').summernote("insertImage", url.link);
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.error('Error al cargar imagen:', errorThrown);
              console.error('Response:', jqXHR.responseJSON);
              alert('Error al cargar la imagen. Por favor intenta de nuevo.');
            }
          });
        }

        $(".delete").on("submit", function(){
            return confirm("Do you want to delete this item?");
        }); 
        
        $(".deleteuser").on("submit", function(){
            return confirm("WARNING: If you delete this user, all tickets and related comments to this user will be deleted. Are you sure?");
        });         

        $(".deletetickets").on("submit", function(){
            return confirm("WARNING: If you delete this tickets, all comments to this ticket will be deleted. Are you sure?");
        });