// PREFS
	function verifPrefs(f)
	{
		$("#editUserInfo").addClass("invalidPrefsForm");
		var email  = document.getElementById('email').value;
		var firstName = document.getElementById('firstName').value;
		var familyName = document.getElementById('familyName').value;
		var checkValidEmail = document.getElementById('email').validity.valid;
		var checkValidFirstName = document.getElementById('firstName').validity.valid;
		var checkValidFamilyName = document.getElementById('familyName').validity.valid;

		if(email != "" && firstName != "" && familyName != "" && checkValidEmail == true && checkValidFirstName == true && checkValidFamilyName == true)
			return true;
		else
			return false;
	}

	// TO UPPER CASE 
		function upperCaseFirstName(champ) {
			var champTest = champ.split(" ");
			var champFinal = new Array();
			for(var i = 0; i < champTest.length; i++)
			{
				champFinal = champFinal.concat(champTest[i].charAt(0).toUpperCase() + champTest[i].substring(1).toLowerCase());
			}
			var champFinal2 = champFinal.join(' ');
			document.getElementById('firstName').value = champFinal2;
		}

		function upperCaseFamilyName(champ) {
			var champTest = champ.split(" ");
			var champFinal = new Array();
			for(var i = 0; i < champTest.length; i++)
			{
				champFinal = champFinal.concat(champTest[i].toUpperCase());
			}
			var champFinal2 = champFinal.join(' ');
			document.getElementById('familyName').value = champFinal2;
		}
	// TO UPPER CASE
// PREFS


// CONTACT
	function verifContact(f)
	{
		$("#formContact").addClass("invalidContactForm");
		var nameContact  = document.getElementById('name_contact').value;
		var mailContact = document.getElementById('mail_contact').value;
		var messageContact = document.getElementById('message_contact').value;

		var checkValidNameContact = document.getElementById('name_contact').validity.valid;
		var checkValidMailContact = document.getElementById('mail_contact').validity.valid;
		var checkValidFamilyMessageContact = document.getElementById('message_contact').validity.valid;

		if(nameContact != "" && mailContact != "" && messageContact != "" && checkValidNameContact == true && checkValidMailContact == true && checkValidFamilyMessageContact == true) {
			return true;
		}
		else {
			return false;
		}
	}

	// TO UPPER CASE
	function upperCaseNomContact(champ) {
		var champTest = champ.split(" ");
		var champFinal = new Array();
		for(var i = 0; i < champTest.length; i++)
		{
			champFinal = champFinal.concat(champTest[i].charAt(0).toUpperCase() + champTest[i].substring(1).toLowerCase());
		}
		var champFinal2 = champFinal.join(' ');
		document.getElementById('name_contact').value = champFinal2;
	}

	function upperCaseTextAreaContact(champ) {
		var champFinal = champ.charAt(0).toUpperCase() + champ.substring(1).toLowerCase();
		document.getElementById('message_contact').value = champFinal;
	}
	// TO UPPER CASE
// CONTACT
