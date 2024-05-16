var isInAuthorizationWindow = false;
var isIndex = false;

class DropMenuControl{
    #isAuth;
    #menu;
    constructor(isAuth){
        this.#menu = $('#dropdownAccountMenu');
        isAuthorized();
    }
    setAuth(istrue){
        //console.log(this.#isAuth, istrue);
        if (istrue != this.#isAuth){
            this.#isAuth = istrue;
            this.updateVisable();
        }
        else
            this.#isAuth = istrue;
        
       //console.log(this.#isAuth, istrue);
    }
    updateVisable(){
        //console.log(this.#isAuth);
        if (this.#isAuth) {
            this.#menu.addClass('active');
        }
        else{
            this.#menu.removeClass('active');
        }
    }
}

class AuthorizationWindow
{
    #authorizationWindow;
    #signIn;
    #signUp;
    #toggleSignIn;
    #toggleSignUp;
    #isSingInMode;
    #isActive;
    constructor(){
        this.#isSingInMode = false;
        this.#isActive = false;
        this.#authorizationWindow = document.getElementById('authorizationWindow');
        this.#authorizationWindow.hidden = !this.#isActive;
        this.#signIn = document.getElementById('signIn')
        this.#signUp = document.getElementById('signUp')
        this.#toggleSignIn = document.getElementById('toggleSignIn')
        this.#toggleSignUp = document.getElementById('toggleSignUp')
        this.changeAuthWindowMode()


        $('#signInButton').click(signInHandler)
        $('#signUpButton').click(signUpHandler)
        $('#toSignIn').click(authModeHandler)
        $('#toSignUp').click(authModeHandler)
    }
    changeAuthWindowMode(){
        this.#isSingInMode = !this.#isSingInMode;
        this.#signIn.hidden = !this.#isSingInMode;
        this.#signUp.hidden = this.#isSingInMode;
        this.#toggleSignUp.hidden = !this.#isSingInMode;
        this.#toggleSignIn.hidden = this.#isSingInMode;
    }
    authModeClickHandler(){
        this.changeAuthWindowMode();
    }
    changeVisableAuthWindow(){    
        this.#authorizationWindow.hidden = this.#isActive;
        this.#isActive = !this.#isActive;
    }
}

const authWindow = new AuthorizationWindow();
const dropMenu = new DropMenuControl();




async function ajax(success, error, complete, method ,action, data)
{
    let Request = new XMLHttpRequest();
    Request.open(method, action, true);    


    Request.onreadystatechange = function(){
        if (this.readyState == 4)
        {
                let response_message = JSON.parse(Request.responseText);
            if (this.status == 200){
                if (success!== undefined)
                    success(response_message);
            } else
            { 
                if (error!== undefined)
                error(response_message);
            }        
            if (complete!== undefined)
                complete(response_message);        
    }}


    Request.send(data);

}










//signOutHandler();
// another funcs
async function isAuthorized(){
    let result;
    await $.ajax({
        url:'../php/back/checkauth.php',
        type: 'POST',
        dataType: 'json',
        data: {},
        success (data){
            if (data !== null && data.status === true) {
                console.log(data.info.userId);
            }
            
            result = data.status;
            dropMenu.setAuth(result);
        }
    })
    //console.log('isAuth:',result );
    return result;
}

function clearForms() {
    // Получаем ссылку на форму
    $('form').each(function(){
        $(this).trigger('reset');
    });
}
 
async function getUserId(){
    let result;
    await $.ajax({
        url:'../php/back/getUserId.php',
        type: 'POST',
        dataType: 'json',
        data: {},
        success (data){
            result = data.info.id;
        }
    })
    return result;
}

//
$('#findform').on('submit', function(e) {
    e.preventDefault();
    findHandler();
});
$(document).on('click', '#find, #exitButton, #createAnnounce, #accountMenu, #signInButton, #signUpButton, #toSignIn, #toSignUp, #edit, #searchInput', function(e) {
    e.preventDefault();
});
// header events
$('#find').click(findHandler)
$('#buttonHome').click(buttonHomeHandler)
$('#createAnnounce').click(createAnnounceHandler)
$('#accountMenu').click(accountMenuHandler)
$('#edit').click(editHandler)
$('#signOut').click(signOutHandler)
$('#findLikeMe').click(findLikeMeHandler);
// auth window events
$('#exitButton').click((e)=>{authWindow.changeVisableAuthWindow(); clearForms();})

//main container events
$('.item').click(itemClickHandler);

//header handlers

function findHandler(){
    if (!isIndex) {
        window.location.href = './index.php?keywords='+ $('#searchInput').val();
        return;
    };
    
    $('#mainContainer').empty();
    const likeMe = false;
    const quantity = 5;
    let keywords = $('#searchInput').val().split(' ');

    if (keywords.length>1){
        keywords = keywords.map(keyword => {
            if (!keyword.startsWith('-'))
                return '+'+keyword;
            return keyword;
        });
    }
    req =  new FormData();
    req.keywords = keywords
    req.quantity = quantity
    req.likeMe = likeMe
    ajax(
        (data)=>{
        if (Array.isArray(data.info)){
            data.info.forEach(user => {
                addItem(user);
            });
        }else
            addItem(data.info);
        
        $('html, body').scrollTop(0);
        },
        (data)=>{
            console.log(data);
        },
        undefined,
        'POST',
        '../php/back/getpublicusertdata.php',
       req       
    )
    // $.ajax({
    //     url:'../php/back/getpublicusertdata.php',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: {
    //         keywords,
    //         quantity,
    //         likeMe
    //     },
    //     success (data){
    //         console.log(data);
    //         if (Array.isArray(data.info)){
    //             data.info.forEach(user => {
    //                 addItem(user);
    //             });
    //         }else
    //             addItem(data.info);
            
    //         $('html, body').scrollTop(0);
    //     }
    // });
}

function findLikeMeHandler(){
    if (!isIndex) {
        window.location.href = './index.php?likeMe='+true;
        return;
    };
    $('#mainContainer').empty();
    const likeMe = true;

    ajax(
        (data)=>{
            console.log(data);
            if (data.info != null)
                if (Array.isArray(data.info)){
                    data.info.sort(function(a, b) {
                        return b.priority - a.priority;
                    });
                    data.info.forEach(user => {
                        addItem(user);
                    });
                }else
                    addItem(data.info);
        },
        undefined,
        undefined,
        'POST',
        '../php/back/getpublicusertdata.php',
        {likeMe}
    );



    // $.ajax({
    //     url:'../php/back/getpublicusertdata.php',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: {
    //         likeMe
    //     },
    //     success (data){
    //         console.log(data);
    //         if (data.info != null)
    //             if (Array.isArray(data.info)){
    //                 data.info.sort(function(a, b) {
    //                     return b.priority - a.priority;
    //                 });
    //                 data.info.forEach(user => {
    //                     addItem(user);
    //                 });
    //             }else
    //                 addItem(data.info);
                
    //         $('html, body').scrollTop(0);
    //     }
    // });

}


function buttonHomeHandler(){
    
}
async function authHandler(){
    if (!await isAuthorized()){
        authWindow.changeVisableAuthWindow();
        return true;
    }
    return false;
}

function redirectToIndex(){
    window.location.href = '../php/index.php';
}
function redirectToUserPage(userId){
    window.location.href = '../php/page.php?id='+ userId;
}

async function createAnnounceHandler(){
    if(await authHandler())
        return;
        redirectToUserPage(await getUserId());
}
async function accountMenuHandler(){
    if(await authHandler())
        return;
}

// auth window handlers
async function signInHandler(){
    const login = $('input[ name="loginSignIn"]').val();
    const password = $('input[ name="passwordSignIn"]').val();
    clearForms();
    ajax(
       (data) => {
            const box = $('#signInmsg');
            console.log(data);
            box.removeClass('msg-active');
            box.text('');
            authWindow.changeVisableAuthWindow();
            findHandler();
       },
       (data) => {
        
            console.log(data);
            const box = $('#signInmsg');
            box.addClass('msg-active');
            box.text(data.msg);
        },
        async () =>{
            if(await isAuthorized()){
                console.log('Auth successed');
            }
        },
        'POST',
        '../php/back/signin.php',
        {
            login : $('input[ name="loginSignIn"]').val(),
            password : $('input[ name="passwordSignIn"]').val(),
        },
    );



    // await $.ajax({
    //     url:'../php/back/signin.php',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: {
    //         login,
    //         password
    //     },
    //     async success (data){
    //         const box = $('#signInmsg');
    //         console.log(data);
    //         if (data.status)
    //         {
    //             box.removeClass('msg-active');
    //             box.text('');
    //             authWindow.changeVisableAuthWindow();
    //             findHandler();
    //         }
    //         else{
    //             const box = $('#signInmsg');
    //             box.addClass('msg-active');
    //             box.text(data.msg);
    //         }
    //         if(await isAuthorized()){
    //             console.log('Auth successed');
    //         }
    //     }
    // })
}

function signUpHandler(){
    $.ajax({
        url:'../php/back/signup.php',
        type: 'POST',
        dataType: 'json',
        data: {
            email : $('#signUp input[name="email"]').val(),
            login : $('#signUp input[ name="login"]').val(),
            username : $('#signUp input[ name="username"]').val(),
            password : $('#signUp input[ name="password"]').val(),
            rpassword : $('#signUp input[ name="rpassword"]').val(),
            birthday : $('#signUp input[ name="birthday"]').val(),
            gender : $('#signUp input[ name="gender"]:checked').val(),
            color : $('#signUp select[ name="color"]').val(),
            sport : $('#signUp select[ name="sport"]').val(),
            film : $('#signUp select[ name="film"]').val(),
            music : $('#signUp select[ name="music"]').val(),
            art : $('#signUp select[ name="art"]').val(),
            hobbie : $('#signUp select[ name="hobbie"]').val(),
        },
        success (data){
            console.log(data);
            const box = $('#signUpmsg');
            if (data.status)
            {
                box.removeClass('msg-active');
                box.text('');
                authWindow.changeAuthWindowMode();
            }
            else{
                box.addClass('msg-active');
                box.text(data.msg);
            }
        },
        async complete (data){
            //console.log(data);
            //clearForms();
        }
    })
}

async function signOutHandler(){
    $.ajax({
        url:'../php/back/signout.php',
        type: 'POST',
        dataType: 'json',
        data: {},
        async complete (){
            isAuthorized();
            findHandler();
        }
    });
   
}

function authModeHandler(){
    authWindow.authModeClickHandler();
}

function editHandler(){
    console.log('clickEdit');
    window.location.href = '../php/edit.php';
}

// main container handlers
function itemClickHandler(event){
    const targetId = $(event.target).closest('.item').attr('id').split('_')[1];
    redirectToUserPage(targetId);
}


//////////////////
const imageMap = {
    'male': 'man.png',
    'female': 'woman.png',
    'secret': 'secret.png'
};
function addItem(user){
    //console.log(user);
    

    const item = $('<div>').addClass('item').attr('id', 'id_'+user.data.id);
    ///////
    const personalContainer = $('<div>').addClass('personalContainer');

    const avatar = $('<div>').addClass('avatar');
    avatar.append($('<img>').attr('src', '../images/'+imageMap[user.data.gender]).attr('alt', 'avatar'));
    personalContainer.append(avatar);

    const username = $('<p>').addClass('username').text(user.data.username);
    personalContainer.append(username);

    item.append(personalContainer);
    ///////

    const textContainer = $('<div>').addClass('textContainer');

    const text = $('<div>').addClass('text');
    let description = user.description;
    if (description != null && description !== undefined) {
        description = description.substring(0,400)+'...';
    }
    text.append($('<p>').text(description));
    textContainer.append(text);

    item.append(textContainer);
    ///////
    
    const interests = $('<div>').addClass('interests');
    Object.entries(user.interests).forEach(([key, value]) => {
        
        if (value !== 'null' && value !== null) {
            interests.append($('<p>').text(key + ': ' + value));
        }
    });
    
    item.append(interests);

    item.click(itemClickHandler);
    $('#mainContainer').append(item);
    //console.log(item);
    
}

///edit page handlers
$('#reset').click(resetClickHandler)
function resetClickHandler(e){ 
    e.preventDefault();
    if (!isAuthorized()){
        redirectToIndex();
        return;
    }
    clearForms();
    loadForm();
}

function loadForm(){
    $.ajax({
        url:'../php/back/getusetdata.php',
        type: 'POST',
        dataType: 'json',
        data: {},
        success (data){
            resetForm(data.info);
        }
    })
}
function resetForm(user){
    $('.avatar img').attr('src', '../images/'+imageMap[user.data.gender]);

    const inputs = {};
    $('.edit input').each(function() {
        inputs[$(this).attr('name')] = $(this);
    });
    //console.log(inputs);
    const selects = {};
    $('.edit select').each(function() {
        selects[$(this).attr('name')] = $(this);
    });
    Object.entries(user.data).forEach(([key, value]) => {
            if (key in inputs){
                //console.log(key, value);
                if (key === 'birthday')
                    return;
                inputs[key.toLowerCase()].val(value);
            }else{if (key === 'gender'){
                document.getElementById('edit'+user.data.gender).checked = true;
            }
        }
    });
    if ('birthday' in inputs){
        if (user.data.birthday !== undefined && user.data.birthday !== null)
            inputs['birthday'].val(new Date(user.data.birthday).toISOString().slice(0, 10))
    }
    Object.entries(user.interests).forEach(([key, value]) => {
        if (key in selects){
            if (value == null)
                value = 'null'
            selects[key.toLowerCase()].val(value)
        }
    });
    $('#myTextarea').val(user.description);
}

