// Set a cookie
function setCookie(key, value) {
    $.cookie(key, value, { expires : 10 }); // 10 day
}

// Read the cookie
function getCookie(key) {
    return $.cookie(key);
}

// Remove the cookie
function removeCookie(key) {
    $.removeCookie(key);
}
