$(function(){
    
    var uploadPath = $('#add-realization-form #file-upload-path').val();
    
    $('#body .content .admin-option-content').not('.admin-option-content:eq(0)').hide();
    
    $('#admin-menu li a').click(function(e){
        
        e.preventDefault();
        
        $('#body .content .admin-option-content').hide();
        
        $($(this).attr('href')).fadeIn('fast');
        
    });
    
    //kalendarz
    $.datepicker.regional['pl'];
    $('#date').datepicker({ 
        dateFormat : 'yy-mm-dd'
    });
    
    //tooltip
    $('#used-technologies').attr('title', 'Tagi przedzielone przecinkami lub zatwierdzone klawiszem ENTER');
    $('#used-technologies[title]').tooltip({
        position: {
          my: "center bottom-20",
          at: "center top",
          using: function( position, feedback ) {
            $( this ).css( position );
            $( "<div>" )
              .addClass( "tooltip" )
              .appendTo( this );
          }
        }
    });
    
    //tagi
    $('#used-technologies').tagsManager({
        //tagClass : "tm-tag-small",
        tagsContainer : $('#tags'),
        hiddenTagListId: 'used-technologies-hidden'
    });
    
    //kasowanie bledow przy tagach, gdy jakis wstawiony
    $('#used-technologies').keyup(function(e){
        
        if(e.which == 13 || e.which == 188)
        {
            if($('#used-technologies-error-message').text() != '' && $('#used-technologies-hidden').val() != '')
            {
                $('#used-technologies-error-message').hide();
                $('#used-technologies-error-message').text('');
                $('#used-technologies-error-message').show();
            }
        }
        
    });
    
    //file upload
    $('#file').uploadify({
        'uploader': './js/ui/uploadify/uploadify.swf',
        'script': './scripts/fileUpload.php',
        'cancelImg': './js/ui/uploadify/cancel.png',
        'folder': uploadPath,
        'auto': false,
        'multi': false,
        'removeCompleted': false,
        'queueID': 'file-queue',
        'onComplete': function(event, data, fileObj) 
        {
            var title = $('#title').val();
            var image = fileObj.name;
            var text = $('#text').val();
            var date = $('#date').val();
            var used_technologies = $('#used-technologies-hidden').val().replace(",", ", ");
            
            addRealization(title, image, text, date, used_technologies);
        } 
    });
    
    //wysyłanie formatki dodawania realizacji
    $('#add-realization-form #submit').live("click", function(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement(); //uaktualnienie el powiazanego z CKEDITOR
        
        //kasowanie bledow
        $('#title-error-message').text('');
        $('#file-error-message').text('');
        $('#text-error-message').text('');
        $('#date-error-message').text('');
        $('#used-technologies-error-message').text('');
        
        if($('#title').val() != '' && $('#text').val() != '' && $('#date').val() != '' && $('#used-technologies-hidden').val() != '')
        {   
            $('#file').uploadifyUpload();
        }
        else
        {
            if($('#title').val() == '')
            {
                $('#title-error-message').text('Podaj tytuł!');
            }
            
            if($('#text').val() == '')
            {
                $('#text-error-message').text('Uzupełnij treść opisu!');
            }
            
            if($('#date').val() == '')
            {
                $('#date-error-message').text('Uzupełnij datę wdrożenia!');
            }
            
            if($('#used-technologies-hidden').val() == '')
            {
                $('#used-technologies-error-message').text('Podaj przynajmniej jedną technologię wykonania realizacji!');
            }
        }
        
    });
    
});

function addRealization(title, image, text, date, used_technologies)
{
    $.post("index.php?action=add_realization", { 
        title: title,
        image: image,
        text: text,
        date: date,
        used_technologies: used_technologies
    }, function(resp){
        if(resp)
        {
            $('body').append('<div id="dialog-wrapper" title="Dodanie realizacji">Pomyślnie dodano realizację!</div>');

            $('#dialog-wrapper').dialog({

                'modal' : true,
                'autoOpen' : true,
                'width' : 500,
                'buttons': [ { text: "Ok", click: function() { $('#dialog-wrapper').remove(); } } ],
                close : function( event, ui ){

                    $('#dialog-wrapper').remove();

                }

            });
        }
        else
        {
            //dodac pola do bledow w formatce i komunikat bledu tutaj!!!!!!!!!!!!!!!!!
        }
    });
}