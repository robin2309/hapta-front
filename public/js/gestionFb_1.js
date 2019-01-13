//initialise
(function(d, s, id){
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement(s); 
	js.id = id;
	js.src = "//connect.facebook.net/fr_FR/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


//on fait un traitement different en fonction de la reponse renvoyee par FB
function statusChangeCallback(response) {
	//console.log('statusChangeCallback');
	if (response.status === 'connected') {
		document.getElementById('decoLoginFb').innerHTML = '<a href="#" onClick="logout();"> <i class="fa fa-power-off"></i> Déconnexion</a>';
		//document.getElementById('infosconnectFb').className = '';
		//document.getElementById('infosconnectFb').innerHTML = '';
		// sans les commentaire le site public n'affiche plus le facebook login
		////////////////////////
		//On recupere les donnees de l'user ::::
		/////////////////////
		getProfilUser(false);
		recupDonneesUser();		
		$("#test").show();
		$("#loginFb").hide();
	} else if (response.status === 'not_authorized') {// TESTER
		document.getElementById('loginFb').innerHTML = '<a href="#" onClick="login();" >  <i class="fa fa-facebook-square" title="Connect"></i> <span class="connection"> Connexion</span></a>';	
		$("#test").hide();
		deleteCookie("idUserFbHapta");
	} else {
		document.getElementById('loginFb').innerHTML = '<a href="#" onClick="login();" >  <i class="fa fa-facebook-square" title="Connect"></i> <span class="connection"> Connexion</span></a>';
		$("#test").hide();
		deleteCookie("idUserFbHapta");
	}
}

//quand l'user clique sur connexion, on check son statut
function checkLoginState() {
    FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
    });
}

//recup idApp from layout
function getAppIdFromLayout(){
	return $('#idFacebookAppForScript').text();
}

//initailise le SDK facebook
window.fbAsyncInit = function() {
	FB.init({
		appId      : getAppIdFromLayout(),
		//cookie 	 : true, //pour setter un cookie: utiliser FB.LOGIN() //!!!\\ //!!!\\
		xfbml      : true,
		version    : 'v2.1'
	});

	//check le statut de l'user a l'initialisation
	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});
};
  
function login(){
	FB.login(function(response){
		if(response.authResponse){
			checkLoginState();
			getProfilUser(true);
			/*$.ajax({
				url: "",
				context: document.body,
				success: function(s,x){
					$(this).html(s);
				}
			});*/
		} else{
			console.log('Erreur login');
		}
	},{scope:'public_profile,rsvp_event'});//,user_events,friends_events
}


function logout(){
	/*FB.logout(function(response){			
		location.reload();
	});*/
	FB.api("/me/permissions", "delete", function(response){
		deleteCookie("idUserFbHapta");
		location.reload();
    });
}

//a faire quand l'user est connecte ET a autorise l'appli
function getProfilUser(fromLogin) {
	FB.api('/me', function(response) {
		var userFbId = response.id;
		createCookie("idUserFbHapta",userFbId, 7);
		var userNom = response.name;
		var userNom = userNom.split(" ");
		document.getElementById('nom').innerHTML = userNom['0'] + ' <span class="caret"></span>';
		if(fromLogin){ window.location.reload();}
	});
	document.getElementById('decoLoginFb').innerHTML = '<a href="#" onClick="logout();"> <i class="fa fa-power-off"></i> Déconnexion</a>';
	$("#loginFb").hide();
}

function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function deleteCookie( name ) {
	document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
  
function authJeuConcours(postId,eventId){
	FB.login(function(response) {
        if (response.authResponse) {
            getProfilUser();
            likeJeuConcours(postId,eventId);
        }
    }, {scope:'public_profile,email,rsvp_event,user_birthday'});//publish_actions,
}  

function likeJeuConcours(postId,eventId){
	var requeteLike = "/" +postId+ "/likes";
	var params = {};

	aleatoire = Math.floor(Math.random()*2)
	switch(aleatoire){
	case 0:params['message'] = 'Je tente ma chance !';break;
	case 1:params['message'] = 'Hapta !';break;
	}
	
    FB.api('/me', 'get', function(me){
	    if(me.id){
			FB.api(requeteLike+'/?fields=id','get',function(userGoing){
				//var userId;
				for(var x=0; x < userGoing.data.length; x++)
				{ //check si l'user a deja participe a l'event
					if(me.id === userGoing.data[x].id){//l'user a deja participe
						document.getElementById("jeux"+eventId).innerHTML = "<a class='linkgame' target='_BLANK' >TU PARTICIPES  <i class='fa fa-trophy'></i></a>";
						document.getElementById("jeuxmenu"+eventId).innerHTML = "<a class='linkgame' target='_BLANK' style='margin-right:194px;'>TU PARTICIPES  <i class='fa fa-trophy'></i></a>";
						//document.getElementById(idEvent).innerHTML = '<div style="margin-top:34px;"></div>';
						return;
					}
				}//l'user n'a pas participe au jeu concours
				FB.api(requeteLike, "POST", function(response) {
					//console.log(response);	
					if(response && !response.error) {
						//console.log('liked');
						FB.api(postId+"/comments","POST",params, function(responseComm){
							if (responseComm && !responseComm.error) {
								//console.log('commentey');
								alert('Nous avons envoyé votre reponse a Facebook');
								document.getElementById("jeux"+eventId).innerHTML = "<a class='linkgame' target='_BLANK' >TU PARTICIPES  <i class='fa fa-trophy'></i></a>";
								document.getElementById("jeuxmenu"+eventId).innerHTML = "<a class='linkgame' target='_BLANK' style='margin-right:194px;'>TU PARTICIPES  <i class='fa fa-trophy'></i></a>";
								//console.log("Post's link :: https://facebook.com/HaptaLyon/posts/"+postId);
								
							} else {
								console.log(responseComm);
								alert("Erreur comment!");
							}
						});
					} else {
						console.log(response);
						alert("Erreur like!");
					}
				});
			});
	    }
    });

}

// recupération de l'id event et de l'acces pour envoyer la réponse a FB avec doRsvp
function rsvp(idEvent) {
    FB.login(function(response) {
        if (response.authResponse) {
            getProfilUser();
            doRsvp(idEvent);
        }
    }, {scope:'public_profile,email,rsvp_event,user_birthday'});//publish_actions,
}

// Faire participer l'user a l'event envoi directement la réponse à facebook
function doRsvp(idEvent) {
    FB.api('/me', 'get', function(me){
	    if(me.id)
        {
			FB.api('/'+idEvent+'/attending/?fields=id','get',function(userGoing){
				for(var x=0; x < userGoing.data.length; x++)
				{ //check si l'user a deja participe a l'event
					if(userFbId === userGoing.data[x].id)
					{
						for(var y = 0; y < 2; y++)
						{
							document.getElementById("participe"+idEvent).innerHTML = "<div class=\"rsvp_event\">Tu participes</div>";
							document.getElementById("menu"+idEvent).innerHTML = "<div class=\"rsvp_event\">Tu participes</div>";
						}
						return;
					}
				}
				//s'il n'a pas deja participe :
				FB.api('/'+ idEvent +'/attending', 'post', { message: ''}, function(response) {
			    	//console.log(response);
			        if (!response || response.error) {
			            alert("Nous ne pouvons pas envoyer votre réponse. Veuillez aller directement sur facebook pour vous inscrire.");
			        } else {
			            document.getElementById("participe"+idEvent).innerHTML = "<div class=\"rsvp_event\">Tu participes</div>";
			            document.getElementById("menu"+idEvent).innerHTML = "<div class=\"rsvp_event\">Tu participes</div>";
			        }
			    });
			});
        }
    });
}

function recupDonneesUser(){
	//requete FB pour recup le profil public (avec date naissance et email)
	FB.api('/me','get', function(info){
		if (!info || info.error) {
			//console.log('nein');
		} else {
			var fbId = info.id;
			var nomFull = info.name;
			var email = info.email;
			var dateNaissance = info.birthday;
			var dateNaissanceBonFormat = null;
			if(typeof dateNaissance != 'undefined'){
				//date au format YYYY-MM-DD
				dateNaissanceBonFormat = dateNaissance.substr(6,4) +'-'+ dateNaissance.substr(0,2) +'-'+ dateNaissance.substr(3,2);
			}
			if(typeof email == 'undefined'){
				email = null;
			}
			$.ajax({
				// URL
				type: "POST",
				url: 'js/saveUserFbData.php?fbId='+ fbId +'&email='+ email +'&dateNaissanceBonFormat='+ dateNaissanceBonFormat +'&nomFull='+ nomFull,
				success: function(data){
					//console.log(data);
				},
				
				error: function(){
				}
				//requete GET avec fbId, nomFull, email et dateNaissanceBonFormat 
				//envoyer la requete a saveUserFbData
			});
		}
	});
}

	/*params['name'] = 'NOM EVENT - CLUB';
	params['description'] = 'DJs presents';
	params['link'] = 'http://haptalyon.fr';
	params['caption'] = 'HaptaLyon';

	var requeteInfoPoste = "/" + eventId+ "/";
	FB.api(requeteInfoPoste, "GET", function(response){
		   if (!response || response.error) {
	   		console.log('erreur dans recup info event');
	   } else {
		   params['picture'] = response.images[2].source;
		   //console.log(response.images[3].source);
		   FB.api('/me/feed', 'post', params, function(response) {
			  if (!response || response.error) {
			    console.log('erreur dans share');
			  } else {
			    console.log('shared');
			  }
		   });
		}
	});*/