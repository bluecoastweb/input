input
=====

### EE2 plugin to retrieve selected portions of the HTTP request.

Return the value of an HTTP GET parameter named "page":

    {exp:input:get name="page"}

Return the value of an HTTP GET or POST parameter named "login":

    {exp:input:request name="login"}

Return the value of HTTP Header named "SERVER_ADDR":

    {exp:input:header name="SERVER_ADDR"}

Return the value of a cookie named "exp_chocolate_chip":

    {exp:input:cookie name="chocolate_chip"}

Or use any of the above as a tag pair:

    {exp:input:parse type="cookie" name="peanut_butter"}
    
        The value of the exp_peanut_butter cookie is: {peanut_butter}

    {/exp:input:parse}

Specify the name of the interpolated variable if necessary:

    {exp:input:parse type="header" name="HTTP_REFERER" variable="referrer"}

        The value of the HTTP_REFERER (sic) header is: {referrer}

    {/exp:input:parse}
