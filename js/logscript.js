$(function(){
   
   $('#log-form #submit').live("click", function(){
       
       //zerowanie bledow
       $('#login-error-message').text('');
       $('#password-error-message').text('');
       $('#log-error-message').text('');
       
       if($('#login').val() == '' || $('#password').val() == '')
       {
           if($('#login').val() == '')
           {
               $('#login-error-message').text('Podaj login!');
           }
           
           if($('#password').val() == '')
           {
               $('#password-error-message').text('Podaj hasło!');
           }
       }
       else
       {
           $.post("index.php?action=login", { login : $('#login').val(), password : $('#password').val() }, function(resp){
               
              if(resp == 1)
              {
                  location.href = "index.php?view=admin";
              }
              else if(resp == 0)
              {
                  $('#log-error-message').text('Nieprawidłowy login i/lub hasło!');
              }
               
           });
       }
       
   });
   
   $('#logout-but').click(function(){
       
       $.get("index.php", { action : 'logout' }, function(){
           
           $('#body').load('index.php?view=admin #log-form-wrapper');
           
       });
       
   });
   
   //wyslanie formatki po nacisnieciu entera
   $('input').live("keydown", function(e){
       
       if(e.which === 13)
       {
           $('#log-form #submit').click();
       }
       
   });
   
});