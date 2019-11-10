// //fonction ajax avec jQuery

// //créer une variable avec la selection du bouton pour poster le message
// let sendMessage = document.querySelector('#submitButton');
// var time = setInterval(getMessage, 2000);
// let message = document.querySelector('#messageInput form textarea').val();
// sendMessage.addEventListener('submit', e =>{
//     e.preventDefault();
//     addMessage()
// })

// function addMessage(){
//     $.ajax({
//         url: '/ajaxMessage',
//         method: 'POST',
//         dataType: 'json',
//         data: $this.serialize(),
//         success: function(){
//             //code en cas de succès
//             console.log('ok');
//             getMessage();              
//         },
//         error: function(){
//             document.querySelector('#errorView').innerHTML = '<p class="">Une erreur est survenue !</p> ';
//             console.log(errors);
//         }
//     });  
// }

// function getMessage(){
//     $.ajax({
//         url: '/ajaxMessage',
//         method: 'POST',
//         dataType: 'json',
//         data: $this.serialize(),
//         success: function(){
//             //code en cas de succès
//             $('#messageDisplay').append(data.result)
                
//         },
//         error: function(){
//             document.querySelector('#errorView').innerHTML = '<p class="">Une erreur eest survenue !</p> '
//         }
        
//     });
    
// }