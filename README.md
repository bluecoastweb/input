input
=====

### EE2 plugin to retrieve selected portions of the HTTP request.

Return the value of an HTTP GET parameter named `page`:

    {exp:input:get name="page"}

Return the value of an HTTP GET or POST parameter named `login`:

    {exp:input:request name="login"}

Return the value of HTTP Header named `SERVER_ADDR`:

    {exp:input:header name="SERVER_ADDR"}

Return the value of a cookie named `exp_chocolate_chip`:

    {exp:input:cookie name="chocolate_chip"}

Or use any of the above as a tag pair:

    {exp:input:parse type="cookie" name="peanut_butter"}
    
        The value of the exp_peanut_butter cookie is: {peanut_butter}

    {/exp:input:parse}

Specify the name of the interpolated variable if necessary:

    {exp:input:parse type="header" name="HTTP_REFERER" variable="referrer"}

        The value of the HTTP_REFERER (sic) header is: {referrer}

    {/exp:input:parse}


Grab the current url early -- rather than ultra late via the `current_url` global var:

    {exp:input:url}

Cookie note:

The `name` parameter of the cookie tag is without the EE cookie prefix -- by
default `exp_`. You can ascertain the effective EE cookie prefix by viewing the
output of the following tag:

    {exp:input:cookie_prefix}
