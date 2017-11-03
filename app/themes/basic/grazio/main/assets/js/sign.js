$(document).ready(function(){
    $("#sign-form").submit(function(e){
        var checkbox = document.getElementById('member-check');
        if(checkbox.checked){
            $('.choose').hide();
        }else{
            e.preventDefault();
            $('.choose').show();
        }
    });
})