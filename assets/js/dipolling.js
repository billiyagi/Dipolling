var submitVote = document.getElementById('submitVote');
function btnSubmit(){
    submitVote.classList.add('d-block');
}

menuAdminBtn.addEventListener('click', function(){
    theBody.classList.toggle('bg-shadow');
    menuAdmin.classList.toggle('dip-menu-show');
    if(logoAdminBtn.classList.contains('bi-chevron-right')){
        logoAdminBtn.classList.replace('bi-chevron-right','bi-chevron-left');
    }else if(logoAdminBtn.classList.contains('bi-chevron-left')){
        logoAdminBtn.classList.replace('bi-chevron-left','bi-chevron-right');
    }
})



document.onclick = function(e){
    if(e.target.id !== 'menuAdminBtn' && e.target.id !== 'menuAdmin'){
        theBody.classList.remove('bg-shadow');
        menuAdmin.classList.remove('dip-menu-show');
        logoAdminBtn.classList.replace('bi-chevron-left','bi-chevron-right');
    }
}
function closeNotif(){
    document.getElementById('notif').classList.remove('dip-notif-show');
}

const theLoader = document.getElementById('dip-loader');
function FormLoading(){
     theLoader.classList.replace('d-none', 'd-flex');
}
