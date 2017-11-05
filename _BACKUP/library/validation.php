<?

function isValidEmailAddress($emailAddress) {

	if(filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) return true;
	else return false;
}